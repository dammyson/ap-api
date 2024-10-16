<?php

namespace App\Http\Controllers\Test;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\AddWeightBuilder;
use App\Http\Requests\Test\addWeightRequest;

class AddWeightController extends Controller
{
    protected $addWeightBuilder;
    protected $craneAncillaryOTASoapService;

    public function __construct(AddWeightBuilder $addWeightBuilder)
    {
        $this->addWeightBuilder = $addWeightBuilder;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    // public function addWeight(Request $request) {
    //     dd('test');
    // }
  
    
    public function addWeight(addWeightRequest $request, $invoiceId) {
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
        $flightNotesDeiCodeOne = $request->input('flightNotesDeiCodeOne');
        $flightNotesExplanationOne = $request->input('flightNotesExplanationOne');
        $flightNoteOne = $request->input('flightNoteOne');
        $flightNotesDeiCodeTwo = $request->input('flightNotesDeiCodeTwo');
        $flightNotesExplanationTwo = $request->input('flightNotesExplanationTwo');
        $flightNotesNoteTwo = $request->input('flightNotesNoteTwo');
        $flightNoteDeiCodeThree = $request->input('flightNoteDeiCodeThree');
        $flightExplanationThree = $request->input('flightExplanationThree');
        $flightNotesNoteThree = $request->input('flightNotesNoteThree');
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
        $accompaniedByInfant = $request->input('accompaniedByInfant');
        $airTravelerbirthDate = $request->input('airTravelerbirthDate');
        $contactPersonEmail = $request->input('contactPersonEmail');
        $airTravelerListEmailMarkedForSendingRezInfo = $request->input('airTravelerListEmailMarkedForSendingRezInfo');
        $emailPreferred = $request->input('emailPreferred');
        $emailSharedMarketInd = $request->input('emailSharedMarketInd');
        $airTravelerListPersonNameGivenName = $request->input('airTravelerListPersonNameGivenName');
        $airTravelerListpersonNameShareMarketInd = $request->input('airTravelerListpersonNameShareMarketInd');
        $airTravelerListPersonNameSurname = $request->input('airTravelerListPersonNameSurname');
        $phoneNumberAreaCode = $request->input('phoneNumberAreaCode');
        $phoneCountryCode = $request->input('phoneCountryCode');
        $phoneNumberEmailMarkedForSendingRezInfo = $request->input('phoneNumberEmailMarkedForSendingRezInfo');
        $phoneNumberPreferred = $request->input('phoneNumberPreferred');
        $phoneNumberShareMarketInd = $request->input('phoneNumberShareMarketInd');
        $phoneNumberSubscriberNumber = $request->input('phoneNumberSubscriberNumber');
        $airTravelerShareContactInfo = $request->input('airTravelerShareContactInfo');
        $airTravelerShareMarketInd = $request->input('airTravelerShareMarketInd');
        $useForInvoicing = $request->input('useForInvoicing');
        $documentInfoBirthDate = $request->input('documentInfoBirthDate');
        $documentHolderFormattedGivenName = $request->input('documentHolderFormattedGivenName');
        $documentHolderFormattedShareMarketInd = $request->input('documentHolderFormattedShareMarketInd');
        $documentHolderFormattedSurname = $request->input('documentHolderFormattedSurname');
        $documentHolderFormattedGender = $request->input('documentHolderFormattedGender');
        $emergencyContactInfoshareMarketInd = $request->input('emergencyContactInfoshareMarketInd');
        $decline = $request->input('decline');
        $emergencyContactMarkedForSendingRezInfo = $request->input('emergencyContactMarkedForSendingRezInfo');
        $emergencyContactPreferred = $request->input('emergencyContactPreferred');
        $emergencyContactShareMarketInd = $request->input('emergencyContactShareMarketInd');
        $shareContactInfo = $request->input('shareContactInfo');
        $airTravelerGender = $request->input('airTravelerGender');
        $airTravelerHasStrecher = $request->input('airTravelerHasStrecher');
        $parentSequence = $request->input('parentSequence');
        $passengerTypeCode = $request->input('passengerTypeCode');
        $personNameGivenName = $request->input('personNameGivenName');
        $personNameTitle = $request->input('personNameTitle');
        $personNameshareMarketInd = $request->input('personNameshareMarketInd');
        $personNameSurname = $request->input('personNameSurname');
        $personNameENGivenName = $request->input('personNameENGivenName');
        $personNameENTitle = $request->input('personNameENTitle');
        $personNameENShareMarketInd = $request->input('personNameENShareMarketInd');
        $personNameENShareMarketSurname = $request->input('personNameENShareMarketSurname');
        $requestedSeatCount = $request->input('requestedSeatCount');
        $shareMarketInd = $request->input('shareMarketInd');
        $travelerReferenceID = $request->input('travelerReferenceID');
        $airTravelUnaccompaniedMinor = $request->input('airTravelUnaccompaniedMinor');
        $airTravelerSequence = $request->input('airTravelerSequence');
        $flightSegmentSequence = $request->input('flightSegmentSequence');
        $airTravelerSsrCode = $request->input('airTravelerSsrCode');
        $airTravelerSsrGroup = $request->input('airTravelerSsrGroup');
        $ssrExplanation = $request->input('ssrExplanation');
        $cityCode = $request->input('cityCode');
        $companyCode = $request->input('companyCode');
        $bookingRequestListCodeContext = $request->input('bookingRequestListCodeContext');
        $companyFullName = $request->input('companyFullName');
        $companyShortName = $request->input('companyShortName');
        $bookingReferenceCountryCode = $request->input('bookingReferenceCountryCode');
        $bookingReferenceIDID = $request->input('bookingReferenceIDID');
        $bookingReferenceID = $request->input('bookingReferenceID');


        $xml = $this->addWeightBuilder->addWeight(
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
            $flightNotesDeiCodeOne,
            $flightNotesExplanationOne,
            $flightNoteOne,
            $flightNotesDeiCodeTwo,
            $flightNotesExplanationTwo,
            $flightNotesNoteTwo,
            $flightNoteDeiCodeThree,
            $flightExplanationThree,
            $flightNotesNoteThree,
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
            $accompaniedByInfant,
            $airTravelerbirthDate,
            $contactPersonEmail,
            $airTravelerListEmailMarkedForSendingRezInfo,
            $emailPreferred,
            $emailSharedMarketInd,
            $airTravelerListPersonNameGivenName,
            $airTravelerListpersonNameShareMarketInd,
            $airTravelerListPersonNameSurname,
            $phoneNumberAreaCode,
            $phoneCountryCode,
            $phoneNumberEmailMarkedForSendingRezInfo,
            $phoneNumberPreferred,
            $phoneNumberShareMarketInd,
            $phoneNumberSubscriberNumber,
            $airTravelerShareContactInfo,
            $airTravelerShareMarketInd,
            $useForInvoicing,
            $documentInfoBirthDate,
            $documentHolderFormattedGivenName,
            $documentHolderFormattedShareMarketInd,
            $documentHolderFormattedSurname,
            $documentHolderFormattedGender,
            $emergencyContactInfoshareMarketInd,
            $decline,
            $emergencyContactMarkedForSendingRezInfo,
            $emergencyContactPreferred,
            $emergencyContactShareMarketInd,
            $shareContactInfo,
            $airTravelerGender,
            $airTravelerHasStrecher,
            $parentSequence,
            $passengerTypeCode,
            $personNameGivenName,
            $personNameTitle,
            $personNameshareMarketInd,
            $personNameSurname,
            $personNameENGivenName,
            $personNameENTitle,
            $personNameENShareMarketInd,
            $personNameENShareMarketSurname,
            $requestedSeatCount,
            $shareMarketInd,
            $travelerReferenceID,
            $airTravelUnaccompaniedMinor,
            $airTravelerSequence,
            $flightSegmentSequence,
            $airTravelerSsrCode,
            $airTravelerSsrGroup,
            $ssrExplanation,
            $cityCode,
            $companyCode,
            $bookingRequestListCodeContext,
            $companyFullName,
            $companyShortName,
            $bookingReferenceCountryCode,
            $bookingReferenceIDID,
            $bookingReferenceID
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            dd($response);
            $amount = $response["AddSsrResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];
            $bookingId = $response["AddSsrResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["ID"];
            $invoice = InvoiceRecord::find($invoiceId);

            // if user has not paid set the new invoice balance else generate a new invoice
            
            $baggagePrice = 0;
            if (!$invoice->is_paid) {
                $baggagePrice = $invoice->amount - $amount;
                $baggagePrice = abs($baggagePrice);
                $invoice->amount = $amount;
                
            } else { 
                $invoice = InvoiceRecord::create([
                    'amount' => $amount,
                    'booking_id' => $bookingId
                ]);
                $baggagePrice = $amount;
            }
            $invoice->is_paid = false;
            $invoice->save();

            // Use preg_match to extract the number
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

            return response()->json([
                "error" => false,
                "message" => "Baggages added successfully",
                'invoice_id' => $invoice->id,
                "amount" => $amount
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
}
