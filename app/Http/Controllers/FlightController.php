<?php

namespace App\Http\Controllers;

use App\Exceptions\HititException;
use App\Http\Requests\Soap\SearchFlightRequest;
use App\Services\Soap\SoapRequestBuilder;
use App\Services\Utility\CheckArray;
use Illuminate\Support\Facades\Log;

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
        
        try {
            
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
           
            } else  if ($request->input('trip_type') == "ROUND_TRIP") {
                $xml = $this->soapRequestBuilder->GetFlightRoundTrip($preferredCurrency, $departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType,  $ArrivalDateTime);
            } else {
                $multiDirectionalFlights = $validated['multi_directional_flights'];

                $xml = $this->soapRequestBuilder->GetFlightMultiCity($preferredCurrency, $multiDirectionalFlights, $travelerInformation, $tripType);
            }


            $response = $this->craneOTASoapService->run($function, $xml);
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
                             
                $result1 = $this->groupFaresByCabin($originDestinationOptionList1, $quantity,  $travelerInformation_count);

                $rt = new \stdClass();
                $rt->departure = $result0;
                $rt->arrival = $result1;
                $result = $rt;
            } else {
                $availabilityRouteList = $response['Availability']['availabilityResultList']['availabilityRouteList'];
                
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

               $result = $rt;

            }
           
            return response()->json($result);
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR SEARCHING FLIGHTS', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            Log::error('ERROR SEARCHING FLIGHTS', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
    }
    


    public function groupFaresByCabin($originDestinationOptionList, $quantity,  $count)
    {
        if ($this->checkArray->isAssociativeArray($originDestinationOptionList)) {
            $originDestinationOptionList = [$originDestinationOptionList];
        }

        $itemsCollection = collect();
       

        foreach ($originDestinationOptionList as  $originDestinationOptionItems) {

            $fareComponentGroupList = $originDestinationOptionItems['fareComponentGroupList'];

            if ($this->checkArray->isAssociativeArray($fareComponentGroupList)) {                   

                $fareComponentGroupList = [$fareComponentGroupList];
            }

           

            foreach ($fareComponentGroupList as $fareComponentGroupListItem) {
                
                if (!isset($fareComponentGroupListItem['boundList']['availFlightSegmentList']['bookingClassList'])) {
                    continue;
                }
                $bookingClassList = $fareComponentGroupListItem['boundList']['availFlightSegmentList']["bookingClassList"];

                // NORMALIZE bookingClassList
                if ($this->checkArray->isAssociativeArray($bookingClassList)) {
                  
                    $bookingClassList = [$bookingClassList];
                }
                $flightSegment = $fareComponentGroupListItem['boundList']['availFlightSegmentList']["flightSegment"];

                
                if (isset($flightSegment['flightNotes'])) {
                    if($this->checkArray->isAssociativeArray($flightSegment['flightNotes'])) {
                    
                        $flightSegment['flightNotes'] = [$flightSegment['flightNotes']];
    
                    }
                }

                
                $grouped_bookingClassList = collect($bookingClassList)->groupBy('cabin');
               
                $fareComponentList = $fareComponentGroupListItem['fareComponentList'];
                if ($this->checkArray->isAssociativeArray($fareComponentList)) {
                    $fareComponentList = [$fareComponentList];
                }
                // factore case where fareComponentList is an object and convert it to an array

                $cabinData = new \stdClass();
                $cabinData->flightSegment = $flightSegment;

               
                
                foreach ($grouped_bookingClassList as $cabin => $items) {
                
                    
                    $reversedItems = $items->reverse();
                    foreach ($reversedItems as $item) {                       
                       
                        if ($quantity <= (int)$item['resBookDesigQuantity']) {
                            
                            $cabinData->$cabin['availability'] = $item;
                            foreach ($fareComponentList as $fareComponentItem) {
                               
                                    $passengerFareInfoList = $fareComponentItem['passengerFareInfoList'];
                                
                                
                                    if ($count == 1) {
                                      
                                          
                                        if ($item['resBookDesigCode'] == $passengerFareInfoList['fareInfoList']['resBookDesigCode']) {
                                        
                                            $cabinData->$cabin['cost'] = $fareComponentItem['pricingOverview']['totalAmount'];
                                            
                                            $cabinData->$cabin['fareInfoList'] = [$passengerFareInfoList];
                                            
                                            break;
                                        }

                                    } else {

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
            
            
            
        }
       
        return $itemsCollection;
    }

    public function groupFaresByCabin2($originDestinationOptionList, $quantity,  $count)
    {

        $itemsCollection = collect();
        if (!$this->checkArray->isAssociativeArray($originDestinationOptionList)) {
          
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
              
                $fareComponentList = $fareComponentGroupList['fareComponentList'];
                // factore case where fareComponentList is an object and convert it to an array

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
