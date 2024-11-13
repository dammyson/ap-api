<?php

namespace App\Services\Soap;

use App\Services\Utility\FlightNotes;

class AddWeightBuilderTest {

   protected $flightNotes;
   public function __construct(FlightNotes $flightNote) {
      $this->flightNotes = $flightNote;

   }

   public function addWeightTest(
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

      $ancillaryRequestList,


      $bookingReferenceIDID,
      $bookingReferenceID


   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
               <impl:AddSsr>
               <AddSsrRequest>
               <clientInformation>
               <clientIP>129.0.0.1</clientIP>
               <member>false</member>
               <password>SCINTILLA</password>
               <userName>SCINTILLA</userName>
               <preferredCurrency>NGN</preferredCurrency>
               </clientInformation>
                  <airItinerary>
                     <adviceCodeSegmentExist>' . htmlspecialchars($adviceCodeSegmentExist, ENT_XML1, 'UTF-8') . '</adviceCodeSegmentExist>
                        <bookOriginDestinationOptions>
                           <bookOriginDestinationOptionList>
                              <bookFlightSegmentList>
                                 <actionCode>' . htmlspecialchars($bookFlightSegmentListActionCode, ENT_XML1, 'UTF-8') . '</actionCode>
                                 <addOnSegment>' . htmlspecialchars($bookFlightAddOnSegment, ENT_XML1, 'UTF-8') . '</addOnSegment>
                                 <bookingClass>
                                    <cabin>' . htmlspecialchars($bookingClassCabin, ENT_XML1, 'UTF-8') . '</cabin>
                                    <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                    <resBookDesigQuantity>' . htmlspecialchars($resBookDesignQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                 </bookingClass>
                                 <fareInfo>
                                    <cabin>' . htmlspecialchars($fareInfoCabin, ENT_XML1, 'UTF-8') . '</cabin>
                                    <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                    <fareBaggageAllowance>
                                       <allowanceType>' . htmlspecialchars($fareBaggageAllowanceType, ENT_XML1, 'UTF-8') . '</allowanceType>
                                       <maxAllowedPieces>' . htmlspecialchars($fareBaggageMaxAllowedPieces, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                       <maxAllowedWeight>
                                          <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCode, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                          <weight>' . htmlspecialchars($fareBaggageAllowanceWeight, ENT_XML1, 'UTF-8') . '</weight>
                                       </maxAllowedWeight>
                                    </fareBaggageAllowance>
                                    <fareGroupName>' . htmlspecialchars($fareGroupName, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                    <fareReferenceCode>' . htmlspecialchars($fareReferenceCode, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                    <fareReferenceID>' . htmlspecialchars($fareReferenceID, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                    <fareReferenceName>' . htmlspecialchars($fareReferenceName, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                    <flightSegmentSequence>' . htmlspecialchars($bookFlightSegmentSequence, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                    <resBookDesigCode>' . htmlspecialchars($resBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                 </fareInfo>
                                 <flightSegment>
                                    <airline>
                                       <code>' . htmlspecialchars($flightSegmentCode, ENT_XML1, 'UTF-8') . '</code>
                                       <codeContext>' . htmlspecialchars($flightSegmentCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                                    </airline>
                                    <arrivalAirport>
                                       <cityInfo>
                                          <city>
                                             <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($arrivalAirportCityLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                          </city>
                                          <country>
                                             <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($arrivalAirportCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                             <currency>
                                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                                             </currency>
                                          </country>
                                       </cityInfo>
                                       <codeContext>' . htmlspecialchars($arrivalAirportCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                                       <language>' . htmlspecialchars($arrivalAirportLanguage, ENT_XML1, 'UTF-8') . '</language>
                                       <locationCode>' . htmlspecialchars($arrivalAirportLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                       <locationName>' . htmlspecialchars($arrivalAirportLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                       <terminal>' . htmlspecialchars($arrivalAirportTerminal, ENT_XML1, 'UTF-8') . '</terminal>
                                       <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                    </arrivalAirport>
                                    <arrivalDateTime>' . htmlspecialchars($arrivalDateTime, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                    <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTC, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                    <departureAirport>
                                       <cityInfo>
                                          <city>
                                             <locationCode>' . htmlspecialchars($departureAirportCitytLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($departureAirportCityLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                          </city>
                                          <country>
                                             <locationCode>' . htmlspecialchars($departureAirportCountryLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($departureAirportCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($departureCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                             <currency>
                                                <code>' . htmlspecialchars($departureCountryCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                                             </currency>
                                          </country>
                                       </cityInfo>
                                       <codeContext>' . htmlspecialchars($departureAirportCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                                       <language>' . htmlspecialchars($departureAirportLanguage, ENT_XML1, 'UTF-8') . '</language>
                                       <locationCode>' . htmlspecialchars($departureAirportLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                       <locationName>' . htmlspecialchars($departureAirportLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                       <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                    </departureAirport>
                                    <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                    <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTC, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                    <flightNumber>' . htmlspecialchars($flightNumber, ENT_XML1, 'UTF-8') . '</flightNumber>
                                    <flightSegmentID>' . htmlspecialchars($flightSegmentID, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                    <ondControlled>' . htmlspecialchars($ondControlled, ENT_XML1, 'UTF-8') . '</ondControlled>
                                    <sector>' . htmlspecialchars($departureAirportSector, ENT_XML1, 'UTF-8') . '</sector>
                                    <codeshare>' . htmlspecialchars($departureFlightCodeShare, ENT_XML1, 'UTF-8') . '</codeshare>
                                    <distance>' . htmlspecialchars($departureFlightDistance, ENT_XML1, 'UTF-8') . '</distance>
                                    <equipment>
                                       <airEquipType>' . htmlspecialchars($equipmentAirEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                                       <changeofGauge>' . htmlspecialchars($equipmentChangeOfGauge, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                    </equipment>
                                    '. 
                                       $this->flightNotes->flightNotesArray($flightNotes) 
                                    .'
                                    <flownMileageQty>' . htmlspecialchars($flownMileageQty, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                    <iatciFlight>' . htmlspecialchars($iatciFlight, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                    <journeyDuration>' . htmlspecialchars($journeyDuration, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                    <onTimeRate>' . htmlspecialchars($onTimeRate, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                    <remark>' . htmlspecialchars($remark, ENT_XML1, 'UTF-8') . '</remark>
                                    <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequired, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                    <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLeg, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                    <stopQuantity>' . htmlspecialchars($stopQuantity, ENT_XML1, 'UTF-8') . '</stopQuantity>
                                    </flightSegment>
                                 <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGiven, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                                 <legStatus>' . htmlspecialchars($legStatus, ENT_XML1, 'UTF-8') . '</legStatus>
                                 <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                                 <responseCode>' . htmlspecialchars($responseCode, ENT_XML1, 'UTF-8') . '</responseCode>
                                 <sequenceNumber>' . htmlspecialchars($sequenceNumber, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                                 <status>' . htmlspecialchars($status, ENT_XML1, 'UTF-8') . '</status>
                           </bookFlightSegmentList>
                        </bookOriginDestinationOptionList>
                     </bookOriginDestinationOptions>
                  </airItinerary>
                  <airTravelerList>
                     <accompaniedByInfant>' . htmlspecialchars($accompaniedByInfant, ENT_XML1, 'UTF-8') . '</accompaniedByInfant>
                     <birthDate>' . htmlspecialchars($airTravelerbirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                     <contactPerson>
                        <email>
                           <email>' . htmlspecialchars($contactPersonEmail, ENT_XML1, 'UTF-8') . '</email>
                           <markedForSendingRezInfo>' . htmlspecialchars($airTravelerListEmailMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($emailPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($emailSharedMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </email>
                        <personName>
                           <givenName>' . htmlspecialchars($airTravelerListPersonNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                           <shareMarketInd>' . htmlspecialchars($airTravelerListpersonNameShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <surname>' . htmlspecialchars($airTravelerListPersonNameSurname, ENT_XML1, 'UTF-8') . '</surname>
                        </personName>
                        <phoneNumber>
                           <areaCode>' . htmlspecialchars($phoneNumberAreaCode, ENT_XML1, 'UTF-8') . '</areaCode>
                           <countryCode>' . htmlspecialchars($phoneCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                           <markedForSendingRezInfo>' . htmlspecialchars($phoneNumberEmailMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($phoneNumberPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($phoneNumberShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <subscriberNumber>' . htmlspecialchars($phoneNumberSubscriberNumber, ENT_XML1, 'UTF-8') . '</subscriberNumber>
                        </phoneNumber>
                        <shareContactInfo>' . htmlspecialchars($airTravelerShareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                        <shareMarketInd>' . htmlspecialchars($airTravelerShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <useForInvoicing>' . htmlspecialchars($useForInvoicing, ENT_XML1, 'UTF-8') . '</useForInvoicing>
                     </contactPerson>
                     <documentInfoList>
                        <birthDate>' . htmlspecialchars($documentInfoBirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                        <docHolderFormattedName>
                           <givenName>' . htmlspecialchars($documentHolderFormattedGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                           <shareMarketInd>' . htmlspecialchars($documentHolderFormattedShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <surname>' . htmlspecialchars($documentHolderFormattedSurname, ENT_XML1, 'UTF-8') . '</surname>
                        </docHolderFormattedName>
                        <gender>' . htmlspecialchars($documentHolderFormattedGender, ENT_XML1, 'UTF-8') . '</gender>
                     </documentInfoList>
                     <emergencyContactInfo>
                        <contactName>
                           <shareMarketInd>' . htmlspecialchars($emergencyContactInfoshareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </contactName>
                        <decline>' . htmlspecialchars($decline, ENT_XML1, 'UTF-8') . '</decline>
                        <email>
                           <markedForSendingRezInfo>' . htmlspecialchars($emergencyContactMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($emergencyContactPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($emergencyContactShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </email>
                        <shareContactInfo>' . htmlspecialchars($shareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                     </emergencyContactInfo>
                     <gender>' . htmlspecialchars($airTravelerGender, ENT_XML1, 'UTF-8') . '</gender>
                     <hasStrecher>' . htmlspecialchars($airTravelerHasStrecher, ENT_XML1, 'UTF-8') . '</hasStrecher>
                     <parentSequence>' . htmlspecialchars($parentSequence, ENT_XML1, 'UTF-8') . '</parentSequence>
                     <passengerTypeCode>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                     <personName>
                        <givenName>' . htmlspecialchars($personNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                        <nameTitle>' . htmlspecialchars($personNameTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                        <shareMarketInd>' . htmlspecialchars($personNameshareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <surname>' . htmlspecialchars($personNameSurname, ENT_XML1, 'UTF-8') . '</surname>
                     </personName>
                     <personNameEN>
                        <givenName>' . htmlspecialchars($personNameENGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                        <nameTitle>' . htmlspecialchars($personNameENTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                        <shareMarketInd>' . htmlspecialchars($personNameENShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <surname>' . htmlspecialchars($personNameENShareMarketSurname, ENT_XML1, 'UTF-8') . '</surname>
                     </personNameEN>
                     <requestedSeatCount>' . htmlspecialchars($requestedSeatCount, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                     <shareMarketInd>' . htmlspecialchars($shareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                     <travelerReferenceID>' . htmlspecialchars($travelerReferenceID, ENT_XML1, 'UTF-8') . '</travelerReferenceID>
                     <unaccompaniedMinor>' . htmlspecialchars($airTravelUnaccompaniedMinor, ENT_XML1, 'UTF-8') . '</unaccompaniedMinor>
                  </airTravelerList>'.
                  $this->ancillaryRequestList($ancillaryRequestList)
                  .'<bookingReferenceID>
                     <companyName>
                        <cityCode>LOS</cityCode>
                        <code>P4</code>
                        <codeContext>CRANE</codeContext>
                        <companyFullName>SCINTILLA</companyFullName>
                        <companyShortName>SCINTILLA</companyShortName>
                        <countryCode>NG</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($bookingReferenceIDID, ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($bookingReferenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                  </bookingReferenceID>
               </AddSsrRequest>
               </impl:AddSsr>
         </soapenv:Body>
      </soapenv:Envelope>';
      
      return $xml;  
   }

   public function ancillaryRequestList($ancillaryRequestList) {

        $xml = '';
        
        foreach ($ancillaryRequestList as $string) {
            $xml .= '<ancillaryRequestList>
                        <airTravelerSequence>' . htmlspecialchars($string['airTravelerSequence'], ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                        <flightSegmentSequence>' . htmlspecialchars($string['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                        <ssrCode>' . htmlspecialchars($string['airTravelerSsrCode'], ENT_XML1, 'UTF-8') . '</ssrCode>
                        <ssrGroup>' . htmlspecialchars($string['airTravelerSsrGroup'], ENT_XML1, 'UTF-8') . '</ssrGroup>
                        <ssrExplanation>' . htmlspecialchars($string['ssrExplanation'], ENT_XML1, 'UTF-8') . '</ssrExplanation>
                    </ancillaryRequestList>';
        }
        
        return $xml;
   }
}