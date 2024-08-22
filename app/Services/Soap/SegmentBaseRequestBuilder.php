<?php

namespace App\Services\Soap;

class SegmentBaseRequestBuilder {
   public function segmentBaseAvailableSpecialServices(
      $bookingClassCabin,
      $bookingResBookDesigCode,
      $bookingClassResBookDesigQuantity,
      $bookingClassResBookDesigStatusCode,
      $fareInfoCabin,
      $fareInfoCabinClassCode,
      $fareBaggageAllowanceType,
      $fareBaggageMaxAllowedPieces,
      $unitOfMeasureCode,
      $weight,
      $fareGroupName,
      $fareReferenceCode,
      $fareReferenceID,
      $fareReferenceName,
      $flightSegmentSequence,
      $portTax,
      $resBookDesigCode,
      $airlineCode,
      $airlineCompanyFullName,
      $arrivalCityLocationCode,
      $arrivalCityLocationName,
      $arrivalCityLocationNameLanguage,
      $arrivalCountryLocationCode,
      $arrivalCountryLocationName,
      $arrivalCountryLocationNameLanguage,
      $arrivalCountryCurrencyCode,
      $arrivalCodeContext,
      $arrivalLanguage,
      $arrivalLocationCode,
      $arrivalLocationName,
      $arrivalTimeZoneInfo,
      $arrivalDateTime,
      $arrivalDateTimeUTC,
      $departureCityLocationCode,
      $departureCityLocationName,
      $departureCityLocationNameLanguage,
      $departureCountryLocationCode,
      $departureCountryLocationName,
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
      $sector,
      $codeShare,
      $distance,
      $airEquipType,
      $changeOfGauge,
      $flightNotesDeiCodeOne,
      $flightNotesExplanationOne,
      $flightNotesNoteOne,
      $flightNotesDeiCodeTwo,
      $flightNotesExplanationTwo,
      $flightNotesNoteTwo,
      $flightNotesDeiCodeThree,
      $flightNotesExplanationThree,
      $flightNotesNoteThree,
      $flownMileageQty,
      $iatciFlight,
      $journeyDuration,
      $onTimeRate,
      $remark,
      $secureFlightDataRequired,
      $stopQuantity,
      $ticketType
   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
      soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
         <soapenv:Header/>
            <soapenv:Body>
               <impl:SegmentBaseAvailableSpecialServices>
                  <!-- Optional: -->
                  <SegmentBaseAvailableSpecialServicesRequest>
                     <!-- Optional: -->
                     <clientInformation>
                        <clientIP>129.0.0.1</clientIP>
                        <member>false</member>
                        <password>SCINTILLA</password>
                        <userName>SCINTILLA</userName>
                        <preferredCurrency>NGN</preferredCurrency>
                     </clientInformation>
                     <!-- Zero or more repetitions: -->
                     <bookFlightSegmentList>
                        <addOnSegment/>
                        <bookingClass>
                           <cabin>' . htmlspecialchars($bookingClassCabin, ENT_XML1, 'UTF-8') . '</cabin>
                           <resBookDesigCode>' . htmlspecialchars($bookingResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                           <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                           <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCode, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                        </bookingClass>
                        <!-- Optional: -->
                        <fareInfo>
                           <cabin>' . htmlspecialchars($fareInfoCabin, ENT_XML1, 'UTF-8') . '</cabin>
                           <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                           <fareBaggageAllowance>
                              <allowanceType>' . htmlspecialchars($fareBaggageAllowanceType, ENT_XML1, 'UTF-8') . '</allowanceType>
                              <maxAllowedPieces>' . htmlspecialchars($fareBaggageMaxAllowedPieces, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
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
                           <portTax>' . htmlspecialchars($portTax, ENT_XML1, 'UTF-8') . '</portTax>
                           <resBookDesigCode>' . htmlspecialchars($resBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        </fareInfo>
                        <!-- Optional: -->
                        <flightSegment>
                           <airline>
                              <code>' . htmlspecialchars($airlineCode, ENT_XML1, 'UTF-8') . '</code>
                              <companyFullName>' . htmlspecialchars($airlineCompanyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                           </airline>
                           <arrivalAirport>
                              <cityInfo>
                                 <city>
                                    <locationCode>' . htmlspecialchars($arrivalCityLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalCityLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($arrivalCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($arrivalCountryLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($arrivalCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>' . htmlspecialchars($arrivalCountryCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                 </country>
                              </cityInfo>
                              <codeContext>' . htmlspecialchars($arrivalCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                              <language>' . htmlspecialchars($arrivalLanguage, ENT_XML1, 'UTF-8') . '</language>
                              <locationCode>' . htmlspecialchars($arrivalLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($arrivalLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                              <timeZoneInfo>' . htmlspecialchars($arrivalTimeZoneInfo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                           </arrivalAirport>
                           <arrivalDateTime>' . htmlspecialchars($arrivalDateTime, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                           <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTC, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                           <departureAirport>
                              <cityInfo>
                                 <city>
                                    <locationCode>' . htmlspecialchars($departureCityLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureCityLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($departureCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($departureCountryLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($departureCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>NG' . htmlspecialchars($departureCountryCurrencyCode, ENT_XML1, 'UTF-8') . 'N</code>
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
                           <sector>' . htmlspecialchars($sector, ENT_XML1, 'UTF-8') . '</sector>
                           <codeshare>' . htmlspecialchars($codeShare, ENT_XML1, 'UTF-8') . '</codeshare>
                           <distance>' . htmlspecialchars($distance, ENT_XML1, 'UTF-8') . '</distance>
                           <equipment>
                              <airEquipType>' . htmlspecialchars($airEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                              <changeofGauge>' . htmlspecialchars($changeOfGauge, ENT_XML1, 'UTF-8') . '</changeofGauge>
                           </equipment>
                           <flightNotes>
                              <deiCode>' . htmlspecialchars($flightNotesDeiCodeOne, ENT_XML1, 'UTF-8') . '</deiCode>
                              <explanation>' . htmlspecialchars($flightNotesExplanationOne, ENT_XML1, 'UTF-8') . '</explanation>
                              <note>' . htmlspecialchars($flightNotesNoteOne, ENT_XML1, 'UTF-8') . '</note>
                           </flightNotes>
                           <flightNotes>
                              <deiCode>' . htmlspecialchars($flightNotesDeiCodeTwo, ENT_XML1, 'UTF-8') . '</deiCode>
                              <explanation>' . htmlspecialchars($flightNotesExplanationTwo, ENT_XML1, 'UTF-8') . '</explanation>
                              <note>' . htmlspecialchars($flightNotesNoteTwo, ENT_XML1, 'UTF-8') . '</note>
                           </flightNotes>
                           <flightNotes>
                              <deiCode>' . htmlspecialchars($flightNotesDeiCodeThree, ENT_XML1, 'UTF-8') . '</deiCode>
                              <explanation>' . htmlspecialchars($flightNotesExplanationThree, ENT_XML1, 'UTF-8') . '</explanation>
                              <note>' . htmlspecialchars($flightNotesNoteThree, ENT_XML1, 'UTF-8') . '</note>
                           </flightNotes>
                           <flownMileageQty>' . htmlspecialchars($flownMileageQty, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                           <iatciFlight>' . htmlspecialchars($iatciFlight, ENT_XML1, 'UTF-8') . '</iatciFlight>
                           <journeyDuration>' . htmlspecialchars($journeyDuration, ENT_XML1, 'UTF-8') . '</journeyDuration>
                           <onTimeRate>' . htmlspecialchars($onTimeRate, ENT_XML1, 'UTF-8') . '</onTimeRate>
                           <remark>' . htmlspecialchars($remark, ENT_XML1, 'UTF-8') . '</remark>
                           <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequired, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                           <stopQuantity>' . htmlspecialchars($stopQuantity, ENT_XML1, 'UTF-8') . '</stopQuantity>
                           <ticketType>' . htmlspecialchars($ticketType, ENT_XML1, 'UTF-8') . '</ticketType>
                        </flightSegment>
                        <involuntaryPermissionGiven/>
                        <sequenceNumber/>
                     </bookFlightSegmentList>
                     <frequentFlyerRedemption/>
                  </SegmentBaseAvailableSpecialServicesRequest>
               </impl:SegmentBaseAvailableSpecialServices>
            </soapenv:Body>
         </soapenv:Envelope>
      ';
      return $xml;
   }
}