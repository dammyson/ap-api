<?php

namespace App\Http\Controllers\Soap;

use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\SSR\AddSsrRequest;
use App\Services\Soap\AddWeightBuilderTest;
use App\Http\Requests\Test\addWeightRequest;
use App\Http\Requests\Test\AddWeightRequestTest;
use App\Services\Soap\BookingBuilder;
use App\Services\Utility\CheckArray;

class AddWeightControllerTest extends Controller
{
    protected $addWeightBuilderTest;
    protected $craneAncillaryOTASoapService;
    protected $craneOTASoapService;
    protected $bookingBuilder;
    protected $checkArray;

    public function __construct(AddWeightBuilderTest $addWeightBuilderTest, BookingBuilder $bookingBuilder, CheckArray $checkArray) {
        $this->addWeightBuilderTest = $addWeightBuilderTest;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        $this->craneOTASoapService = app("CraneOTASoapService");
        $this->bookingBuilder = $bookingBuilder;
        $this->checkArray = $checkArray;
        
    }

    public function addWeightTest(AddWeightRequestTest $request, $invoiceId, $ssrType) {
        $adviceCodeSegmentExist = $request->input('adviceCodeSegmentExist');
        $bookFlightSegmentListActionCode = $request->input('bookFlightSegmentListActionCode');
        $bookFlightAddOnSegment = $request->input('bookFlightAddOnSegment');
        $bookingClassCabin = $request->input('bookingClassCabin');
        $bookingClassResBookDesigCode = $request->input('bookingClassResBookDesigCode');
        $resBookDesignQuantity = $request->input('resBookDesignQuantity');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageMaxAllowedPieces = $request->input('fareBaggageMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $fareBaggageAllowanceWeight = $request->input('fareBaggageAllowanceWeight');
        $fareGroupName = $request->input('fareGroupName');
        $fareReferenceCode = $request->input('fareReferenceCode');
        $fareReferenceID = $request->input('fareReferenceID');
        $fareReferenceName = $request->input('fareReferenceName');
        $bookFlightSegmentSequence = $request->input('bookFlightSegmentSequence');
        $resBookDesigCode = $request->input('resBookDesigCode');
        $flightSegmentCode = $request->input('flightSegmentCode');
        $flightSegmentCodeContext = $request->input('flightSegmentCodeContext');
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode');
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName');
        $arrivalAirportCityLocationNameLanguage = $request->input('arrivalAirportCityLocationNameLanguage');
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode');
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName');
        $arrivalAirportCountryLocationNameLanguage = $request->input('arrivalAirportCountryLocationNameLanguage');
        $arrivalAirportCountryCurrencyCode = $request->input('arrivalAirportCountryCurrencyCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext');
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage');
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode');
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName');
        $arrivalAirportTerminal = $request->input('arrivalAirportTerminal');
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalDateTime = $request->input('arrivalDateTime');
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC');
        $departureAirportCitytLocationCode = $request->input('departureAirportCitytLocationCode');
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode');
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName');
        $departureCountryLocationNameLanguage = $request->input('departureCountryLocationNameLanguage');
        $departureCountryCurrencyCode = $request->input('departureCountryCurrencyCode');
        $departureAirportCodeContext = $request->input('departureAirportCodeContext');
        $departureAirportLanguage = $request->input('departureAirportLanguage');
        $departureAirportLocationCode = $request->input('departureAirportLocationCode');
        $departureAirportLocationName = $request->input('departureAirportLocationName');
        $departureAirportTimeZoneInfo = $request->input('departureAirportTimeZoneInfo');
        $departureDateTime = $request->input('departureDateTime');
        $departureDateTimeUTC = $request->input('departureDateTimeUTC');
        $flightNumber = $request->input('flightNumber');
        $flightSegmentID = $request->input('flightSegmentID');
        $ondControlled = $request->input('ondControlled');
        $departureAirportSector = $request->input('departureAirportSector');
        $departureFlightCodeShare = $request->input('departureFlightCodeShare');
        $departureFlightDistance = $request->input('departureFlightDistance');
        $equipmentAirEquipType = $request->input('equipmentAirEquipType');
        $equipmentChangeOfGauge = $request->input('equipmentChangeOfGauge');
        $flightNotes = $request->input('flightNotes');     
        $flownMileageQty = $request->input('flownMileageQty');
        $iatciFlight = $request->input('iatciFlight');
        $journeyDuration = $request->input('journeyDuration');
        $onTimeRate = $request->input('onTimeRate');
        $remark = $request->input('remark');
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $segmentStatusByFirstLeg = $request->input('segmentStatusByFirstLeg');
        $stopQuantity = $request->input('stopQuantity');
        $involuntaryPermissionGiven = $request->input('involuntaryPermissionGiven');
        $legStatus = $request->input('legStatus');
        $referenceID = $request->input('referenceID');
        $responseCode = $request->input('responseCode');
        $sequenceNumber = $request->input('sequenceNumber');
        $status = $request->input('status');
        $airTravelerList = $request->input('airTravelerList');
        $preferredCurrency = $request->input('preferredCurrency');

        $ancillaryRequestList = $request->input('ancillaryRequestList');
        
        // $airTravelerSequence = $request->input('airTravelerSequence');
        // $flightSegmentSequence = $request->input('flightSegmentSequence');
        // $airTravelerSsrCode = $request->input('airTravelerSsrCode');
        // $airTravelerSsrGroup = $request->input('airTravelerSsrGroup');
        // $ssrExplanation = $request->input('ssrExplanation');      
        
        
        $bookingReferenceIDID = $request->input('bookingReferenceIDID');
        $bookingReferenceID = $request->input('bookingReferenceID');
        $passengerName = $request->input('passengerName');
        $peaceId = $request->input('peaceId');

        // dd("i ran");
        $user = $request->user();
        
        if ($user->is_guest) {

            $function = "http://impl.soap.ws.crane.hititcs.com/ReadBooking";
            $xml = $this->bookingBuilder->readBooking($bookingReferenceIDID, $passengerName);
    
    
            $response = $this->craneOTASoapService->run($function, $xml);
          
            if (!(isset($response['AirBookingResponse']))) {
                return response()->json([
                    "error" => true,
                    "message" => "you are not authorized to carry out this action"
                ], 401);
            }
            // dd($response);
        } else {
            $booking = Booking::where('booking_id', $bookingReferenceIDID)->where('peace_id', $peaceId)->first();
            if (!$booking) {
                return response()->json([
                    "error" => true,
                    "message" => "you are not authorized to carry out this action"
                ], 401);
            }
        }

        // dump("i ran");

        $xml = $this->addWeightBuilderTest->addWeightTest(
            $preferredCurrency,
            $adviceCodeSegmentExist,
            $bookFlightSegmentListActionCode,
            $bookFlightAddOnSegment,
            $bookingClassCabin,
            $bookingClassResBookDesigCode,
            $resBookDesignQuantity,
            $fareInfoCabin,
            $fareInfoCabinClassCode,
            $fareBaggageAllowanceType,
            $fareBaggageMaxAllowedPieces,
            $unitOfMeasureCode,
            $fareBaggageAllowanceWeight,
            $fareGroupName,
            $fareReferenceCode,
            $fareReferenceID,
            $fareReferenceName,
            $bookFlightSegmentSequence,
            $resBookDesigCode,
            $flightSegmentCode,
            $flightSegmentCodeContext,
            $arrivalAirportCityLocationCode,
            $arrivalAirportCityLocationName,
            $arrivalAirportCityLocationNameLanguage,
            $arrivalAirportCountryLocationCode,
            $arrivalAirportCountryLocationName,
            $arrivalAirportCountryLocationNameLanguage,
            $arrivalAirportCountryCurrencyCode,
            $arrivalAirportCodeContext,
            $arrivalAirportLanguage,
            $arrivalAirportLocationCode,
            $arrivalAirportLocationName,
            $arrivalAirportTerminal,
            $arrivalAirportTimeZoneInfo,
            $arrivalDateTime,
            $arrivalDateTimeUTC,
            $departureAirportCitytLocationCode,
            $departureAirportCityLocationName,
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode,
            $departureAirportCountryLocationName,
            $departureCountryLocationNameLanguage,
            $departureCountryCurrencyCode,
            $departureAirportCodeContext,
            $departureAirportLanguage,
            $departureAirportLocationCode,
            $departureAirportLocationName,
            $departureAirportTimeZoneInfo,
            $departureDateTime,
            $departureDateTimeUTC,
            $flightNumber,
            $flightSegmentID,
            $ondControlled,
            $departureAirportSector,
            $departureFlightCodeShare,
            $departureFlightDistance,
            $equipmentAirEquipType,
            $equipmentChangeOfGauge,
            $flightNotes,
            $flownMileageQty,
            $iatciFlight,
            $journeyDuration,
            $onTimeRate,
            $remark,
            $secureFlightDataRequired,
            $segmentStatusByFirstLeg,
            $stopQuantity,
            $involuntaryPermissionGiven,
            $legStatus,
            $referenceID,
            $responseCode,
            $sequenceNumber,
            $status,
            $airTravelerList,
            $ancillaryRequestList,
            $bookingReferenceIDID,
            $bookingReferenceID
        );
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            // dd($response);
            // $ticketInfo = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"];
            // $amount = 0;

            // if (!array_key_exists('totalAmount', $ticketInfo)) {
            //     $amount = str_replace(['NGN', ',', ' '], '', $ticketInfo['totalAmountText']);
            // }else {
            //     $amount = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];

            // }            
            // dd($amount);

            $ticketInfo = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"];
            $amount = 0;
            $preferredCurrency = null;

            if (array_key_exists('totalAmount', $ticketInfo)) {
                $amount = $ticketInfo["totalAmount"]["value"];
                $preferredCurrency = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["currency"]["code"];

            } else {
                $ticketItemList = $ticketInfo['ticketItemList'];
                if (!$this->checkArray->isAssociativeArray($ticketItemList)) {
                
                    foreach($ticketItemList as $ticketItem) {
                      $preferredCurrency = $preferredCurrency ?? $ticketItem['pricingOverview']['totalAmount']['currency']['code'];
                      $amount += $ticketItem['pricingOverview']['totalAmount']['value'];                        
                    }
                } else  {
                  
                    $preferredCurrency = $ticketItemList['pricingOverview']['totalAmount']['currency']['code'];
                    $amount = $ticketItemList['pricingOverview']['totalAmount']['value'];   
                }
            }

            $bookingId = $response["AddSsrResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["ID"];
            $invoice = Invoice::find($invoiceId);


            // if user has not paid set the new invoice balance else generate a new invoice
            
            $addedPrice = 0;
            // dd($invoice);
           
            if (!$invoice->is_paid) {
                $addedPrice = $invoice->amount - $amount;
                $addedPrice = abs($addedPrice);
                $invoice->amount = $amount;
                
            } else { 
                $invoice = Invoice::create([
                    'amount' => $amount,
                    'booking_id' => $bookingId,
                    'currency' => $preferredCurrency
                ]);
                $addedPrice = $amount;
            }
            
          

            // Use preg_match to extract the number
           

            $message = "";

            if ($ssrType == "insurance") {
                $numberOfInsurance = count($ancillaryRequestList);
                InvoiceItem::create([
                    'invoice_id' => $invoice->id,
                    'product' => 'Insurance', // baggages or ticket shopping
                    'quantity' => $numberOfInsurance,
                    // total_passengers => $totalPassengers  // this field would be removed
                    'price' => $addedPrice
                ]);
                $message = "Insurance added successfully";
            } else {
                foreach ($ancillaryRequestList as $ancillaryRequest) {
                    $ssrExplanation = $ancillaryRequest['ssrExplanation'];
                    preg_match('/\d+/', $ssrExplanation, $matches);
        
                    // $matches[0] will contain the number
                    $quantity = $matches[0];
    
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product' => 'Baggages', // baggages or ticket shopping
                        'quantity' => $quantity,
                        // total_passengers => $totalPassengers  // this field would be removed
                        'price' => $addedPrice
                    ]);
    
                }
                $message = "Baggages added successfully";

            }

            $invoice->is_paid = false;
            $invoice->save();
                
            if ($amount == $invoice->amount) {
                 // set invoice is paid to false
              
                return response()->json([
                    "error" => true,
                    "message" => "unable to add baggage try again later"
                ]                   
                , 500);
            }
            

            return response()->json([
                "error" => false,
                "message" => $message,
                'invoice_id' => $invoice->id,
                "amount" => $amount
            ], 200);

        } catch (\Throwable $th) {
            $message = "Something went wrong";
            if (array_key_exists("detail", $response)) {
                if (array_key_exists("CraneFault", $response["detail"])){
                    if (array_key_exists("code", $response["detail"]["CraneFault"])){
                        if ($response["detail"]["CraneFault"]["code"] == "BAGGAGE_LIMIT_ERROR") {
                            $message = "Requested baggage weight {$response["detail"]["CraneFault"]["args"][0]} exceeds baggage limit {$response["detail"]["CraneFault"]["args"][1]}. Current baggage weight {$response["detail"]["CraneFault"]["args"][2]}";
                        }
                    }
                }
            }
            Log::error($th->getMessage());

            return response()->json([
                'error' => true,
                "message" => $message,
                "actual_error" => $th->getMessage()
        
            ], 500);
        }
    }


    public function selectSeatTest(AddWeightRequestTest $request) {
        $adviceCodeSegmentExist = $request->input('adviceCodeSegmentExist');
        $bookFlightSegmentListActionCode = $request->input('bookFlightSegmentListActionCode');
        $bookFlightAddOnSegment = $request->input('bookFlightAddOnSegment');
        $bookingClassCabin = $request->input('bookingClassCabin');
        $bookingClassResBookDesigCode = $request->input('bookingClassResBookDesigCode');
        $resBookDesignQuantity = $request->input('resBookDesignQuantity');
        $fareInfoCabin = $request->input('fareInfoCabin');
        $fareInfoCabinClassCode = $request->input('fareInfoCabinClassCode');
        $fareBaggageAllowanceType = $request->input('fareBaggageAllowanceType');
        $fareBaggageMaxAllowedPieces = $request->input('fareBaggageMaxAllowedPieces');
        $unitOfMeasureCode = $request->input('unitOfMeasureCode');
        $fareBaggageAllowanceWeight = $request->input('fareBaggageAllowanceWeight');
        $fareGroupName = $request->input('fareGroupName');
        $fareReferenceCode = $request->input('fareReferenceCode');
        $fareReferenceID = $request->input('fareReferenceID');
        $fareReferenceName = $request->input('fareReferenceName');
        $bookFlightSegmentSequence = $request->input('bookFlightSegmentSequence');
        $resBookDesigCode = $request->input('resBookDesigCode');
        $flightSegmentCode = $request->input('flightSegmentCode');
        $flightSegmentCodeContext = $request->input('flightSegmentCodeContext');
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode');
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName');
        $arrivalAirportCityLocationNameLanguage = $request->input('arrivalAirportCityLocationNameLanguage');
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode');
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName');
        $arrivalAirportCountryLocationNameLanguage = $request->input('arrivalAirportCountryLocationNameLanguage');
        $arrivalAirportCountryCurrencyCode = $request->input('arrivalAirportCountryCurrencyCode');
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext');
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage');
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode');
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName');
        $arrivalAirportTerminal = $request->input('arrivalAirportTerminal');
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo');
        $arrivalDateTime = $request->input('arrivalDateTime');
        $arrivalDateTimeUTC = $request->input('arrivalDateTimeUTC');
        $departureAirportCitytLocationCode = $request->input('departureAirportCitytLocationCode');
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode');
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName');
        $departureCountryLocationNameLanguage = $request->input('departureCountryLocationNameLanguage');
        $departureCountryCurrencyCode = $request->input('departureCountryCurrencyCode');
        $departureAirportCodeContext = $request->input('departureAirportCodeContext');
        $departureAirportLanguage = $request->input('departureAirportLanguage');
        $departureAirportLocationCode = $request->input('departureAirportLocationCode');
        $departureAirportLocationName = $request->input('departureAirportLocationName');
        $departureAirportTimeZoneInfo = $request->input('departureAirportTimeZoneInfo');
        $departureDateTime = $request->input('departureDateTime');
        $departureDateTimeUTC = $request->input('departureDateTimeUTC');
        $flightNumber = $request->input('flightNumber');
        $flightSegmentID = $request->input('flightSegmentID');
        $ondControlled = $request->input('ondControlled');
        $departureAirportSector = $request->input('departureAirportSector');
        $departureFlightCodeShare = $request->input('departureFlightCodeShare');
        $departureFlightDistance = $request->input('departureFlightDistance');
        $equipmentAirEquipType = $request->input('equipmentAirEquipType');
        $equipmentChangeOfGauge = $request->input('equipmentChangeOfGauge');
        $flightNotes = $request->input('flightNotes');     
        $flownMileageQty = $request->input('flownMileageQty');
        $iatciFlight = $request->input('iatciFlight');
        $journeyDuration = $request->input('journeyDuration');
        $onTimeRate = $request->input('onTimeRate');
        $remark = $request->input('remark');
        $secureFlightDataRequired = $request->input('secureFlightDataRequired');
        $segmentStatusByFirstLeg = $request->input('segmentStatusByFirstLeg');
        $stopQuantity = $request->input('stopQuantity');
        $involuntaryPermissionGiven = $request->input('involuntaryPermissionGiven');
        $legStatus = $request->input('legStatus');
        $referenceID = $request->input('referenceID');
        $responseCode = $request->input('responseCode');
        $sequenceNumber = $request->input('sequenceNumber');
        $status = $request->input('status');
        $airTravelerList = $request->input('airTravelerList');
        $preferredCurrency = $request->input('preferredCurrency');


        $ancillaryRequestList = $request->input('ancillaryRequestList');
        
        // $airTravelerSequence = $request->input('airTravelerSequence');
        // $flightSegmentSequence = $request->input('flightSegmentSequence');
        // $airTravelerSsrCode = $request->input('airTravelerSsrCode');
        // $airTravelerSsrGroup = $request->input('airTravelerSsrGroup');
        // $ssrExplanation = $request->input('ssrExplanation');      
        
        
        $bookingReferenceIDID = $request->input('bookingReferenceIDID');
        $bookingReferenceID = $request->input('bookingReferenceID');

        $user = $request->user();


        $booking = $user ? Booking::where('booking_id', $bookingReferenceIDID)->where('peace_id', $user->peace_id)->first()
        : Booking::where('booking_id', $bookingReferenceIDID)->where('guest_session_token', $request->input('guest_session_token'))->first();

        if (!$booking) {
            return response()->json([
                "error" => true,
                "message" => "you are not authorized to carry out this action"
            ], 401);
        }


        $xml = $this->addWeightBuilderTest->addWeightTest(
            $preferredCurrency,
            $adviceCodeSegmentExist,
            $bookFlightSegmentListActionCode,
            $bookFlightAddOnSegment,
            $bookingClassCabin,
            $bookingClassResBookDesigCode,
            $resBookDesignQuantity,
            $fareInfoCabin,
            $fareInfoCabinClassCode,
            $fareBaggageAllowanceType,
            $fareBaggageMaxAllowedPieces,
            $unitOfMeasureCode,
            $fareBaggageAllowanceWeight,
            $fareGroupName,
            $fareReferenceCode,
            $fareReferenceID,
            $fareReferenceName,
            $bookFlightSegmentSequence,
            $resBookDesigCode,
            $flightSegmentCode,
            $flightSegmentCodeContext,
            $arrivalAirportCityLocationCode,
            $arrivalAirportCityLocationName,
            $arrivalAirportCityLocationNameLanguage,
            $arrivalAirportCountryLocationCode,
            $arrivalAirportCountryLocationName,
            $arrivalAirportCountryLocationNameLanguage,
            $arrivalAirportCountryCurrencyCode,
            $arrivalAirportCodeContext,
            $arrivalAirportLanguage,
            $arrivalAirportLocationCode,
            $arrivalAirportLocationName,
            $arrivalAirportTerminal,
            $arrivalAirportTimeZoneInfo,
            $arrivalDateTime,
            $arrivalDateTimeUTC,
            $departureAirportCitytLocationCode,
            $departureAirportCityLocationName,
            $departureAirportCityLocationNameLanguage,
            $departureAirportCountryLocationCode,
            $departureAirportCountryLocationName,
            $departureCountryLocationNameLanguage,
            $departureCountryCurrencyCode,
            $departureAirportCodeContext,
            $departureAirportLanguage,
            $departureAirportLocationCode,
            $departureAirportLocationName,
            $departureAirportTimeZoneInfo,
            $departureDateTime,
            $departureDateTimeUTC,
            $flightNumber,
            $flightSegmentID,
            $ondControlled,
            $departureAirportSector,
            $departureFlightCodeShare,
            $departureFlightDistance,
            $equipmentAirEquipType,
            $equipmentChangeOfGauge,
            $flightNotes,
            $flownMileageQty,
            $iatciFlight,
            $journeyDuration,
            $onTimeRate,
            $remark,
            $secureFlightDataRequired,
            $segmentStatusByFirstLeg,
            $stopQuantity,
            $involuntaryPermissionGiven,
            $legStatus,
            $referenceID,
            $responseCode,
            $sequenceNumber,
            $status,
            $airTravelerList,
            $ancillaryRequestList,
            $bookingReferenceIDID,
            $bookingReferenceID
        );
        // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            // dd($response);

            return response()->json([
                "error" => false,
                "message" => "seat select successfully",
                "data" => $response                
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
}
