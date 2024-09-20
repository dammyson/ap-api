<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\AddSeatRequest;
use App\Services\Soap\AddSeatBuilder;
use Illuminate\Http\Request;

class AddSeatController extends Controller
{
    protected $addSeatBuilder; 
    protected $craneAncillaryOTASoapService;
   
    public function __construct(AddSeatBuilder $addSeatBuilder)
    {
        $this->addSeatBuilder = $addSeatBuilder;
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }
    
    public function addSeat(AddSeatRequest $request) {
        $adviceCodeSegmentExist = $request->input('adviceCodeSegmentExist'); 
        $actionCode = $request->input('actionCode'); 
        $addOnSegment = $request->input('addOnSegment'); 
        $cabin = $request->input('cabin'); 
        $resBookDesigCode = $request->input('resBookDesigCode'); 
        $resBookDesigQuantity = $request->input('resBookDesigQuantity');
        $fareInfoCabin = $request->input('fareInfoCabin'); 
        $cabinClassCode = $request->input('cabinClassCode'); 
        $allowanceType = $request->input('allowanceType'); 
        $maxAllowedPieces = $request->input('maxAllowedPieces'); 
        $unitOfMeasureCode = $request->input('unitOfMeasureCode'); 
        $weight = $request->input('weight'); 
        $fareGroupName = $request->input('fareGroupName'); 
        $fareReferenceCode = $request->input('fareReferenceCode'); 
        $fareReferenceID = $request->input('fareReferenceID'); 
        $fareReferenceName = $request->input('fareReferenceName'); 
        $flightSegmentSequence = $request->input('flightSegmentSequence');
        $flightSegmentResBookDesigCode = $request->input('flightSegmentResBookDesigCode'); 
        $airlineCode = $request->input('airlineCode'); 
        $airlineCodeContext = $request->input('airlineCodeContext');
        $arrivalAirportCityLocationCode = $request->input('arrivalAirportCityLocationCode'); 
        $arrivalAirportCityLocationName = $request->input('arrivalAirportCityLocationName'); 
        $arrivalAirportCityLocationNameLanguage = $request->input('arrivalAirportCityLocationNameLanguage'); 
        $arrivalAirportCountryLocationCode = $request->input('arrivalAirportCountryLocationCode');
        $arrivalAirportCountryLocationName = $request->input('arrivalAirportCountryLocationName'); 
        $arrivalAirportCountryLocationNameLanguage = $request->input('arrivalAirportCountryLocationNameLanguage'); 
        $arrivalAirportCurrencyCode = $request->input('arrivalAirportCurrencyCode'); 
        $arrivalAirportCodeContext = $request->input('arrivalAirportCodeContext'); 
        $arrivalAirportLanguage = $request->input('arrivalAirportLanguage'); 
        $arrivalAirportLocationCode = $request->input('arrivalAirportLocationCode'); 
        $arrivalAirportLocationName = $request->input('arrivalAirportLocationName'); 
        $arrivalAirportTerminal = $request->input('arrivalAirportTerminal'); 
        $arrivalAirportTimeZoneInfo = $request->input('arrivalAirportTimeZoneInfo'); 
        $arrivalAirportDateTime = $request->input('arrivalAirportDateTime'); 
        $arrivalAirportDateTimeUTC = $request->input('arrivalAirportDateTimeUTC'); 
        $departureAirportCityLocationCode = $request->input('departureAirportCityLocationCode'); 
        $departureAirportCityLocationName = $request->input('departureAirportCityLocationName'); 
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage'); 
        $departureAirportCountryLocationCode = $request->input('departureAirportCountryLocationCode'); 
        $departureAirportCountryLocationName = $request->input('departureAirportCountryLocationName'); 
        $departureAirportCountryLocationNameLanguage = $request->input('departureAirportCountryLocationNameLanguage'); 
        $departureAirportCurrencyCode = $request->input('departureAirportCurrencyCode'); 
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
        $bookFlightSegmentSector = $request->input('bookFlightSegmentSector'); 
        $bookFlightSegmentCodeShare = $request->input('bookFlightSegmentCodeShare'); 
        $bookFlightSegmentDistance = $request->input('bookFlightSegmentDistance'); 
        $airEquipType = $request->input('airEquipType'); 
        $changeOfGauge = $request->input('changeOfGauge'); 
        $DeiCodeOne = $request->input('DeiCodeOne'); 
        $explanationOne = $request->input('explanationOne'); 
        $noteOne = $request->input('noteOne'); 
        $DeiCodeTwo = $request->input('DeiCodeTwo');
        $explanationTwo = $request->input('explanationTwo'); 
        $noteTwo = $request->input('noteTwo'); 
        $DeiCodeThree = $request->input('DeiCodeThree'); 
        $explanationThree = $request->input('explanationThree'); 
        $noteThree = $request->input('noteThree'); 
        $flownMileageQty = $request->input('flownMileageQty'); 
        $iatciFlight = $request->input('iatciFlight'); 
        $journeyDuration = $request->input('journeyDuration'); 
        $onTimeRate = $request->input('onTimeRate'); 
        $remark = $request->input('remark'); 
        $secureFlightDataRequired = $request->input('secureFlightDataRequired'); 
        $segmentStatusByFirstLeg = $request->input('segmentStatusByFirstLeg'); 
        $stopQuantity = $request->input('stopQuantity'); 
        $involuntaryPermissionGiven = $request->input('involuntaryPermissionGiven'); 
        $bookingLegStatus = $request->input('bookingLegStatus'); 
        $bookingReferenceID = $request->input('bookingReferenceID'); 
        $bookingResponseCode = $request->input('bookingResponseCode'); 
        $bookingSequenceNumber = $request->input('bookingSequenceNumber'); 
        $bookingFlightStatus = $request->input('bookingFlightStatus'); 
        $accompaniedByInfant = $request->input('accompaniedByInfant'); 
        $airTravelerListbirthDate = $request->input('airTravelerListbirthDate'); 
        $contactPersonEmail = $request->input('contactPersonEmail'); 
        $emailMarkedForSendingRezInfo = $request->input('emailMarkedForSendingRezInfo'); 
        $emailPreferred = $request->input('emailPreferred'); 
        $emailSharedMarketInd = $request->input('emailSharedMarketInd'); 
        $contactPersonGivenName = $request->input('contactPersonGivenName'); 
        $contactPersonShareMarketIndOne = $request->input('contactPersonShareMarketIndOne'); 
        $personNameSurname = $request->input('personNameSurname'); 
        $phoneNumberAreaCode = $request->input('phoneNumberAreaCode'); 
        $phoneNumberCountryCode = $request->input('phoneNumberCountryCode'); 
        $phoneNumberMarkedForSendingRezInfo = $request->input('phoneNumberMarkedForSendingRezInfo'); 
        $phoneNumberPreferred = $request->input('phoneNumberPreferred'); 
        $phoneNumberShareMarketInd = $request->input('phoneNumberShareMarketInd'); 
        $phoneNumberSubscriberNumber = $request->input('phoneNumberSubscriberNumber'); 
        $contactPersonShareContactInfo = $request->input('contactPersonShareContactInfo');
        $contactPersonShareMarketIndTwo = $request->input('contactPersonShareMarketIndTwo'); 
        $contactPersonUseForInvoicing = $request->input('contactPersonUseForInvoicing'); 
        $documentInfoListBirthDate = $request->input('documentInfoListBirthDate'); 
        $documentInfoListGivenName = $request->input('documentInfoListGivenName'); 
        $documentInfoListShareMarketInd = $request->input('documentInfoListShareMarketInd'); 
        $documentInfoSurname = $request->input('documentInfoSurname'); 
        $documentInfoListGender = $request->input('documentInfoListGender'); 
        $emergencyContactInfoShareMarketInd = $request->input('emergencyContactInfoShareMarketInd'); 
        $emergencyContactInfoDecline = $request->input('emergencyContactInfoDecline'); 
        $emergencyContactMarkedForSendingRezInfo = $request->input('emergencyContactMarkedForSendingRezInfo'); 
        $emergencyContactPreferred = $request->input('emergencyContactPreferred'); 
        $emergencyContactShareMarketInd = $request->input('emergencyContactShareMarketInd'); 
        $emergencyContactShareContactInfo = $request->input('emergencyContactShareContactInfo'); 
        $contactPersonGender = $request->input('contactPersonGender'); 
        $contactPersonHasStrecher = $request->input('contactPersonHasStrecher'); 
        $contactPersonParentSequence = $request->input('contactPersonParentSequence'); 
        $contactPersonPassengerTypeCode = $request->input('contactPersonPassengerTypeCode'); 
        $personNameGivenName = $request->input('personNameGivenName'); 
        $personNameNameTitle = $request->input('personNameNameTitle'); 
        $personNameShareMarketInd = $request->input('personNameShareMarketInd'); 
        $personNameENGivenName = $request->input('personNameENGivenName'); 
        $personNameENNameTitle = $request->input('personNameENNameTitle'); 
        $personNameENShareMarketInd = $request->input('personNameENShareMarketInd'); 
        $personNameENSurname = $request->input('personNameENSurname'); 
        $requestedSeatCount = $request->input('requestedSeatCount'); 
        $airTravelerListShareMarketInd = $request->input('airTravelerListShareMarketInd'); 
        $travelerReferenceID = $request->input('travelerReferenceID'); 
        $unaccompaniedMinor = $request->input('unaccompaniedMinor'); 
        $airTravelerSequence = $request->input('airTravelerSequence'); 
        $ancillaryRequestListFlightSegmentSequence = $request->input('ancillaryRequestListFlightSegmentSequence'); 
        $ssrCode = $request->input('ssrCode');
        $ssrGroup = $request->input('ssrGroup');
        $ssrExplanation = $request->input('ssrExplanation'); 
        $bookingReferenceCompanyCityCode = $request->input('bookingReferenceCompanyCityCode'); 
        $bookingReferenceCompanyCode = $request->input('bookingReferenceCompanyCode'); 
        $bookingReferenceCodeContext = $request->input('bookingReferenceCodeContext'); 
        $bookingReferenceCompanyFullName = $request->input('bookingReferenceCompanyFullName'); 
        $bookingReferenceCompanyShortName = $request->input('bookingReferenceCompanyShortName'); 
        $bookingReferenceCountryCode = $request->input('bookingReferenceCountryCode'); 
        $bookingReferenceIDID = $request->input('bookingReferenceIDID'); 
        $referenceID = $request->input('referenceID');
        
        $xml = $this->addSeatBuilder->addSeat(
            $adviceCodeSegmentExist, 
            $actionCode, 
            $addOnSegment, 
            $cabin, 
            $resBookDesigCode, 
            $resBookDesigQuantity,
            $fareInfoCabin, 
            $cabinClassCode, 
            $allowanceType, 
            $maxAllowedPieces, 
            $unitOfMeasureCode, 
            $weight, 
            $fareGroupName, 
            $fareReferenceCode, 
            $fareReferenceID, 
            $fareReferenceName, 
            $flightSegmentSequence,
            $flightSegmentResBookDesigCode, 
            $airlineCode, 
            $airlineCodeContext,
            $arrivalAirportCityLocationCode, 
            $arrivalAirportCityLocationName, 
            $arrivalAirportCityLocationNameLanguage, 
            $arrivalAirportCountryLocationCode,
            $arrivalAirportCountryLocationName, 
            $arrivalAirportCountryLocationNameLanguage, 
            $arrivalAirportCurrencyCode, 
            $arrivalAirportCodeContext, 
            $arrivalAirportLanguage, 
            $arrivalAirportLocationCode, 
            $arrivalAirportLocationName, 
            $arrivalAirportTerminal, 
            $arrivalAirportTimeZoneInfo, 
            $arrivalAirportDateTime, 
            $arrivalAirportDateTimeUTC, 
            $departureAirportCityLocationCode, 
            $departureAirportCityLocationName, 
            $departureAirportCityLocationNameLanguage, 
            $departureAirportCountryLocationCode, 
            $departureAirportCountryLocationName, 
            $departureAirportCountryLocationNameLanguage, 
            $departureAirportCurrencyCode, 
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
            $bookFlightSegmentSector, 
            $bookFlightSegmentCodeShare, 
            $bookFlightSegmentDistance, 
            $airEquipType, 
            $changeOfGauge, 
            $DeiCodeOne, 
            $explanationOne, 
            $noteOne, 
            $DeiCodeTwo,
            $explanationTwo, 
            $noteTwo, 
            $DeiCodeThree, 
            $explanationThree, 
            $noteThree, 
            $flownMileageQty, 
            $iatciFlight, 
            $journeyDuration, 
            $onTimeRate, 
            $remark, 
            $secureFlightDataRequired, 
            $segmentStatusByFirstLeg, 
            $stopQuantity, 
            $involuntaryPermissionGiven, 
            $bookingLegStatus, 
            $bookingReferenceID, 
            $bookingResponseCode, 
            $bookingSequenceNumber, 
            $bookingFlightStatus, 
            $accompaniedByInfant, 
            $airTravelerListbirthDate, 
            $contactPersonEmail, 
            $emailMarkedForSendingRezInfo, 
            $emailPreferred, 
            $emailSharedMarketInd, 
            $contactPersonGivenName, 
            $contactPersonShareMarketIndOne, 
            $personNameSurname, 
            $phoneNumberAreaCode, 
            $phoneNumberCountryCode, 
            $phoneNumberMarkedForSendingRezInfo, 
            $phoneNumberPreferred, 
            $phoneNumberShareMarketInd, 
            $phoneNumberSubscriberNumber, 
            $contactPersonShareContactInfo,
            $contactPersonShareMarketIndTwo, 
            $contactPersonUseForInvoicing, 
            $documentInfoListBirthDate, 
            $documentInfoListGivenName, 
            $documentInfoListShareMarketInd, 
            $documentInfoSurname, 
            $documentInfoListGender, 
            $emergencyContactInfoShareMarketInd, 
            $emergencyContactInfoDecline, 
            $emergencyContactMarkedForSendingRezInfo, 
            $emergencyContactPreferred, 
            $emergencyContactShareMarketInd, 
            $emergencyContactShareContactInfo, 
            $contactPersonGender, 
            $contactPersonHasStrecher, 
            $contactPersonParentSequence, 
            $contactPersonPassengerTypeCode, 
            $personNameGivenName, 
            $personNameNameTitle, 
            $personNameShareMarketInd, 
            $personNameENGivenName, 
            $personNameENNameTitle, 
            $personNameENShareMarketInd, 
            $personNameENSurname, 
            $requestedSeatCount, 
            $airTravelerListShareMarketInd, 
            $travelerReferenceID, 
            $unaccompaniedMinor, 
            $airTravelerSequence, 
            $ancillaryRequestListFlightSegmentSequence, 
            $ssrCode,
            $ssrGroup,
            $ssrExplanation, 
            $bookingReferenceCompanyCityCode, 
            $bookingReferenceCompanyCode, 
            $bookingReferenceCodeContext, 
            $bookingReferenceCompanyFullName, 
            $bookingReferenceCompanyShortName, 
            $bookingReferenceCountryCode, 
            $bookingReferenceIDID, 
            $referenceID
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/AddSsr';

        try {
            $response = $this->craneAncillaryOTASoapService->run($function, $xml);
            dd($response);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
