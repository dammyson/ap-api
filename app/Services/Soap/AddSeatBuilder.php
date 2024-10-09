<?php

namespace App\Services\Soap;

class AddSeatBuilder {
      public function addSeat(
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
         $personNameNameSurname,
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
                                <actionCode>' . htmlspecialchars($actionCode, ENT_XML1, 'UTF-8') . '</actionCode>
                                <addOnSegment>' . htmlspecialchars($addOnSegment, ENT_XML1, 'UTF-8') . '</addOnSegment>
                                <bookingClass>
                                <cabin>' . htmlspecialchars($cabin, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($resBookDesigQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                </bookingClass>
                                <fareInfo>
                                   <cabin>' . htmlspecialchars($fareInfoCabin, ENT_XML1, 'UTF-8') . '</cabin>
                                   <cabinClassCode>' . htmlspecialchars($cabinClassCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                   <fareBaggageAllowance>
                                   <allowanceType>' . htmlspecialchars($allowanceType, ENT_XML1, 'UTF-8') . '</allowanceType>
                                   <maxAllowedPieces>' . htmlspecialchars($maxAllowedPieces, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                   <maxAllowedWeight>
                                      <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCode, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                      <weight>' . htmlspecialchars($weight, ENT_XML1, 'UTF-8') . '</weight>
                                   </maxAllowedWeight>
                                   </fareBaggageAllowance>
                                   <fareGroupName>' . htmlspecialchars($fareGroupName, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                   <fareReferenceCode>' . htmlspecialchars($fareReferenceCode, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                   <fareReferenceID>' . htmlspecialchars($fareReferenceID, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                   <fareReferenceName>' . htmlspecialchars($fareReferenceName, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                   <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequence, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                   <resBookDesigCode> ' . htmlspecialchars($flightSegmentResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                </fareInfo>
                                <flightSegment>
                                   <airline>
                                      <code>' . htmlspecialchars($airlineCode, ENT_XML1, 'UTF-8') . '</code>
                                      <codeContext>' . htmlspecialchars($airlineCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
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
                                               <code>' . htmlspecialchars($arrivalAirportCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
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
                                   <arrivalDateTime>' . htmlspecialchars($arrivalAirportDateTime, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                   <arrivalDateTimeUTC>' . htmlspecialchars($arrivalAirportDateTimeUTC, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                   <departureAirport>
                                      <cityInfo>
                                         <city>
                                            <locationCode>' . htmlspecialchars($departureAirportCityLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCityLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                         </city>
                                         <country>
                                            <locationCode>' . htmlspecialchars($departureAirportCountryLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                                      <code>' . htmlspecialchars($departureAirportCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
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
                                   <sector>' . htmlspecialchars($bookFlightSegmentSector, ENT_XML1, 'UTF-8') . '</sector>
                                   <accumulatedDuration/>
                                   <codeshare>' . htmlspecialchars($bookFlightSegmentCodeShare, ENT_XML1, 'UTF-8') . '</codeshare>
                                   <distance>' . htmlspecialchars($bookFlightSegmentDistance, ENT_XML1, 'UTF-8') . '</distance>
                                   <equipment>
                                      <airEquipType>' . htmlspecialchars($airEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                                      <changeofGauge>' . htmlspecialchars($changeOfGauge, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                   </equipment>

                                    '.
                                       $this->flightNotes($flightNotes)
                                    .'                                 
                                  
                                   <flownMileageQty>' . htmlspecialchars($flownMileageQty, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                   <groundDuration/>
                                   <iatciFlight>' . htmlspecialchars($iatciFlight, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                   <journeyDuration>' . htmlspecialchars($journeyDuration, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                   <onTimeRate>' . htmlspecialchars($onTimeRate, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                   <remark>' . htmlspecialchars($remark, ENT_XML1, 'UTF-8') . '</remark>
                                   <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequired, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                   <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLeg, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                   <stopQuantity>' . htmlspecialchars($stopQuantity, ENT_XML1, 'UTF-8') . '</stopQuantity>
                                   <trafficRestriction>
                                      <code/>
                                      <explanation/>
                                   </trafficRestriction>
                                </flightSegment>
                                <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGiven, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                                <legStatus>' . htmlspecialchars($bookingLegStatus, ENT_XML1, 'UTF-8') . '</legStatus>
                                <referenceID>' . htmlspecialchars($bookingReferenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                                <responseCode>' . htmlspecialchars($bookingResponseCode, ENT_XML1, 'UTF-8') . '</responseCode>
                                <sequenceNumber>' . htmlspecialchars($bookingSequenceNumber, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                                <status>' . htmlspecialchars($bookingFlightStatus, ENT_XML1, 'UTF-8') . '</status>
                             </bookFlightSegmentList>
                          </bookOriginDestinationOptionList>
                          </bookOriginDestinationOptions>
                          </airItinerary>
                       <airTravelerList>
                          <accompaniedByInfant>' . htmlspecialchars($accompaniedByInfant, ENT_XML1, 'UTF-8') . '</accompaniedByInfant>
                          <birthDate>' . htmlspecialchars($airTravelerListbirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                          <companyInfo/>
                          <contactPerson>
                             <email>
                                <email>' . htmlspecialchars($contactPersonEmail, ENT_XML1, 'UTF-8') . '</email>
                                <markedForSendingRezInfo>' . htmlspecialchars($emailMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                                <preferred>' . htmlspecialchars($emailPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                                <shareMarketInd>' . htmlspecialchars($emailSharedMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             </email>
                             <personName>
                                <givenName>' . htmlspecialchars($contactPersonGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                                <shareMarketInd>' . htmlspecialchars($contactPersonShareMarketIndOne, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                                <surname>' . htmlspecialchars($personNameSurname, ENT_XML1, 'UTF-8') . '</surname>
                             </personName>
                             <phoneNumber>
                                <areaCode>' . htmlspecialchars($phoneNumberAreaCode, ENT_XML1, 'UTF-8') . '</areaCode>
                                <countryCode>' . htmlspecialchars($phoneNumberCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                                <markedForSendingRezInfo>' . htmlspecialchars($phoneNumberMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                                <preferred>' . htmlspecialchars($phoneNumberPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                                <shareMarketInd>' . htmlspecialchars($phoneNumberShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                                <subscriberNumber>' . htmlspecialchars($phoneNumberSubscriberNumber, ENT_XML1, 'UTF-8') . '</subscriberNumber>
                             </phoneNumber>
                             <shareContactInfo>' . htmlspecialchars($contactPersonShareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                             <shareMarketInd>' . htmlspecialchars($contactPersonShareMarketIndTwo, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             <useForInvoicing>' . htmlspecialchars($contactPersonUseForInvoicing, ENT_XML1, 'UTF-8') . '</useForInvoicing>
                          </contactPerson>
                          <documentInfoList>
                             <birthDate>' . htmlspecialchars($documentInfoListBirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                             <docHolderFormattedName>
                                <givenName>' . htmlspecialchars($documentInfoListGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                                <shareMarketInd>' . htmlspecialchars($documentInfoListShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                                <surname>' . htmlspecialchars($documentInfoSurname, ENT_XML1, 'UTF-8') . '</surname>
                             </docHolderFormattedName>
                             <gender>' . htmlspecialchars($documentInfoListGender, ENT_XML1, 'UTF-8') . '</gender>
                          </documentInfoList>
                          <emergencyContactInfo>
                             <contactName>
                                <shareMarketInd>' . htmlspecialchars($emergencyContactInfoShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             </contactName>
                             <decline>' . htmlspecialchars($emergencyContactInfoDecline, ENT_XML1, 'UTF-8') . '</decline>
                             <email>
                                <markedForSendingRezInfo>' . htmlspecialchars($emergencyContactMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                                <preferred>' . htmlspecialchars($emergencyContactPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                                <shareMarketInd>' . htmlspecialchars($emergencyContactShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             </email>
                             <shareContactInfo>' . htmlspecialchars($emergencyContactShareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                          </emergencyContactInfo>
                          <gender>' . htmlspecialchars($contactPersonGender, ENT_XML1, 'UTF-8') . '</gender>
                          <hasStrecher>' . htmlspecialchars($contactPersonHasStrecher, ENT_XML1, 'UTF-8') . '</hasStrecher>
                          <parentSequence>' . htmlspecialchars($contactPersonParentSequence, ENT_XML1, 'UTF-8') . '</parentSequence>
                          <passengerTypeCode>' . htmlspecialchars($contactPersonPassengerTypeCode, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                          <personName>
                             <givenName>' . htmlspecialchars($personNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                             <nameTitle>' . htmlspecialchars($personNameNameTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                             <shareMarketInd>' . htmlspecialchars($personNameShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             <surname>' . htmlspecialchars($personNameNameSurname, ENT_XML1, 'UTF-8') . '</surname>
                          </personName>
                          <personNameEN>
                             <givenName>' . htmlspecialchars($personNameENGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                             <nameTitle>' . htmlspecialchars($personNameENNameTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                             <shareMarketInd>' . htmlspecialchars($personNameENShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                             <surname>' . htmlspecialchars($personNameENSurname, ENT_XML1, 'UTF-8') . '</surname>
                          </personNameEN>
                          <requestedSeatCount>' . htmlspecialchars($requestedSeatCount, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                          <shareMarketInd>' . htmlspecialchars($airTravelerListShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                          <travelerReferenceID>' . htmlspecialchars($travelerReferenceID, ENT_XML1, 'UTF-8') . '</travelerReferenceID>
                          <unaccompaniedMinor>' . htmlspecialchars($unaccompaniedMinor, ENT_XML1, 'UTF-8') . '</unaccompaniedMinor>
                       </airTravelerList>
                       <ancillaryRequestList>
                          <airTravelerSequence>' . htmlspecialchars($airTravelerSequence, ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                          <flightSegmentSequence>' . htmlspecialchars($ancillaryRequestListFlightSegmentSequence, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                          <ssrCode>' . htmlspecialchars($ssrCode, ENT_XML1, 'UTF-8') . '</ssrCode>
                          <ssrGroup>' . htmlspecialchars($ssrGroup, ENT_XML1, 'UTF-8') . '</ssrGroup>
                          <ssrExplanation>' . htmlspecialchars($ssrExplanation, ENT_XML1, 'UTF-8') . '</ssrExplanation>
                       </ancillaryRequestList>
                       <bookingReferenceID>
                          <companyName>
                             <cityCode>' . htmlspecialchars($bookingReferenceCompanyCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                             <code>' . htmlspecialchars($bookingReferenceCompanyCode, ENT_XML1, 'UTF-8') . '</code>
                             <codeContext>' . htmlspecialchars($bookingReferenceCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                             <companyFullName>' . htmlspecialchars($bookingReferenceCompanyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                             <companyShortName>' . htmlspecialchars($bookingReferenceCompanyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                             <countryCode>' . htmlspecialchars($bookingReferenceCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                          </companyName>
                          <ID>' . htmlspecialchars($bookingReferenceIDID, ENT_XML1, 'UTF-8') . '</ID>
                          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                       </bookingReferenceID>
                    </AddSsrRequest>
              </impl:AddSsr>
           </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
  
  
   }

   public function flightNotes($flightNotes) {
      $xml = '';
      foreach ($flightNotes as $string) {
         $xml .= '<flightNotes>
                        <deiCode>' . htmlspecialchars($string['deiCode'], ENT_XML1, 'UTF-8') . '</deiCode>
                        <explanation>' . htmlspecialchars($string['explanation'], ENT_XML1, 'UTF-8') . ' Flight Info</explanation>
                        <note>' . htmlspecialchars($string['note'], ENT_XML1, 'UTF-8') . '</note>
                  </flightNotes>';
      }
      return $xml;

   }
  
    
  
}