<?php

namespace App\Http\Controllers;

use App\Http\Requests\Passenger\SearchFlightRequest;
use App\Models\Airport;
use App\Models\Flight;
use App\Models\FlightTicketType;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\Http\SoapClientService;
use App\Services\Soap\SoapRequestBuilder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class FlightController extends Controller
{
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $soapRequestBuilder;

    
    public function __construct(SoapRequestBuilder $soapRequestBuilder)
    {
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->soapRequestBuilder = $soapRequestBuilder;
    }

    

    /**
     * Search for flights based on provided criteria.
     */

    
    public function searchFlights(SearchFlightRequest $request)
    {


        $departureDateTime = $request->input('departure_date');
        $ArrivalDateTime = $request->input('arrival_date');
        $destinationLocationCode = $request->input('arrival_airport');
        $originLocationCode = $request->input('departure_airport');

        $quantity = $request->input('passengers');
        
        $tripType = $request->input('trip_type');

        $validated = $request->validated();

      
        $travelerInformation = $validated["travelerInformation"];
        $travelerInformation_count = count($travelerInformation);

      

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailability';

        if ($request->input('trip_type') == "ONE_WAY") {
            $xml = $this->soapRequestBuilder->GetFlightOneWay($departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType);
        } else  if ($request->input('trip_type') == "ROUND_TRIP") {
            $xml = $this->soapRequestBuilder->GetFlightRoundTrip($departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType,  $ArrivalDateTime);
        } else {
            $multiDirectionalFlights = $validated['multi_directional_flights'];

            $xml = $this->soapRequestBuilder->GetFlightMultiCity( $multiDirectionalFlights, $travelerInformation, $tripType);
        }

        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            
            // dd($response);
            // return $response;

            $result = "";

            if ($request->input('trip_type') == "ONE_WAY") {
                $originDestinationOptionList = $response['Availability']['availabilityResultList']['availabilityRouteList']['availabilityByDateList']['originDestinationOptionList'];
                $result0 = $this->groupFaresByCabin($originDestinationOptionList, $quantity, $travelerInformation_count);
                $rt = new \stdClass();
                $rt->departure = $result0;
                $result = $rt;
            } else  if ($request->input('trip_type') == "ROUND_TRIP") {
                $originDestinationOptionList0 = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList']['originDestinationOptionList'];
                $result0 = $this->groupFaresByCabin($originDestinationOptionList0, $quantity, $travelerInformation_count);
                $originDestinationOptionList1 = $response['Availability']['availabilityResultList']['availabilityRouteList'][1]['availabilityByDateList']['originDestinationOptionList'];
                $result1 = $this->groupFaresByCabin($originDestinationOptionList1, $quantity,  $travelerInformation_count);

                $rt = new \stdClass();
                $rt->departure = $result0;
                $rt->arrival = $result1;
                $result = $rt;
            }else{
                $availabilityRouteList = $response['Availability']['availabilityResultList']['availabilityRouteList'];

                $multiDirectionalFlights = $validated['multi_directional_flights'];

                $rt = new \stdClass();

                for ($i = 0; $i < count( $availabilityRouteList); $i++) {

                    $mainkey =  $multiDirectionalFlights[$i]['departure_airport'] . " - " .  $multiDirectionalFlights[$i]['arrival_airport'];

                    $originDestinationOptionList =  $availabilityRouteList[$i];
                  
                    $result = $this->groupFaresByCabin($originDestinationOptionList['availabilityByDateList']['originDestinationOptionList'], $quantity, $travelerInformation_count);
                    $rt->{$mainkey}  =  $result;
                }
               // $originDestinationOptionList0 = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList']['originDestinationOptionList'];
               // dd(  $availabilityRouteList);

               $result = $rt;

            }
           
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function groupFaresByCabin($originDestinationOptionList, $quantity,  $count)
    {
       // dd($originDestinationOptionList);

        $itemsCollection = collect();
        foreach ($originDestinationOptionList as  $originDestinationOptionItems) {
            $fareComponentGroupList = $originDestinationOptionItems['fareComponentGroupList'];
            $bookingClassList = $fareComponentGroupList['boundList']['availFlightSegmentList']["bookingClassList"];
            $flightSegment = $fareComponentGroupList['boundList']['availFlightSegmentList']["flightSegment"];
            $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
            $fareComponentList = $fareComponentGroupList['fareComponentList'];

            //dd($fareComponentList);
            $cabinData = new \stdClass();
            $cabinData->flightSegment = $flightSegment;

            foreach ($grouped_bookingClassList as $cabin => $items) {
                $reversedItems = $items->reverse();
                foreach ($reversedItems as $item) {
                    if ($quantity <= (int)$item['resBookDesigQuantity']) {
                        $cabinData->$cabin['availability'] = $item;

                        foreach ($fareComponentList as $fareComponentItem) {

                           $passengerFareInfoList = $fareComponentItem['passengerFareInfoList'];
                         
                            if($count == 1){
                                if ($item['resBookDesigCode'] == $passengerFareInfoList['fareInfoList']['resBookDesigCode']) {
                                    $cabinData->$cabin['cost'] = $fareComponentItem['pricingOverview']['totalAmount'];
                                    $cabinData->$cabin['fareInfoList'] = [$passengerFareInfoList];
                                    break;
                                }
                            }else{

                                foreach ($passengerFareInfoList  as $passengerFareInfoItem) {
                                    if ($item['resBookDesigCode'] == $passengerFareInfoItem['fareInfoList']['resBookDesigCode']) {
                                        $cabinData->$cabin['cost'] = $fareComponentItem['pricingOverview']['totalAmount'];
                                        $cabinData->$cabin['fareInfoList'] = $passengerFareInfoList;
                                        break;
                                    }
                                }
                            }

                        }
                        break;
                    }
                }
            }
            $itemsCollection->push($cabinData);
        }

        return $itemsCollection;
    }
}
