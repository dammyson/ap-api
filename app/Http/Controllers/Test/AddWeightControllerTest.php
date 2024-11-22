<?php

namespace App\Http\Controllers\Test;

use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\AddWeightBuilderTest;
use App\Http\Requests\Test\addWeightRequest;
use App\Http\Requests\Test\AddWeightRequestTest;

class AddWeightControllerTest extends Controller
{
    protected $addWeightBuilderTest;
    protected $craneAncillaryOTASoapService;

    public function __construct(AddWeightBuilderTest $addWeightBuilderTest) {
        $this->addWeightBuilderTest = $addWeightBuilderTest;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
        
    }

    public function addWeightTest(AddWeightRequestTest $request, $invoiceId) {
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

        $ancillaryRequestList = $request->input('ancillaryRequestList');
        
        // $airTravelerSequence = $request->input('airTravelerSequence');
        // $flightSegmentSequence = $request->input('flightSegmentSequence');
        // $airTravelerSsrCode = $request->input('airTravelerSsrCode');
        // $airTravelerSsrGroup = $request->input('airTravelerSsrGroup');
        // $ssrExplanation = $request->input('ssrExplanation');      
        
        
        $bookingReferenceIDID = $request->input('bookingReferenceIDID');
        $bookingReferenceID = $request->input('bookingReferenceID');

        $xml = $this->addWeightBuilderTest->addWeightTest(
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
        dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            // dd($response);
            $amount = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            $bookingId = $response["AddSsrResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["ID"];
            $invoice = InvoiceRecord::find($invoiceId);

            // if user has not paid set the new invoice balance else generate a new invoice
            
            $baggagePrice = 0;
           
            if (!$invoice->is_paid) {
                $baggagePrice = $invoice->amount - $amount;
                $baggagePrice = abs($baggagePrice);
                $invoice->amount = $amount;
                
            }

            else { 
                $invoice = InvoiceRecord::create([
                    'amount' => $amount,
                    'booking_id' => $bookingId
                ]);
                $baggagePrice = $amount;
            }
            
            $invoice->is_paid = false;
            $invoice->save();

            // Use preg_match to extract the number
            
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
                    'price' => $baggagePrice
                ]);

            }

            return response()->json([
                "error" => false,
                "message" => "Baggages added successfully",
                'invoice_id' => $invoice->id,
                "amount" => $amount
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                // 'response' => $response
        
            ], 500);
        }
    }
}
