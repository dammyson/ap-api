<?php

namespace App\Services\Soap;

class GetAirExtraChargesAndProductBuilder {
    
   public function getAirExtraChargesAndProductsRT(
        $bookingClassCabinOne, 
        $bookingClassResBookDesigCodeOne, 
        $bookingClassResBookDesigQuantityOne, 
        $bookingClassResBookDesigStatusCodeOne,
        $fareInfoCabinOne, 
        $fareInfoCabinClassCodeOne, 
        $fareBaggageAllowanceTypeOne, 
        $fareBaggageMaxAllowedPiecesOne, 
        $unitOfMeasureCodeOne, 
        $weightOne,
        $fareGroupNameOne, 
        $fareReferenceCodeOne, 
        $fareReferenceIDOne, 
        $fareReferenceNameOne, 
        $flightSegmentSequenceOne,
        $portTaxOne, 
        $fareInfoResBookDesigCodeOne,
        $airlineCodeOne, 
        $companyFullNameOne, 
        $arrivalAirportCityLocationCodeOne, 
        $arrivalAirportCityLocationNameOne, 
        $arrivalAirportCityLocationNameLanguageOne, 
        $arrivalAirportCountryLocationCodeOne,
        $arrivalAirportCountryLocationNameOne, 
        $arrivalAirportCountryLocationNameLangaugeOne, 
        $arrivalAirportCountryCurrencyCodeOne, 
        $arrivalAirportCodeContextOne, 
        $arrivalAirportLanguageOne,
        $arrivalAirportLocationCodeOne, 
        $arrivalAirportLocationNameOne, 
        $arrivalAirportTimeZoneInfoOne, 
        $arrivalDateTimeOne, 
        $arrivalDateTimeUTCOne,
        $departureAirportCityLocationCodeOne, 
        $departureAirportCityLocationNameOne, 
        $departureAirportCityLocationNameLanguageOne, 
        $departureAirportCountryLocationCodeOne, 
        $departureAirportCountryLocationNameOne, 
        $departureAirportCountryLocationNameLanguageOne,
        $departureAirportCountryCurrencyCodeOne, 
        $departureAirportCodeContextOne, 
        $departureAirportLanguageOne, 
        $departureAirportLocationCodeOne, 
        $departureAirportLocationNameOne, 
        $departureAirportTimeZoneInfoOne, 
        $departureDateTimeOne, 
        $departureDateTimeUTCOne, 
        $flightNumberOne, 
        $flightSegmentIDOne,
        $ondControlledOne, 
        $sectorOne, 
        $codeShareOne, 
        $distanceOne, 
        $airEquipTypeOne, 
        $changeOfGaugeOne, 
        $flightNotesDeiCodeOne, 
        $flightNoteExplanationOne, 
        $flightNotesNoteOne,
        $flightNotesDeiCodeTwo, 
        $flightExplanationTwo, 
        $flightNotesNoteTwo, 
        $flightNoteDeiCodeThree, 
        $flightNotesExplanationThree, 
        $flightNotesNoteThree,
        $flownMileageQtyOne, 
        $iatciFlightOne, 
        $journeyDurationOne, 
        $onTimeRateOne, 
        $remarkOne, 
        $secureFlightDataRequiredOne, 
        $stopQuantityOne, 
        $ticketTypeOne,
        $bookingClassCabinTwo,
        $bookingClassResBookDesigCodeTwo,
        $bookingClassResBookDesigQuantityTwo, 
        $bookingClassResBookDesigStatusCodeTwo,
        $fareInfoCabinTwo, 
        $fareInfoCabinClassCodeTwo, 
        $fareBaggageAllowedTypeTwo, 
        $fareBaggageMaxAllowedPiecesTwo, 
        $unitOfMeasureCodeTwo, 
        $weightTwo,
        $fareGroupNameTwo, 
        $fareReferenceCodeTwo, 
        $fareReferenceIDTwo, 
        $fareReferenceNameTwo, 
        $flightSegmentSequenceTwo,
        $portTaxTwo, 
        $fareInfoResBookDesigCodeTwo,
        $airlineCodeTwo, 
        $companyFullNameTwo, 
        $arrivalAirportCityLocationCodeTwo, 
        $arrivalAirportCityLocationNameTwo, 
        $arrivalAirportCityLocationNameLanguageTwo, 
        $arrivalAirportCountryLocationCodeTwo,
        $arrivalAirportCountryLocationNameTwo, 
        $arrivalAirportCountryLocationNameLangaugeTwo, 
        $arrivalAirportCountryCurrencyCodeTwo, 
        $arrivalAirportCodeContextTwo, 
        $arrivalAirportLanguageTwo,
        $arrivalAirportLocationCodeTwo, 
        $arrivalAirportLocationNameTwo, 
        $arrivalAirportTimeZoneInfoTwo, 
        $arrivalDateTimeTwo, 
        $arrivalDateTimeUTCTwo,
        $departureAirportCityLocationCodeTwo, 
        $departureAirportCityLocationNameTwo, 
        $departureAirportCityLocationNameLanguageTwo, 
        $departureAirportCountryLocationCodeTwo, 
        $departureAirportCountryLocationNameTwo, 
        $departureAirportCountryLocationNameLanguageTwo,
        $departureAirportCountryCurrencyCodeTwo, 
        $departureAirportCodeContextTwo, 
        $departureAirportLanguageTwo, 
        $departureAirportLocationCodeTwo, 
        $departureAirportLocationNameTwo, 
        $departureAirportTimeZoneInfoTwo, 
        $departureDateTimeTwo, 
        $departureDateTimeUTCTwo,
        $flightNumberTwo, 
        $flightSegmentIDTwo,
        $ondControlledTwo, 
        $sectorTwo, 
        $codeShareTwo, 
        $distanceTwo, 
        $airEquipTypeTwo, 
        $changeOfGaugeTwo, 
        $flightNotesDeiCodeFour, 
        $flightNotesExplanationFour, 
        $flightNotesNoteFour,
        $flightNotesDeiCodeFive, 
        $flightNotesExplanationFive, 
        $flightNotesNoteFive, 
        $flightNotesDeiCodeSix, 
        $flightNotesExplanationSix, 
        $flightNotesNoteSix,
        $flownMileageQtyTwo, 
        $iatciFlightTwo, 
        $journeyDurationTwo, 
        $onTimeRateTwo, 
        $remarkTwo, 
        $secureFlightDataRequiredTwo, 
        $stopQuantityTwo, 
        $ticketTypeTwo,
        $journeyStartLocationCode,
        $passengerTypeCode, 
        $quantity, 
        $tripType
     
    ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>  
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
         <soapenv:Header/>
         <soapenv:Body>
            <impl:GetAirExtraChargesAndProducts>
               <AirExtraChargesAndProductsRequest>
                  <clientInformation>
                     <clientIP>129.0.0.1</clientIP>
                     <member>false</member>
                     <password>SCINTILLA</password>
                     <userName>SCINTILLA</userName>
                     <preferredCurrency>NGN</preferredCurrency>
                  </clientInformation>
                  <bookFlightSegmentList>
                     <addOnSegment/>
                     <bookingClass>
                        <cabin>' . htmlspecialchars($bookingClassCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                        <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityOne, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                        <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                     </bookingClass>
                     <fareInfo>
                     <cabin>' . htmlspecialchars($fareInfoCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                     <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeOne, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                     <fareBaggageAllowance>
                        <allowanceType>' . htmlspecialchars($fareBaggageAllowanceTypeOne, ENT_XML1, 'UTF-8') . '</allowanceType>
                        <maxAllowedPieces>' . htmlspecialchars($fareBaggageMaxAllowedPiecesOne, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                        <maxAllowedWeight>
                           <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeOne, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                           <weight>' . htmlspecialchars($weightOne, ENT_XML1, 'UTF-8') . '</weight>
                        </maxAllowedWeight>
                     </fareBaggageAllowance>
                     <fareGroupName>' . htmlspecialchars($fareGroupNameOne, ENT_XML1, 'UTF-8') . '</fareGroupName>
                     <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeOne, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                     <fareReferenceID>' . htmlspecialchars($fareReferenceIDOne, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                     <fareReferenceName>' . htmlspecialchars($fareReferenceNameOne, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                     <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                     <portTax>' . htmlspecialchars($portTaxOne, ENT_XML1, 'UTF-8') . '</portTax>
                     <resBookDesigCode>' . htmlspecialchars($fareInfoResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                     </fareInfo>
                     <flightSegment>
                     <airline>
                     <code>' . htmlspecialchars($airlineCodeOne, ENT_XML1, 'UTF-8') . '</code>
                     <companyFullName>' . htmlspecialchars($companyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                     </airline>
                     <arrivalAirport>
                        <cityInfo>
                           <city>
                              <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                           </city>
                           <country>
                              <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLangaugeOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              <currency>
                                 <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                              </currency>
                           </country>
                        </cityInfo>
                        <codeContext>' . htmlspecialchars($arrivalAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                        <language>' . htmlspecialchars($arrivalAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                        <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($arrivalAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                        <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </arrivalAirport>
                     <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeOne, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                     <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                     <departureAirport>
                        <cityInfo>
                           <city>
                              <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($departureAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                           </city>
                           <country>
                              <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($departureAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              <currency>
                                 <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                              </currency>
                           </country>
                        </cityInfo>
                        <codeContext>' . htmlspecialchars($departureAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                        <language>' . htmlspecialchars($departureAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                        <locationCode>' . htmlspecialchars($departureAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($departureAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                        <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </departureAirport>
                     <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                     <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                     <flightNumber>' . htmlspecialchars($flightNumberOne, ENT_XML1, 'UTF-8') . '</flightNumber>
                     <flightSegmentID>' . htmlspecialchars($flightSegmentIDOne, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                     <ondControlled>' . htmlspecialchars($ondControlledOne, ENT_XML1, 'UTF-8') . '</ondControlled>
                     <sector>' . htmlspecialchars($sectorOne, ENT_XML1, 'UTF-8') . '</sector>
                     <accumulatedDuration/>
                     <codeshare>' . htmlspecialchars($codeShareOne, ENT_XML1, 'UTF-8') . '</codeshare>
                     <distance>' . htmlspecialchars($distanceOne, ENT_XML1, 'UTF-8') . '</distance>
                     <equipment>
                        <airEquipType>' . htmlspecialchars($airEquipTypeOne, ENT_XML1, 'UTF-8') . '</airEquipType>
                        <changeofGauge>' . htmlspecialchars($changeOfGaugeOne, ENT_XML1, 'UTF-8') . '</changeofGauge>
                     </equipment>
                     <flightNotes>
                        <deiCode>' . htmlspecialchars($flightNotesDeiCodeOne, ENT_XML1, 'UTF-8') . '</deiCode>
                        <explanation>' . htmlspecialchars($flightNoteExplanationOne, ENT_XML1, 'UTF-8') . '</explanation>
                        <note>' . htmlspecialchars($flightNotesNoteOne, ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flightNotes>
                        <deiCode>' . htmlspecialchars($flightNotesDeiCodeTwo, ENT_XML1, 'UTF-8') . '</deiCode>
                        <explanation>' . htmlspecialchars($flightExplanationTwo, ENT_XML1, 'UTF-8') . '</explanation>
                        <note>' . htmlspecialchars($flightNotesNoteTwo, ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flightNotes>
                        <deiCode>' . htmlspecialchars($flightNoteDeiCodeThree, ENT_XML1, 'UTF-8') . '</deiCode>
                        <explanation>' . htmlspecialchars($flightNotesExplanationThree, ENT_XML1, 'UTF-8') . '</explanation>
                        <note>' . htmlspecialchars($flightNotesNoteThree, ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flownMileageQty>' . htmlspecialchars($flownMileageQtyOne, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                     <groundDuration/>
                     <iatciFlight>' . htmlspecialchars($iatciFlightOne, ENT_XML1, 'UTF-8') . '</iatciFlight>
                     <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                     <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                     <remark>' . htmlspecialchars($remarkOne, ENT_XML1, 'UTF-8') . '</remark>
                     <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredOne, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                     <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                     <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                     <trafficRestriction>
                        <code/>
                        <explanation/>
                     </trafficRestriction>
                     </flightSegment>
                     <involuntaryPermissionGiven/>
                     <sequenceNumber/>
                  </bookFlightSegmentList>
                  <bookFlightSegmentList>
                  <addOnSegment/>
                  <bookingClass>
                     <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                     <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                     <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                     <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                  </bookingClass>
                  <fareInfo>
                  <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                  <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                  <fareBaggageAllowance>
                     <allowanceType>' . htmlspecialchars($fareBaggageAllowedTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                     <maxAllowedPieces>' . htmlspecialchars($fareBaggageMaxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                     <maxAllowedWeight>
                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                        <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                     </maxAllowedWeight>
                  </fareBaggageAllowance>
                  <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                  <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                  <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                  <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                  <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                  <portTax>' . htmlspecialchars($portTaxTwo, ENT_XML1, 'UTF-8') . '</portTax>
                  <resBookDesigCode>' . htmlspecialchars($fareInfoResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                  </fareInfo>
                  <flightSegment>
                  <airline>
                     <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                     <companyFullName>' . htmlspecialchars($companyFullNameTwo, ENT_XML1, 'UTF-8') . '</companyFullName>
                  </airline>
                  <arrivalAirport>
                     <cityInfo>
                        <city>
                           <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                           <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                           <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                        </city>
                        <country>
                           <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                           <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                           <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLangaugeTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                           <currency>
                              <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                           </currency>
                        </country>
                     </cityInfo>
                     <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                     <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                     <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                     <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                     <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                  </arrivalAirport>
                  <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                  <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                  <departureAirport>
                     <cityInfo>
                     <city>
                        <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                        <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                     </city>
                     <country>
                        <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                        <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                        <currency>
                           <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                        </currency>
                     </country>
                     </cityInfo>
                     <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                     <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                     <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                     <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                     <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                  </departureAirport>
                  <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                  <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                  <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                  <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                  <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                  <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                  <accumulatedDuration/>
                  <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                  <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                  <equipment>
                     <airEquipType>' . htmlspecialchars($airEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                     <changeofGauge>' . htmlspecialchars($changeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                  </equipment>
                  <flightNotes>
                     <deiCode>' . htmlspecialchars($flightNotesDeiCodeFour, ENT_XML1, 'UTF-8') . '</deiCode>
                     <explanation>' . htmlspecialchars($flightNotesExplanationFour, ENT_XML1, 'UTF-8') . '</explanation>
                     <note>' . htmlspecialchars($flightNotesNoteFour, ENT_XML1, 'UTF-8') . '</note>
                  </flightNotes>
                  <flightNotes>
                     <deiCode>' . htmlspecialchars($flightNotesDeiCodeFive, ENT_XML1, 'UTF-8') . '</deiCode>
                     <explanation>' . htmlspecialchars($flightNotesExplanationFive, ENT_XML1, 'UTF-8') . '</explanation>
                     <note>' . htmlspecialchars($flightNotesNoteFive, ENT_XML1, 'UTF-8') . '</note>
                  </flightNotes>
                  <flightNotes>
                     <deiCode>' . htmlspecialchars($flightNotesDeiCodeSix, ENT_XML1, 'UTF-8') . '</deiCode>
                     <explanation>' . htmlspecialchars($flightNotesExplanationSix, ENT_XML1, 'UTF-8') . '</explanation>
                     <note>' . htmlspecialchars($flightNotesNoteSix, ENT_XML1, 'UTF-8') . '</note>
                  </flightNotes>
                  <flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                  <groundDuration/>
                  <iatciFlight>' . htmlspecialchars($iatciFlightTwo , ENT_XML1, 'UTF-8') . '</iatciFlight>
                  <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                  <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                  <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                  <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                  <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                  <ticketType>' . htmlspecialchars($ticketTypeTwo, ENT_XML1, 'UTF-8') . '</ticketType>
                  <trafficRestriction>
                  <code/>
                  <explanation/>
                  </trafficRestriction>
                  </flightSegment>
                  <involuntaryPermissionGiven/>
                  <sequenceNumber/>
                  </bookFlightSegmentList>
                  <frequentFlyerRedemption/>
                  <journeyStartLocation>
                  <locationCode>' . htmlspecialchars($journeyStartLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                  </journeyStartLocation>
                  <travelerInformation>
                     <passengerTypeQuantityList>
                     <hasStrecher/>
                     <passengerType>
                     <code>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                     </passengerType>
                     <quantity>' . htmlspecialchars($quantity, ENT_XML1, 'UTF-8') . '</quantity>
                     </passengerTypeQuantityList>
                  </travelerInformation>
                  <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
               </AirExtraChargesAndProductsRequest>
            </impl:GetAirExtraChargesAndProducts>
         </soapenv:Body>
         </soapenv:Envelope>';
        return $xml;
    }



    public function getExtraChargesAndProductOW(
        $bookingClassCabin,
        $bookingClassResBookDesigCode,
        $bookingClassResBookDesigQuantity,
        $bookingClassResBookDesigStatusCode,
        $fareInfoCabin,
        $fareInfoCabinClassCode,
        $fareBaggageAllowanceType,
        $fareBaggageAllowanceMaxAllowedPieces,
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
        $companyFullName,
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
        $arrivalAirportTimeZoneInfo,
        $arrivalDateTime,
        $arrivalDateTimeUTC,
        $departureAirportCityLocationCode,
        $departureAirportCityLocationName,
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCode,
        $departureAirportCountryLocationName,
        $departureAirportCountryNameLanguage,
        $departureAirportCountryCurrencyCode,
        $departureAirportCodeContext,
        $departureAirportLanguage,
        $departureAirportLocationCode,
        $departureAirportLocationName,
        $departureAiportTimeZoneInfo,
        $departureDateTime,
        $departureDateTimeUTC,
        $flightNumber,
        $flightSegmentID,
        $ondControlled,
        $sector,
        $codeShare,
        $distance,
        $airEquipType,
        $changeOfGuage,
        $flightNotesDeiCodeOne,
        $flightExplanationOne,
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
        $ticketType,
        $locationCode,
        $passengerTypeCode, 
        $quantity,
        $tripType
    ) {
        $xml =  '<?xml version="1.0" encoding="UTF-8"?> 
           <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
              <soapenv:Header/>
              <soapenv:Body>
                 <impl:GetAirExtraChargesAndProducts>
                 <AirExtraChargesAndProductsRequest>
                 <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                 </clientInformation>
                 <bookFlightSegmentList>
                    <addOnSegment/>
                    <bookingClass>
                       <cabin>' . htmlspecialchars($bookingClassCabin, ENT_XML1, 'UTF-8') . '</cabin>
                       <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                       <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                       <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCode, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                    </bookingClass>
                    <fareInfo>
                       <cabin>' . htmlspecialchars($fareInfoCabin, ENT_XML1, 'UTF-8') . '</cabin>
                       <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                       <fareBaggageAllowance>
                          <allowanceType>' . htmlspecialchars($fareBaggageAllowanceType, ENT_XML1, 'UTF-8') . '</allowanceType>
                          <maxAllowedPieces>' . htmlspecialchars($fareBaggageAllowanceMaxAllowedPieces, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
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
                    <flightSegment>
                       <airline>
                          <code>' . htmlspecialchars($airlineCode, ENT_XML1, 'UTF-8') . '</code>
                          <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
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
                          <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                       </arrivalAirport>
                       <arrivalDateTime>' . htmlspecialchars($arrivalDateTime, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                       <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTC, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
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
                                <locationNameLanguage>' . htmlspecialchars($departureAirportCountryNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                <currency>
                                   <code>' . htmlspecialchars($departureAirportCountryCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                                </currency>
                             </country>
                          </cityInfo>
                          <codeContext>' . htmlspecialchars($departureAirportCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                          <language>' . htmlspecialchars($departureAirportLanguage, ENT_XML1, 'UTF-8') . '</language>
                          <locationCode>' . htmlspecialchars($departureAirportLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          <locationName>' . htmlspecialchars($departureAirportLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                          <timeZoneInfo>' . htmlspecialchars($departureAiportTimeZoneInfo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                       </departureAirport>
                       <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                       <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTC, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                       <flightNumber>' . htmlspecialchars($flightNumber, ENT_XML1, 'UTF-8') . '</flightNumber>
                       <flightSegmentID>' . htmlspecialchars($flightSegmentID, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                       <ondControlled>' . htmlspecialchars($ondControlled, ENT_XML1, 'UTF-8') . '</ondControlled>
                       <sector>' . htmlspecialchars($sector, ENT_XML1, 'UTF-8') . '</sector>
                       <accumulatedDuration/>
                       <codeshare>' . htmlspecialchars($codeShare, ENT_XML1, 'UTF-8') . '</codeshare>
                       <distance>' . htmlspecialchars($distance, ENT_XML1, 'UTF-8') . '</distance>
                       <equipment>
                          <airEquipType>' . htmlspecialchars($airEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                          <changeofGauge>' . htmlspecialchars($changeOfGuage, ENT_XML1, 'UTF-8') . '</changeofGauge>
                       </equipment>
                       <flightNotes>
                          <deiCode>' . htmlspecialchars($flightNotesDeiCodeOne, ENT_XML1, 'UTF-8') . '</deiCode>
                          <explanation>' . htmlspecialchars($flightExplanationOne, ENT_XML1, 'UTF-8') . '</explanation>
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
                       <groundDuration/>
                       <iatciFlight>' . htmlspecialchars($iatciFlight, ENT_XML1, 'UTF-8') . '</iatciFlight>
                       <journeyDuration>' . htmlspecialchars($journeyDuration, ENT_XML1, 'UTF-8') . '</journeyDuration>
                       <onTimeRate>' . htmlspecialchars($onTimeRate, ENT_XML1, 'UTF-8') . '</onTimeRate>
                       <remark>' . htmlspecialchars($remark, ENT_XML1, 'UTF-8') . '</remark>
                       <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequired, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                       <stopQuantity>' . htmlspecialchars($stopQuantity, ENT_XML1, 'UTF-8') . '</stopQuantity>
                       <ticketType>' . htmlspecialchars($ticketType, ENT_XML1, 'UTF-8') . '</ticketType>
                       <trafficRestriction>
                          <code/>
                          <explanation/>
                       </trafficRestriction>
                    </flightSegment>
                    <involuntaryPermissionGiven/>
                    <sequenceNumber/>
                 </bookFlightSegmentList>
                 <journeyStartLocation>
                 <locationCode>' . htmlspecialchars($locationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                 </journeyStartLocation>
                 <frequentFlyerRedemption/>
                 <travelerInformation>
                 <passengerTypeQuantityList>
                 <hasStrecher/>
                 <passengerType>
                 <code>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                 </passengerType>
                 <quantity>' . htmlspecialchars($quantity, ENT_XML1, 'UTF-8') . '</quantity>
                 </passengerTypeQuantityList>
                 </travelerInformation>
                 <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                 </AirExtraChargesAndProductsRequest>
           </impl:GetAirExtraChargesAndProducts>
           </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }

   public function getAirExtraChargesAndProductMD (
      $bookingClassCabinOne,
      $bookingClassResBookDesigCodeOne,
      $bookingClassResBookDesigQuantityOne, 
      $bookingClassResBookDesigStatusCodeOne,
      $fareInfoCabinOne, 
      $fareInfoCabonClassCodeOne,
      $fareBaggageAllowanceTypeOne, 
      $fareBaggageAllowanceMaxAllowedPiecesOne,
      $unitOfMeasureCodeOne, 
      $weightOne, 
      $fareGroupNameOne, 
      $fareReferenceCodeOne, 
      $fareReferenceIDOne, 
      $fareReferenceNameOne,
      $flightSegmentSequenceOne, 
      $portTaxOne, 
      $resBookDesigCodeOne, 
      $airlineCodeOne, 
      $companyFullNameOne, 
      $arrivalAirportCityLocationCodeOne,
      $arrivalAirportCityLocationNameOne, 
      $arrivalAirportCityLocationNameLanguageOne, 
      $arrivalAirportCountryLocationCodeOne,
      $arrivalAirportCountryLocationNameOne, 
      $arrivalAirportCountryLocationNameLanguageOne, 
      $arrivalAirportCountryCurrencyCodeOne,
      $arrivalAirportCodeContextOne, 
      $arrivalAirportLanguageOne, 
      $arrivalAirportLocationCodeOne, 
      $arrivalAirportLocationNameOne, 
      $arrivalAirportTimeZoneInfoOne,
      $arrivalDateTimeOne, 
      $arrivalDateTimeUTCOne, 
      $departureAirportCityLocationCodeOne, 
      $departureAirportCityLocationNameOne,
      $departureAirportCityLocationNameLanguageOne, 
      $departureAirportCountryLocationCodeOne, 
      $departureAirportCountryLocationNameOne,
      $departureAirportCountryLocationNameLanguageOne, 
      $departureAirportCountryCurrencyCodeOne, 
      $departureAirportCodeContextOne,
      $departureAirportLanguageOne, 
      $departureAirportLocationCodeOne, 
      $departureAirportLocationNameOne, 
      $departureAirportTimeZoneInfoOne,
      $departureDateTimeOne, 
      $departureDateTimeUTCOne, 
      $flightNumberOne, 
      $flightSegmentIDOne, 
      $ondControlledOne, 
      $sectorOne, 
      $codeShareOne,
      $distanceOne, 
      $equipmentAirEquipTypeOne, 
      $equipmentChangeOfGaugeOne, 
      $flightNotesDeiCodeOne, 
      $flightNotesExplanationOne,
      $flightNotesNoteOne, 
      $flightNotesDeiCodeTwo, 
      $flightNotesExplanationTwo, 
      $flightNotesNoteTwo,
      $flightNotesDeiCodeThree, 
      $flightNotesExplanationThree, 
      $flightNotesNoteThree, 
      $flownMileageQtyOne, 
      $iatciFlightOne,
      $journeyDurationOne, 
      $onTimeRateOne, 
      $remarkOne, 
      $secureFlightDataRequiredOne, 
      $stopQuantityOne, 
      $ticketTypeOne,          
      $bookingClassCabinTwo,
      $bookingClassResBookDesigCodeTwo,
      $bookingClassResBookDesigQuantityTwo, 
      $bookingClassResBookDesigStatusCodeTwo,
      $fareInfoCabinTwo, 
      $fareInfoCabonClassCodeTwo,
      $fareBaggageAllowanceTypeTwo, 
      $fareBaggageAllowanceMaxAllowedPiecesTwo,
      $unitOfMeasureCodeTwo, 
      $weightTwo, 
      $fareGroupNameTwo, 
      $fareReferenceCodeTwo, 
      $fareReferenceIDTwo, 
      $fareReferenceNameTwo,
      $flightSegmentSequenceTwo, 
      $portTaxTwo, 
      $resBookDesigCodeTwo,
      $airlineCodeTwo, 
      $companyFullNameTwo, 
      $arrivalAirportCityLocationCodeTwo,
      $arrivalAirportCityLocationNameTwo, 
      $arrivalAirportCityLocationNameLanguageTwo, 
      $arrivalAirportCountryLocationCodeTwo,
      $arrivalAirportCountryLocationNameTwo, 
      $arrivalAirportCountryLocationNameLanguageTwo, 
      $arrivalAirportCountryCurrencyCodeTwo,
      $arrivalAirportCodeContextTwo, 
      $arrivalAirportLanguageTwo, 
      $arrivalAirportLocationCodeTwo, 
      $arrivalAirportLocationNameTwo, 
      $arrivalAirportTimeZoneInfoTwo,
      $arrivalDateTimeTwo, 
      $arrivalDateTimeUTCTwo, 
      $departureAirportCityLocationCodeTwo, 
      $departureAirportCityLocationNameTwo,
      $departureAirportCityLocationNameLanguageTwo, 
      $departureAirportCountryLocationCodeTwo, 
      $departureAirportCountryLocationNameTwo,
      $departureAirportCountryLocationNameLanguageTwo, 
      $departureAirportCountryCurrencyCodeTwo, 
      $departureAirportCodeContextTwo,
      $departureAirportLanguageTwo, 
      $departureAirportLocationCodeTwo, 
      $departureAirportLocationNameTwo, 
      $departureAirportTimeZoneInfoTwo,
      $departureDateTimeTwo, 
      $departureDateTimeUTCTwo,
      $flightNumberTwo, 
      $flightSegmentIDTwo, 
      $ondControlledTwo, 
      $sectorTwo, 
      $codeShareTwo,
      $distanceTwo, 
      $equipmentAirEquipTypeTwo, 
      $equipmentChangeOfGaugeTwo, 
      $flightNotesDeiCodeFour, 
      $flightNotesExplanationFour,
      $flightNotesNoteFour, 
      $flightNotesDeiCodeFive, 
      $flightNotesExplanationFive, 
      $flightNotesNoteFive,
      $flightNotesDeiCodeSix, 
      $flightNotesExplanationSix, 
      $flightNotesNoteSix, 
      $flownMileageQtyTwo, 
      $iatciFlightTwo,
      $journeyDurationTwo, 
      $onTimeRateTwo, 
      $remarkTwo, 
      $secureFlightDataRequiredTwo, 
      $stopQuantityTwo, 
      $ticketTypeTwo,
      $locationCode,
      $passengerTypeCode,
      $passengerTypeQuantity,
      $tripType 

    ) {

        $xml = '<?xml version="1.0" encoding="UTF-8"?> 
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
              <soapenv:Body>
              <impl:GetAirExtraChargesAndProducts>
              <AirExtraChargesAndProductsRequest>
              <clientInformation>
              <clientIP>129.0.0.1</clientIP>
              <member>false</member>
              <password>SCINTILLA</password>
              <userName>SCINTILLA</userName>
              <preferredCurrency>NGN</preferredCurrency>One
              </clientInformation>
              <bookFlightSegmentList>
                 <addOnSegment/>
                 <bookingClass>
                    <cabin>' . htmlspecialchars($bookingClassCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                    <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                    <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityOne, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                    <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                 </bookingClass>One
                 <fareInfo>
                    <cabin>' . htmlspecialchars($fareInfoCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                    <cabinClassCode>' . htmlspecialchars($fareInfoCabonClassCodeOne, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                    <fareBaggageAllowance>
                       <allowanceType>' . htmlspecialchars($fareBaggageAllowanceTypeOne, ENT_XML1, 'UTF-8') . '</allowanceType>
                       <maxAllowedPieces>' . htmlspecialchars($fareBaggageAllowanceMaxAllowedPiecesOne, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                       <maxAllowedWeight>
                          <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeOne, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                          <weight>' . htmlspecialchars($weightOne, ENT_XML1, 'UTF-8') . '</weight>
                       </maxAllowedWeight>
                    </fareBaggageAllowance>
                    <fareGroupName>' . htmlspecialchars($fareGroupNameOne, ENT_XML1, 'UTF-8') . '</fareGroupName>
                    <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeOne, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                    <fareReferenceID>' . htmlspecialchars($fareReferenceIDOne, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                    <fareReferenceName>' . htmlspecialchars($fareReferenceNameOne, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                    <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                    <portTax>' . htmlspecialchars($portTaxOne, ENT_XML1, 'UTF-8') . '</portTax>
                    <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                 </fareInfo>
                 <flightSegment>
                    <airline>
                       <code>' . htmlspecialchars($airlineCodeOne, ENT_XML1, 'UTF-8') . '</code>
                       <companyFullName>' . htmlspecialchars($companyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                    </airline>
                    <arrivalAirport>
                       <cityInfo>
                          <city>
                             <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                             <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                             <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                          </city>
                          <country>
                             <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                             <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                             <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             <currency>
                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                             </currency>
                          </country>
                       </cityInfo>
                       <codeContext>' . htmlspecialchars($arrivalAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                       <language>' . htmlspecialchars($arrivalAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                       <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                       <locationName>' . htmlspecialchars($arrivalAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                       <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                    </arrivalAirport>
                    <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeOne, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                    <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                    <departureAirport>
                       <cityInfo>
                          <city>
                             <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                             <locationName>' . htmlspecialchars($departureAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                             <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                          </city>
                          <country>
                             <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                             <locationName>' . htmlspecialchars($departureAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                             <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             <currency>
                                <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                             </currency>
                          </country>
                       </cityInfo>
                       <codeContext>' . htmlspecialchars($departureAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                       <language>' . htmlspecialchars($departureAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                       <locationCode>' . htmlspecialchars($departureAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                       <locationName>' . htmlspecialchars($departureAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                       <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                    </departureAirport>
                    <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                    <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                    <flightNumber>' . htmlspecialchars($flightNumberOne, ENT_XML1, 'UTF-8') . '</flightNumber>
                    <flightSegmentID>' . htmlspecialchars($flightSegmentIDOne, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                    <ondControlled>' . htmlspecialchars($ondControlledOne, ENT_XML1, 'UTF-8') . '</ondControlled>
                    <sector>' . htmlspecialchars($sectorOne, ENT_XML1, 'UTF-8') . '</sector>
                    <codeshare>' . htmlspecialchars($codeShareOne, ENT_XML1, 'UTF-8') . '</codeshare>
                    <distance>' . htmlspecialchars($distanceOne, ENT_XML1, 'UTF-8') . '</distance>
                    <equipment>
                       <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeOne, ENT_XML1, 'UTF-8') . '</airEquipType>
                       <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeOne, ENT_XML1, 'UTF-8') . '</changeofGauge>
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
                    <flownMileageQty>' . htmlspecialchars($flownMileageQtyOne, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                    <iatciFlight>' . htmlspecialchars($iatciFlightOne, ENT_XML1, 'UTF-8') . '</iatciFlight>
                    <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                    <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                    <remark>' . htmlspecialchars($remarkOne, ENT_XML1, 'UTF-8') . '</remark>
                    <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredOne, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                    <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                    <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                 </flightSegment>
                 <involuntaryPermissionGiven/>
                 <sequenceNumber/>
              </bookFlightSegmentList>
              <bookFlightSegmentList>
              <addOnSegment/>
              <bookingClass>
                 <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                 <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                 <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                 <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
              </bookingClass>
              <fareInfo>
                 <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                 <cabinClassCode>' . htmlspecialchars($fareInfoCabonClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                 <fareBaggageAllowance>
                    <allowanceType>' . htmlspecialchars($fareBaggageAllowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                    <maxAllowedPieces>' . htmlspecialchars($fareBaggageAllowanceMaxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                    <maxAllowedWeight>
                       <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                       <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                    </maxAllowedWeight>
                 </fareBaggageAllowance>
                 <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                 <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                 <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                 <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                 <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                 <portTax>' . htmlspecialchars($portTaxTwo, ENT_XML1, 'UTF-8') . '</portTax>
                 <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
              </fareInfo>
              <flightSegment>
                 <airline>
                    <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                    <companyFullName>' . htmlspecialchars($companyFullNameTwo, ENT_XML1, 'UTF-8') . '</companyFullName>
                 </airline>
                 <arrivalAirport>
                    <cityInfo>
                       <city>
                          <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                          <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                       </city>
                       <country>
                          <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                          <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                          <currency>
                             <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                          </currency>
                       </country>
                    </cityInfo>
                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                    <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                 </arrivalAirport>
                 <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                 <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                 <departureAirport>
                    <cityInfo>
                       <city>
                          <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                          <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                       </city>
                       <country>
                          <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                          <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                          <currency>
                             <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                          </currency>
                       </country>
                    </cityInfo>
                    <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                    <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                    <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                    <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                 </departureAirport>
                 <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                 <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                 <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                 <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                 <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                 <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                 <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                 <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                 <equipment>
                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                 </equipment>
                 <flightNotes>
                    <deiCode>' . htmlspecialchars($flightNotesDeiCodeFour, ENT_XML1, 'UTF-8') . '</deiCode>
                    <explanation>' . htmlspecialchars($flightNotesExplanationFour, ENT_XML1, 'UTF-8') . '</explanation>
                    <note>' . htmlspecialchars($flightNotesNoteFour, ENT_XML1, 'UTF-8') . '</note>
                 </flightNotes>
                 <flightNotes>
                    <deiCode>' . htmlspecialchars($flightNotesDeiCodeFive, ENT_XML1, 'UTF-8') . '</deiCode>
                    <explanation>' . htmlspecialchars($flightNotesExplanationFive, ENT_XML1, 'UTF-8') . '</explanation>
                    <note>' . htmlspecialchars($flightNotesNoteFive, ENT_XML1, 'UTF-8') . '</note>
                 </flightNotes>
                 <flightNotes>
                    <deiCode>' . htmlspecialchars($flightNotesDeiCodeSix, ENT_XML1, 'UTF-8') . '</deiCode>
                    <explanation>' . htmlspecialchars($flightNotesExplanationSix, ENT_XML1, 'UTF-8') . '</explanation>
                    <note>' . htmlspecialchars($flightNotesNoteSix, ENT_XML1, 'UTF-8') . '</note>
                 </flightNotes>
                 <flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                 <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                 <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                 <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                 <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                 <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                 <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                 <ticketType>' . htmlspecialchars($ticketTypeTwo, ENT_XML1, 'UTF-8') . '</ticketType>
              </flightSegment>
              <involuntaryPermissionGiven/>
              <sequenceNumber/>
              </bookFlightSegmentList>
              <frequentFlyerRedemption/>
              <journeyStartLocation>
                 <locationCode>' . htmlspecialchars($locationCode, ENT_XML1, 'UTF-8') . '</locationCode>
              </journeyStartLocation>
              <travelerInformation>
                 <passengerTypeQuantityList>
                 <hasStrecher/>
                 <passengerType>
                    <code>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                 </passengerType>
                 <quantity>' . htmlspecialchars($passengerTypeQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                 </passengerTypeQuantityList>
              </travelerInformation>
              <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
              </AirExtraChargesAndProductsRequest>
              </impl:GetAirExtraChargesAndProducts>
           </soapenv:Body>
        </soapenv:Envelope>';
        return $xml;
    }


    public function getExtraChargesAndProductTwoA(
        $bookingClassCabin, 
        $bookingClassResBookDesigCode, 
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
        $companyFullName, 
        $arrivalAirportCityLocationCode, 
        $arrivalAirportCityLocationName, 
        $arrivalAirportCityLocationNameLanguage,
        $arrivalAirportCountryLocationCode, 
        $arrivalAirportCountryLocationName, 
        $arrivalAirportCountryLocationNameLangauge, 
        $arrivalAirportCountryCurrencyCode,
        $arrivalAirportCodeContext, 
        $arrivalAirportLanguage, 
        $arrivalAirportLocationCode, 
        $arrivalAirportLocationName, 
        $arrivalAirportTimeZoneInfo,
        $arrivalDateTime, 
        $arrivalDateTimeUTC, 
        $departureAirportCitytLocationCode, 
        $departureAirportCityLocationName, 
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountrytLocationCode, 
        $departureAirportCountryLocationName, 
        $departureAirportCountryLocationNameLanguage, 
        $departureAirportCountyCurrencyCode,
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
        $changeOfGuage, 
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
        $ticketType,
        $locationCode, 
        $passengerTypeCode, 
        $quantity, 
        $passengerTypeCodeTwo, 
        $quantityTwo, 
        $passengerTypeCodeThree, 
        $quantityThree, 
        $tripType

    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?> 
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
           <soapenv:Body>
              <impl:GetAirExtraChargesAndProducts>
              <AirExtraChargesAndProductsRequest>
              <clientInformation>
                 <clientIP>129.0.0.1</clientIP>
                 <member>false</member>
                 <password>SCINTILLA</password>
                 <userName>SCINTILLA</userName>
                 <preferredCurrency>NGN</preferredCurrency>
              </clientInformation>
              <bookFlightSegmentList>
                 <addOnSegment/>
                 <bookingClass>
                    <cabin>' . htmlspecialchars($bookingClassCabin, ENT_XML1, 'UTF-8') . '</cabin>
                    <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                    <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                    <resBookDesigStatusCode>' . htmlspecialchars($bookingClassResBookDesigStatusCode   , ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                 </bookingClass>
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
                 <flightSegment>
                    <airline>
                       <code>' . htmlspecialchars($airlineCode, ENT_XML1, 'UTF-8') . '</code>
                       <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
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
                             <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLangauge, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             <currency>
                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                             </currency>
                          </country>
                       </cityInfo>
                       <codeContext>' . htmlspecialchars($arrivalAirportCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                       <language>' . htmlspecialchars($arrivalAirportLanguage, ENT_XML1, 'UTF-8') . '</language>
                       <locationCode>' . htmlspecialchars($arrivalAirportLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                       <locationName>' . htmlspecialchars($arrivalAirportLocationName, ENT_XML1, 'UTF-8') . '</locationName>
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
                             <locationCode>' . htmlspecialchars($departureAirportCountrytLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                             <locationName>' . htmlspecialchars($departureAirportCountryLocationName, ENT_XML1, 'UTF-8') . '</locationName>
                             <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             <currency>
                                <code>' . htmlspecialchars($departureAirportCountyCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
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
                       <changeofGauge>' . htmlspecialchars($changeOfGuage, ENT_XML1, 'UTF-8') . '</changeofGauge>   
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
              <journeyStartLocation>
                 <locationCode>' . htmlspecialchars($locationCode, ENT_XML1, 'UTF-8') . '</locationCode>
              </journeyStartLocation>
              <travelerInformation>
              <passengerTypeQuantityList>
                 <hasStrecher/>
                 <passengerType>
                 <code>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                 </passengerType>
                 <quantity>' . htmlspecialchars($quantity, ENT_XML1, 'UTF-8') . '</quantity>
              </passengerTypeQuantityList>
              <passengerTypeQuantityList>
              <hasStrecher/>
              <passengerType>
                 <code>' . htmlspecialchars($passengerTypeCodeTwo, ENT_XML1, 'UTF-8') . '</code>
              </passengerType>
              <quantity>' . htmlspecialchars($quantityTwo, ENT_XML1, 'UTF-8') . '</quantity>
              </passengerTypeQuantityList>
              <passengerTypeQuantityList>
              <hasStrecher/>
              <passengerType>
                  <code>' . htmlspecialchars($passengerTypeCodeThree, ENT_XML1, 'UTF-8') . '</code>
              </passengerType>
                 <quantity>' . htmlspecialchars($quantityThree, ENT_XML1, 'UTF-8') . '</quantity>
              </passengerTypeQuantityList>
              </travelerInformation>
              <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
              </AirExtraChargesAndProductsRequest>
              </impl:GetAirExtraChargesAndProducts>
              </soapenv:Body>
           </soapenv:Envelope>
        ';
  
        return $xml;
     }
   
   
   

}

























































































































































