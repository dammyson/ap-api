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
use App\Services\Utility\CheckArray;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Collection;

class FlightController extends Controller
{
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;
    protected $soapRequestBuilder;
    protected $checkArray;

    
    public function __construct(SoapRequestBuilder $soapRequestBuilder, CheckArray $checkArray)
    {
        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->soapRequestBuilder = $soapRequestBuilder;
        $this->checkArray = $checkArray;
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
        $preferredCurrency = $request->input('preferred_currency');

        $quantity = $request->input('passengers');
        
        $tripType = $request->input('trip_type');

        $validated = $request->validated();

      
        $travelerInformation = $validated["travelerInformation"];
        $travelerInformation_count = count($travelerInformation);

      

        $function = 'http://impl.soap.ws.crane.hititcs.com/GetAvailability';

        if ($request->input('trip_type') == "ONE_WAY") {
            $xml = $this->soapRequestBuilder->GetFlightOneWay($preferredCurrency, $departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType);
            // dd($xml);
        } else  if ($request->input('trip_type') == "ROUND_TRIP") {
            $xml = $this->soapRequestBuilder->GetFlightRoundTrip($preferredCurrency, $departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType,  $ArrivalDateTime);
        } else {
            $multiDirectionalFlights = $validated['multi_directional_flights'];

            $xml = $this->soapRequestBuilder->GetFlightMultiCity($preferredCurrency, $multiDirectionalFlights, $travelerInformation, $tripType);
        }
        // dd($xml);
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            // return "test";
            // dd($response);
            // return $response;

            $result = "";

            if ($request->input('trip_type') == "ONE_WAY") {
                $availabilityByDateList = $response['Availability']['availabilityResultList']['availabilityRouteList']['availabilityByDateList'];
                if(!array_key_exists('originDestinationOptionList', $availabilityByDateList)) {
                    return response()->json([
                        'error' => true,
                        'message' => "flight is not available for selected date"
                    ], 500);
                }

                $originDestinationOptionList = $response['Availability']['availabilityResultList']['availabilityRouteList']['availabilityByDateList']['originDestinationOptionList'];

                $result0 = $this->groupFaresByCabin($originDestinationOptionList, $quantity, $travelerInformation_count);
                $rt = new \stdClass();
                $rt->departure = $result0;
                $result = $rt;
            } else  if ($request->input('trip_type') == "ROUND_TRIP") {
                // dd(" i ran");
                $availabilityByDateList = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList'];
                if(!array_key_exists('originDestinationOptionList', $availabilityByDateList)) {
                   
                    return response()->json([
                        'error' => true,
                        'message' => "flight is not available for selected departure date"
                    ], 500);
                }

                $availabilityByDateList = $response['Availability']['availabilityResultList']['availabilityRouteList'][1]['availabilityByDateList'];
                if(!array_key_exists('originDestinationOptionList', $availabilityByDateList)) {
                    return response()->json([
                        'error' => true,
                        'message' => "flight is not available for selected return date"
                    ], 500);
                }

                $originDestinationOptionList0 = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList']['originDestinationOptionList'];
               
                $result0 = $this->groupFaresByCabin($originDestinationOptionList0, $quantity, $travelerInformation_count);
                $originDestinationOptionList1 = $response['Availability']['availabilityResultList']['availabilityRouteList'][1]['availabilityByDateList']['originDestinationOptionList'];
                // dd("i got here");                
                $result1 = $this->groupFaresByCabin($originDestinationOptionList1, $quantity,  $travelerInformation_count);

                $rt = new \stdClass();
                $rt->departure = $result0;
                $rt->arrival = $result1;
                $result = $rt;
            }else{
                $availabilityRouteList = $response['Availability']['availabilityResultList']['availabilityRouteList'];
                // dd($response);
                $multiDirectionalFlights = $validated['multi_directional_flights'];

                $rt = new \stdClass();

                for ($i = 0; $i < count( $availabilityRouteList); $i++) {

                    $mainkey =  $multiDirectionalFlights[$i]['departure_airport'] . " - " .  $multiDirectionalFlights[$i]['arrival_airport'];

                    $originDestinationOptionList =  $availabilityRouteList[$i];
                    $availabilityByDateList = $originDestinationOptionList['availabilityByDateList'];
                    if (!array_key_exists("originDestinationOptionList", $originDestinationOptionList['availabilityByDateList'])) {
                   
                    return response()->json([
                            'error' => true,
                            'message' => "flight is not available for date ({$availabilityByDateList['dateList']}) for the selected route"

                        ], 500);
                    };
                  
                    $result = $this->groupFaresByCabin($availabilityByDateList["originDestinationOptionList"], $quantity, $travelerInformation_count);
                    $rt->{$mainkey}  =  $result;
                }
               // $originDestinationOptionList0 = $response['Availability']['availabilityResultList']['availabilityRouteList'][0]['availabilityByDateList']['originDestinationOptionList'];
               // dd(  $availabilityRouteList);

               $result = $rt;

            }
           
            return response()->json($result);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "actual_message" => $e->getMessage()
            ], 500);
        }
    }
    


    public function groupFaresByCabin($originDestinationOptionList, $quantity,  $count)
    {
        if ($this->checkArray->isAssociativeArray($originDestinationOptionList)) {
            $originDestinationOptionList = [$originDestinationOptionList];
        }

        $itemsCollection = collect();
       
        // dd("i ran");
        foreach ($originDestinationOptionList as  $originDestinationOptionItems) {
            // dd($originDestinationOptionItems);
            
            $fareComponentGroupList = $originDestinationOptionItems['fareComponentGroupList'];

            // dd($fareComponentGroupList);

            if ($this->checkArray->isAssociativeArray($fareComponentGroupList)) {                   

                $fareComponentGroupList = [$fareComponentGroupList];
            }

           

            foreach ($fareComponentGroupList as $fareComponentGroupListItem) {
                // dd($fareComponentGroupListItem);
                $bookingClassList = $fareComponentGroupListItem['boundList']['availFlightSegmentList']["bookingClassList"];
                $bookingClassList = $fareComponentGroupListItem['boundList']['availFlightSegmentList']['bookingClassList'];

                // NORMALIZE bookingClassList
                if ($this->checkArray->isAssociativeArray($bookingClassList)) {
                    // dump("i ran");
                    $bookingClassList = [$bookingClassList];
                }
                $flightSegment = $fareComponentGroupListItem['boundList']['availFlightSegmentList']["flightSegment"];

                
                
                if($this->checkArray->isAssociativeArray($flightSegment['flightNotes'])) {
                
                    $flightSegment['flightNotes'] = [$flightSegment['flightNotes']];

                }

                // dd($bookingClassList);

                
                $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
                // dump($grouped_bookingClassList);
                $fareComponentList = $fareComponentGroupListItem['fareComponentList'];
                if ($this->checkArray->isAssociativeArray($fareComponentList)) {
                    $fareComponentList = [$fareComponentList];
                }
                // factore case where fareComponentList is an object and convert it to an array

                $cabinData = new \stdClass();
                $cabinData->flightSegment = $flightSegment;

                // dump($grouped_bookingClassList);
                
                foreach ($grouped_bookingClassList as $cabin => $items) {
                
                    // dump($items);
                    $reversedItems = $items->reverse();
                    foreach ($reversedItems as $item) {
                        // dump($items);
                        // dump("1");
                       
                        if ($quantity <= (int)$item['resBookDesigQuantity']) {
                            // dump("2");
                            $cabinData->$cabin['availability'] = $item;
                            foreach ($fareComponentList as $fareComponentItem) {
                               
                                // if (array_key_exists('passengerFareInfoList', $fareComponentItem)) {
                               
                                     $passengerFareInfoList = $fareComponentItem['passengerFareInfoList'];
                                        // dd($passengerFareInfoList);
                                
                                    if ($count == 1) {
                                        // dump("1");
                                          
                                        if ($item['resBookDesigCode'] == $passengerFareInfoList['fareInfoList']['resBookDesigCode']) {
                                        
                                            $cabinData->$cabin['cost'] = $fareComponentItem['pricingOverview']['totalAmount'];
                                            
                                            $cabinData->$cabin['fareInfoList'] = [$passengerFareInfoList];
                                            
                                            break;
                                        }

                                    } else {
                                        // dump("2");

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
                // dump("new dummp");
                // dd($cabinData);

                $itemsCollection->push($cabinData);
            
            }
            
            
            
        }
       
        return $itemsCollection;
    }

    public function groupFaresByCabin2($originDestinationOptionList, $quantity,  $count)
    {
    //    dd($originDestinationOptionList);

        $itemsCollection = collect();
        if (!$this->checkArray->isAssociativeArray($originDestinationOptionList)) {
            // dd($originDestinationOptionList);
            // dd(" non assoiciative ran");
           
            foreach ($originDestinationOptionList as  $originDestinationOptionItems) {
               
                $fareComponentGroupList = $originDestinationOptionItems['fareComponentGroupList'];
                $bookingClassList = $fareComponentGroupList['boundList']['availFlightSegmentList']["bookingClassList"];
                $flightSegment = $fareComponentGroupList['boundList']['availFlightSegmentList']["flightSegment"];
                
                // start here
                if (!$this->checkArray->isAssociativeArray($fareComponentGroupList)) {                   

                   $fareComponentGroupList = [$fareComponentGroupList];
                }


                // $availFlightSegmentList = $boundList['availFlightSegmentList'];

                // $bookingClassList = $availFlightSegmentList['bookingClassList'];
                // $flightSegment   = $availFlightSegmentList['flightSegment'];
                // ends here 
                
                
                if($this->checkArray->isAssociativeArray($flightSegment['flightNotes'])) {
                   
                    $flightSegment['flightNotes'] = [$flightSegment['flightNotes']];

                }

                
                $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
                // dd($grouped_bookingClassList);
                $fareComponentList = $fareComponentGroupList['fareComponentList'];
                // factore case where fareComponentList is an object and convert it to an array

                $cabinData = new \stdClass();
                $cabinData->flightSegment = $flightSegment;

                // dump($grouped_bookingClassList);
                
                foreach ($grouped_bookingClassList as $cabin => $items) {
                   
                    // dump($items);
                    $reversedItems = $items->reverse();
                    // dd($reversedItems);
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
                // dd($cabinData);
                // dd($cabinData);

                $itemsCollection->push($cabinData);
               
            }

        } else {
            $fareComponentGroupList = $originDestinationOptionList['fareComponentGroupList']; 
            $bookingClassList = $fareComponentGroupList["boundList"]['availFlightSegmentList']['bookingClassList'];
            $flightSegment = $fareComponentGroupList['boundList']['availFlightSegmentList']["flightSegment"];
            $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
            $fareComponentList = $fareComponentGroupList['fareComponentList'];

            if ($this->checkArray->isAssociativeArray($flightSegment['flightNotes'])) {
              
                $flightSegment['flightNotes'] = [$flightSegment['flightNotes']];

            }

            // if(array_key_exists('deiCode', $flightSegment['flightNotes'])) {
            //     $flightSegment['flightNotes'] = [$flightSegment['flightNotes']];
                
            // }
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
