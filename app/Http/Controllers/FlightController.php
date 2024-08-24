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
        $destinationLocationCode = $request->input('departure_airport');
        $originLocationCode = $request->input('arrival_airport');
        $passengerTypeCode = $request->input('passenger_type');
        $quantity = $request->input('passengers');
        $tripType = $request->input('trip_type');;

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailability';


        if ($request->input('trip_type') == "ONE_WAY") {
            $xml = $this->soapRequestBuilder->GetFlightOneWay($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType);
        } else {
            $xml = $this->soapRequestBuilder->GetFlightRoundTrip($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType,  $ArrivalDateTime);
        }


        try {
            $response = $this->craneOTASoapService->run($function, $xml);
            $result = "";

            if ($request->input('trip_type') == "ONE_WAY") {
                $originDestinationOptionList = $response['Availability']['availabilityResultList']['availabilityRouteList']['availabilityByDateList']['originDestinationOptionList'];
                $result0 = $this->groupFaresByCabin($originDestinationOptionList, $quantity);
                $rt = new \stdClass();
                $rt->departure = $result0;
                $result = $rt;
            } else {
                $originDestinationOptionList0 = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList']['originDestinationOptionList'];
                $result0 = $this->groupFaresByCabin($originDestinationOptionList0, $quantity);
                $originDestinationOptionList1 = $response['Availability']['availabilityResultList']['availabilityRouteList'][1]['availabilityByDateList']['originDestinationOptionList'];
                $result1 = $this->groupFaresByCabin($originDestinationOptionList1, $quantity);

                $rt = new \stdClass();
                $rt->departure = $result0;
                $rt->arrival = $result1;
                $result = $rt;
            }
           
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function groupFaresByCabin($originDestinationOptionList, $quantity)
    {
        $itemsCollection = collect();
        foreach ($originDestinationOptionList as  $originDestinationOptionItems) {
            $fareComponentGroupList = $originDestinationOptionItems['fareComponentGroupList'];
            $bookingClassList = $fareComponentGroupList['boundList']['availFlightSegmentList']["bookingClassList"];
            $flightSegment = $fareComponentGroupList['boundList']['availFlightSegmentList']["flightSegment"];
            $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
            $fareComponentList = $fareComponentGroupList['fareComponentList'];


            $cabinData = new \stdClass();
            $cabinData->flightSegment = $flightSegment;

            foreach ($grouped_bookingClassList as $cabin => $items) {
                $reversedItems = $items->reverse();
                foreach ($reversedItems as $item) {

                    if ($quantity <= (int)$item['resBookDesigQuantity']) {
                        $cabinData->$cabin['availability'] = $item;

                        foreach ($fareComponentList  as $fareComponentItem) {
                            if ($item['resBookDesigCode'] == $fareComponentItem['passengerFareInfoList']['fareInfoList']['resBookDesigCode']) {
                                $cabinData->$cabin['cost'] = $fareComponentItem['pricingOverview']['totalAmount'];
                                break;
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
