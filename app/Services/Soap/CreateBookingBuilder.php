<?php

namespace App\Services\Soap;

class CreateBookingBuilder
{
   public function createBookingRT(
      $bookingFlightActionCode,
      $bookingFlightCabin,
      $bookingFlightResBookDesigCode,
      $bookingFlightResBookDesigQuantity,
      $bookingFlightResBookDesigStatusCode,
      $fareInfoCabin,
      $fareInfoCabinClassCode,
      $bookingFlightFareBaggageAllowanceType,
      $bookingFlightFareBaggageMaxAllowedPieces,
      $unitOfMeasureCode,
      $fareInfoMaxAllowedWeight,
      $fareInfoFareGroupName,
      $fareInfoFareReferenceCode,
      $fareInfoFareReferenceID,
      $fareInfoFareReferenceName,
      $fareInfoFlightSegmentSequence,
      $fareInfoPortTax,
      $resBookDesigCode,
      $flightSegmentCode,
      $flightSegmentCompanyFullName,
      $arrivalAirporCityLocationCodeOne,
      $arrivalAirportCityLocationNameOne,
      $arrivalAirportCityLocationNameLanguageOne,
      $arrivalAirportCountryLocationCodeOne,
      $arrivalAirportCountryLocationNameOne,
      $arrivalAirportCountryLocationNameLanguageOne,
      $arrivalAirportCurrencyCodeOne,
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
      $equipmentAirEquipType,
      $equipmentChangeOfGauge,
      $flightNotesDeiCodeOne,
      $flightNotesExplanationOne,
      $flightNotesNoteOne,
      $flightNotesDeiCodeTwo,
      $flightNotesExplanationTwo,
      $flightNotesNoteTwo,
      $flightNoteDeiCodeThree,
      $flightNotesExplanationThree,
      $flightNotesNoteThree,
      $flownMileageQty,
      $iatciFlight,
      $journeyDurationOne,
      $onTimeRateOne,
      $flightSegmentRemark,
      $secureFlightDataRequired,
      $stopQuantityOne,
      $ticketTypeOne,

      $bookingFlightSegmentActionCodeTwo,
      $bookingClassCabinTwo,
      $bookingClassResBookDesigCodeTwo,
      $bookingClassResBookDesigQuantityTwo,
      $bookingClassResBookDesigStatusCodeTwo,
      $fareInfoCabinTwo,
      $fareInfoCabinClassCodeTwo,
      $fareBaggageAllowanceTypeTwo,
      $fareBaggageMaxAllowedPiecesTwo,
      $maxAllowedWeightUnitOfMeasureCodeTwo,
      $maxAllowedWeightTwo,
      $fareGroupNameTwo,
      $fareReferenceCodeTwo,
      $fareReferenceIDTwo,
      $fareReferenceNameTwo,
      $flightSegmentSequenceTwo,
      $portTaxTwo,
      $fareInfoResBookDesigCodeTwo,
      $airlineCodeTwo,
      $airlineCompanyFullNameTwo,
      $arrivalAirportCityLocationCodeTwo,
      $arrivalAirportCityLocationNameTwo,
      $arrivalAirportCityLocationNameLanguageTwo,
      $arrivalAirportCountryLocationCodeTwo,
      $arrivalAirportCountryLocationNameTwo,
      $arrivalAirportCountryLocationNameLanguageTwo,
      $arrivalAirportCurrencyCodeTwo,
      $arrivalAirportCodeContextTwo,
      $arrivalAirportLanguageTwo,
      $arrivalAirportLocationCodeTwo,
      $arrivalAirportLocationNameTwo,
      $arrivalAirportTimeZoneInfoTwo,
      $arrivalDateTimeTwo,
      $arrivalDateTimeUTCTwo,
      $departureAirportCityLocationCodeTwo,
      $departureAirportCityInfoLocationNameTwo,
      $departureAirportCityLocationNameLanguageTwo,
      $departureAirportCountryLocationCodeTwo,
      $departureAirportCountryLocationNameTwo,
      $departureAirportCountryLocationNameLanguageTwo,
      $deparutureAirportCountryCurrencyCodeTwo,
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
      $codeshareTwo,
      $distanceTwo,
      $airEquipTypeTwo,
      $changeOfGuageTwo,
      $flightNotesDeiCodeFour,
      $flightNotesExplanationFour,
      $flightNotesNoteFour,
      $flightNotesDeiCodeFive,
      $flightNotesExplanationFive,
      $flightNotesNoteFive,
      $flownMileageQtyTwo,
      $iatciFlightTwo,
      $journeyDurationTwo,
      $onTimeRateTwo,
      $secureFlightDataRequiredTwo,
      $stopQuantityTwo,
      $ticketTypeTwo,



      
      $airTravelerListGenderTwo,
      $airTravelerListPassengerTypeCodeTwo,
      $airTravelerListPersonNameGivenNameTwo,
      $airTravelerListSurnameTwo,
      $airTravelerListBirthDateTwo,
      $contactPersonEmail,
      $contactPersonShareMarketInd,
      $contactPersonMarkedForSendingRezInfo,
      $contactPersonPersonNameGivenName,
      $contactPersonPersonNameSurname,
      $phoneNumberAreaCode,
      $phoneNumberCountryCode,
      $phoneNumberMarkedForSendingRezInfo,
      $phoneNumberSubscriberNumber,
      $phoneNumberShareMarketInd,
      $phoneNumberSocialSecurityNumber,
      $shareContactInfo,
      $requestedSeatCount,
      $requestPurpose,
      $capturePayment,
      $paymentCode,
      $threeDomainSecurityEligible,
      $MCONumber,
      $paymentAmountCurrencyCode,
      $paymentType,
      $primaryPayment
   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>      
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
            <impl:CreateBooking>
            <AirBookingRequest>
            <clientInformation>
            <clientIP>129.0.0.1</clientIP>
            <member>false</member>
            <password>SCINTILLA</password>
            <userName>SCINTILLA</userName>
            <preferredCurrency>NGN</preferredCurrency>
            </clientInformation>
            <airItinerary>
               <adviceCodeSegmentExist/>
               <bookOriginDestinationOptions>

               <bookOriginDestinationOptionList>
                  <bookFlightSegmentList>
                     <actionCode>' . htmlspecialchars($bookingFlightActionCode, ENT_XML1, 'UTF-8') . '</actionCode>
                     <addOnSegment/>
                     <bookingClass>
                        <cabin>' . htmlspecialchars($bookingFlightCabin, ENT_XML1, 'UTF-8') . '</cabin>
                        <resBookDesigCode>' . htmlspecialchars($bookingFlightResBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        <resBookDesigQuantity>' . htmlspecialchars($bookingFlightResBookDesigQuantity, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                        <resBookDesigStatusCode>' . htmlspecialchars($bookingFlightResBookDesigStatusCode, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                     </bookingClass>
                     <fareInfo>
                        <cabin>' . htmlspecialchars($fareInfoCabin, ENT_XML1, 'UTF-8') . '</cabin>
                        <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                        <fareBaggageAllowance>
                           <allowanceType>' . htmlspecialchars($bookingFlightFareBaggageAllowanceType, ENT_XML1, 'UTF-8') . '</allowanceType>
                           <maxAllowedPieces>' . htmlspecialchars($bookingFlightFareBaggageMaxAllowedPieces, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                           <maxAllowedWeight>
                              <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCode, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                              <weight>' . htmlspecialchars($fareInfoMaxAllowedWeight, ENT_XML1, 'UTF-8') . '</weight>
                           </maxAllowedWeight>
                        </fareBaggageAllowance>
                        <fareGroupName>' . htmlspecialchars($fareInfoFareGroupName, ENT_XML1, 'UTF-8') . '</fareGroupName>
                        <fareReferenceCode>' . htmlspecialchars($fareInfoFareReferenceCode, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                        <fareReferenceID>' . htmlspecialchars($fareInfoFareReferenceID, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                        <fareReferenceName>' . htmlspecialchars($fareInfoFareReferenceName, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                        <flightSegmentSequence>' . htmlspecialchars($fareInfoFlightSegmentSequence, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                        <portTax>' . htmlspecialchars($fareInfoPortTax, ENT_XML1, 'UTF-8') . '</portTax>
                        <resBookDesigCode>' . htmlspecialchars($resBookDesigCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                     </fareInfo>
                     <flightSegment>
                        <airline>
                           <code>' . htmlspecialchars($flightSegmentCode, ENT_XML1, 'UTF-8') . '</code>
                           <companyFullName>' . htmlspecialchars($flightSegmentCompanyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                        </airline>
                        <arrivalAirport>
                           <cityInfo>
                              <city>
                                 <locationCode>' . htmlspecialchars($arrivalAirporCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              </city>
                              <country>
                                 <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 <currency>
                                    <code>' . htmlspecialchars($arrivalAirportCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
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
                           <airEquipType>' . htmlspecialchars($equipmentAirEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                           <changeofGauge>' . htmlspecialchars($equipmentChangeOfGauge, ENT_XML1, 'UTF-8') . '</changeofGauge>
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
                           <deiCode>' . htmlspecialchars($flightNoteDeiCodeThree, ENT_XML1, 'UTF-8') . '</deiCode>
                           <explanation>' . htmlspecialchars($flightNotesExplanationThree, ENT_XML1, 'UTF-8') . '</explanation>
                           <note>' . htmlspecialchars($flightNotesNoteThree, ENT_XML1, 'UTF-8') . '</note>
                        </flightNotes>
                        <flownMileageQty>' . htmlspecialchars($flownMileageQty, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                        <iatciFlight>' . htmlspecialchars($iatciFlight, ENT_XML1, 'UTF-8') . '</iatciFlight>
                        <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                        <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                        <remark>' . htmlspecialchars($flightSegmentRemark, ENT_XML1, 'UTF-8') . '</remark>
                        <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequired, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                        <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                        <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                     </flightSegment>
                     <involuntaryPermissionGiven/>
                     <sequenceNumber/>
               </bookFlightSegmentList>
               </bookOriginDestinationOptionList>



               <bookOriginDestinationOptionList>
                  <bookFlightSegmentList>
                     <actionCode>' . htmlspecialchars($bookingFlightSegmentActionCodeTwo, ENT_XML1, 'UTF-8') . '</actionCode>
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
                           <allowanceType>' . htmlspecialchars($fareBaggageAllowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                           <maxAllowedPieces>' . htmlspecialchars($fareBaggageMaxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                           <maxAllowedWeight>
                              <unitOfMeasureCode>' . htmlspecialchars($maxAllowedWeightUnitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                              <weight>' . htmlspecialchars($maxAllowedWeightTwo, ENT_XML1, 'UTF-8') . '</weight>
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
                           <companyFullName>' . htmlspecialchars($airlineCompanyFullNameTwo, ENT_XML1, 'UTF-8') . '</companyFullName>
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
                                 <code>' . htmlspecialchars($arrivalAirportCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
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
                                 <locationName>' . htmlspecialchars($departureAirportCityInfoLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              </city>
                              <country>                             
                                 <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 <currency>
                                    <code>' . htmlspecialchars($deparutureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
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
                        <codeshare>' . htmlspecialchars($codeshareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                        <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                        <equipment>
                           <airEquipType>' . htmlspecialchars($airEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                           <changeofGauge>' . htmlspecialchars($changeOfGuageTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
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
                        <flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                        <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                        <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                        <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                        <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                        <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                        <ticketType>' . htmlspecialchars($ticketTypeTwo, ENT_XML1, 'UTF-8') . '</ticketType>
                     </flightSegment>
                     <involuntaryPermissionGiven/>
                     <sequenceNumber/>
                  </bookFlightSegmentList>
               </bookOriginDestinationOptionList>


               </bookOriginDestinationOptions>

            </airItinerary>

            <airTravelerList>
               <gender>' . htmlspecialchars($airTravelerListGenderTwo, ENT_XML1, 'UTF-8') . '</gender>
               <hasStrecher/>
               <parentSequence/>
               <passengerTypeCode>' . htmlspecialchars($airTravelerListPassengerTypeCodeTwo, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
               <personName>
                  <givenName>' . htmlspecialchars($airTravelerListPersonNameGivenNameTwo, ENT_XML1, 'UTF-8') . '</givenName>
                  <shareMarketInd/>
                  <surname>' . htmlspecialchars($airTravelerListSurnameTwo, ENT_XML1, 'UTF-8') . '</surname>
               </personName>
               <birthDate>' . htmlspecialchars($airTravelerListBirthDateTwo, ENT_XML1, 'UTF-8') . '</birthDate>
               <accompaniedByInfant/>
               <contactPerson>
                  <email>
                  <email>' . htmlspecialchars($contactPersonEmail, ENT_XML1, 'UTF-8') . '</email>
                  <markedForSendingRezInfo/>
                  <preferred/>
                  <shareMarketInd>' . htmlspecialchars($contactPersonShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  </email>
                  <markedForSendingRezInfo>' . htmlspecialchars($contactPersonMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                  <personName>
                     <givenName>' . htmlspecialchars($contactPersonPersonNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                     <shareMarketInd/>
                     <surname>' . htmlspecialchars($contactPersonPersonNameSurname, ENT_XML1, 'UTF-8') . '</surname>
                  </personName>
                  <phoneNumber>
                     <areaCode>' . htmlspecialchars($phoneNumberAreaCode, ENT_XML1, 'UTF-8') . '</areaCode>
                     <countryCode>' . htmlspecialchars($phoneNumberCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                     <markedForSendingRezInfo>' . htmlspecialchars($phoneNumberMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                     <preferred/>
                     <shareMarketInd/>
                     <subscriberNumber>' . htmlspecialchars($phoneNumberSubscriberNumber, ENT_XML1, 'UTF-8') . '</subscriberNumber>
                  </phoneNumber>
                  <shareMarketInd>' . htmlspecialchars($phoneNumberShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  <socialSecurityNumber>' . htmlspecialchars($phoneNumberSocialSecurityNumber, ENT_XML1, 'UTF-8') . '</socialSecurityNumber>
                  <useForInvoicing/>
                  <shareContactInfo>' . htmlspecialchars($shareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
               </contactPerson>
               <requestedSeatCount>' . htmlspecialchars($requestedSeatCount, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
               <shareMarketInd/>
               <unaccompaniedMinor/>
            </airTravelerList>

            <infantWithSeatCount/>
            <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
            <fullfillment>
            <paymentDetails>
            <paymentDetailList>
            <miscChargeOrder>
            <avsEnabled/>
            <capturePaymentToolNumber>' . htmlspecialchars($capturePayment, ENT_XML1, 'UTF-8') . '</capturePaymentToolNumber>
            <paymentCode>' . htmlspecialchars($paymentCode, ENT_XML1, 'UTF-8') . '</paymentCode>
            <threeDomainSecurityEligible>' . htmlspecialchars($threeDomainSecurityEligible, ENT_XML1, 'UTF-8') . '</threeDomainSecurityEligible>
            <transactionFeeApplies/>
            <MCONumber>' . htmlspecialchars($MCONumber, ENT_XML1, 'UTF-8') . '</MCONumber>
            </miscChargeOrder>
            <payLater/>
            <paymentAmount>
               <currency>
                  <code>' . htmlspecialchars($paymentAmountCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
               </currency>
               <mileAmount/>
               <value/> 
            </paymentAmount>
            <paymentType>' . htmlspecialchars($paymentType, ENT_XML1, 'UTF-8') . '</paymentType>
            <primaryPayment>' . htmlspecialchars($primaryPayment, ENT_XML1, 'UTF-8') . '</primaryPayment>
            </paymentDetailList>
            </paymentDetails>
            </fullfillment>
            </AirBookingRequest>
            </impl:CreateBooking>
            </soapenv:Body>
         </soapenv:Envelope>';
      return  $xml;
   }

   public function createBookingOW(
      $CreateBookOriginDestinationOptionList,
      $airTravelerListGender,
      $airTravelerPassengerTypeCode,
      $airTravelerListGivenName,
      $airTravelerListSurname,
      $airTravelerBirthDate,
      $contactPersonEmail,
      $contactPersonShareMarketInd,
      $contactPersonMarkedForSendingRezInfo,
      $contactPersonNameGivenName,
      $contactPersonSurname,
      $phoneNumberAreaCode,
      $phoneNumberCountryCode,
      $phoneNumberMarkedForSendingRezInfo,
      $phoneNumberSubscriberNumber,
      $shareMarketInd,
      $contactPersonSocialSecurityNumber,
      $shareContactInfo,
      $requestedSeatCount,

      $requestPurpose
   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
        <soapenv:Header/>
            <soapenv:Body>
                <impl:CreateBooking>
                    <AirBookingRequest>
                    <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                    </clientInformation>
                    <airItinerary>
                    <adviceCodeSegmentExist/>
                     <bookOriginDestinationOptions>' .
         $this->CreateBookOriginDestinationOptionList($CreateBookOriginDestinationOptionList) .
         '</bookOriginDestinationOptions>
                    </airItinerary>' .
         $this->airTravelerList(
            $airTravelerListGender,
            $airTravelerPassengerTypeCode,
            $airTravelerListGivenName,
            $airTravelerListSurname,
            $airTravelerBirthDate,
            $contactPersonEmail,
            $contactPersonShareMarketInd,
            $contactPersonMarkedForSendingRezInfo,
            $contactPersonNameGivenName,
            $contactPersonSurname,
            $phoneNumberAreaCode,
            $phoneNumberCountryCode,
            $phoneNumberMarkedForSendingRezInfo,
            $phoneNumberSubscriberNumber,
            $shareMarketInd,
            $contactPersonSocialSecurityNumber,
            $shareContactInfo,
            $requestedSeatCount
         ) .
         '<infantWithSeatCount/>
                    <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                    </AirBookingRequest>
                </impl:CreateBooking>
        </soapenv:Body>
        </soapenv:Envelope>';
      return $xml;
   }






   public function CreateBookOriginDestinationOptionList($CreateBookOriginDestinationOptionList)
   {  
      //dd($CreateBookOriginDestinationOptionList[0]['flightSegmeneSequence'] );

       $xml = '';

      foreach ($CreateBookOriginDestinationOptionList as $string) {
         $xml .= '
         <bookOriginDestinationOptionList>
             <bookFlightSegmentList>
                 <actionCode>' . htmlspecialchars($string['actionCode'], ENT_XML1, 'UTF-8') . '</actionCode>
                 <addOnSegment/>
                 <bookingClass>
                     <cabin>' . htmlspecialchars($string['bookingClassCabin'], ENT_XML1, 'UTF-8') . '</cabin>
                     <resBookDesigCode>' . htmlspecialchars($string['bookingClassResBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                     <resBookDesigQuantity>' . htmlspecialchars($string['bookingClassResBookDesigQuantity'], ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                     <resBookDesigStatusCode>' . htmlspecialchars($string['bookingClassResBookDesigStatusCode'], ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                 </bookingClass>
                 <fareInfo>
                     <cabin>' . htmlspecialchars($string['fareInfoCabin'], ENT_XML1, 'UTF-8') . '</cabin>
                     <cabinClassCode>' . htmlspecialchars($string['fareInfoCabinClassCode'], ENT_XML1, 'UTF-8') . '</cabinClassCode>
                     <fareBaggageAllowance>
                         <allowanceType>' . htmlspecialchars($string['fareBaggageAllowanceType'], ENT_XML1, 'UTF-8') . '</allowanceType>
                         <maxAllowedPieces>' . htmlspecialchars($string['fareBaggageMaxAllowedPieces'], ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                         <maxAllowedWeight>
                             <unitOfMeasureCode>' . htmlspecialchars($string['unitOfMeasureCode'], ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                             <weight>' . htmlspecialchars($string['maxAllowedWeight'], ENT_XML1, 'UTF-8') . '</weight>
                         </maxAllowedWeight>
                     </fareBaggageAllowance>
                     <fareGroupName>' . htmlspecialchars($string['fareGroupName'], ENT_XML1, 'UTF-8') . '</fareGroupName>
                     <fareReferenceCode>' . htmlspecialchars($string['fareReferenceCode'], ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                     <fareReferenceID>' . htmlspecialchars($string['fareReferenceID'], ENT_XML1, 'UTF-8') . '</fareReferenceID>
                     <fareReferenceName>' . htmlspecialchars($string['fareReferenceName'], ENT_XML1, 'UTF-8') . '</fareReferenceName>
                     <flightSegmentSequence>' . htmlspecialchars($string['flightSegmeneSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                     <portTax>' . htmlspecialchars($string['fareInfoPortTax'], ENT_XML1, 'UTF-8') . '</portTax>
                     <resBookDesigCode>' . htmlspecialchars($string['fareInfoResBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                 </fareInfo>
                 <flightSegment>
                     <airline>
                         <code>' . htmlspecialchars($string['airlineCode'], ENT_XML1, 'UTF-8') . '</code>
                         <companyFullName>' . htmlspecialchars($string['airlineCompanyFullName'], ENT_XML1, 'UTF-8') . '</companyFullName>
                     </airline>
                     <arrivalAirport>
                         <cityInfo>
                             <city>
                                 <locationCode>' . htmlspecialchars($string['arrivalAirportCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($string['arrivalAirportCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($string['arrivalAirportCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             </city>
                             <country>
                                 <locationCode>' . htmlspecialchars($string['arrivalAirportCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($string['arrivalAirportCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($string['arrivalAirportCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 <currency>
                                     <code>' . htmlspecialchars($string['arrivalAirportCountryCode'], ENT_XML1, 'UTF-8') . '</code>
                                 </currency>
                             </country>
                         </cityInfo>
                         <codeContext>' . htmlspecialchars($string['arrivalAirportCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
                         <language>' . htmlspecialchars($string['arrivalAirportLanguage'], ENT_XML1, 'UTF-8') . '</language>
                         <locationCode>' . htmlspecialchars($string['arrivalAirportLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                         <locationName>' . htmlspecialchars($string['arrivalAirportLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                         <timeZoneInfo>' . htmlspecialchars($string['arrivalAirportTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </arrivalAirport>
                     <arrivalDateTime>' . htmlspecialchars($string['arrivalDateTime'], ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                     <arrivalDateTimeUTC>' . htmlspecialchars($string['arrivalDateTimeUTC'], ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                     <departureAirport>
                         <cityInfo>
                             <city>
                                 <locationCode>' . htmlspecialchars($string['departureAirportCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($string['departureAirportCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($string['departureAirportCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                             </city>
                             <country>
                                 <locationCode>' . htmlspecialchars($string['departureAirportCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($string['departureAirportCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($string['departureAirportCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 <currency>
                                     <code>' . htmlspecialchars($string['departureAirportCountryCurrencyCode'], ENT_XML1, 'UTF-8') . '</code>
                                 </currency>
                             </country>
                         </cityInfo>
                         <codeContext>' . htmlspecialchars($string['departureAirportCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
                         <language>' . htmlspecialchars($string['departureAirportLanguage'], ENT_XML1, 'UTF-8') . '</language>
                         <locationCode>' . htmlspecialchars($string['departureAirportLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                         <locationName>' . htmlspecialchars($string['departureAirportLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                         <timeZoneInfo>' . htmlspecialchars($string['departureAirportTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </departureAirport>
                     <departureDateTime>' . htmlspecialchars($string['departureDateTime'], ENT_XML1, 'UTF-8') . '</departureDateTime>
                     <departureDateTimeUTC>' . htmlspecialchars($string['departureDateTimeUTC'], ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                     <flightNumber>' . htmlspecialchars($string['flightNumber'], ENT_XML1, 'UTF-8') . '</flightNumber>
                     <flightSegmentID>' . htmlspecialchars($string['flightSegmentID'], ENT_XML1, 'UTF-8') . '</flightSegmentID>
                     <ondControlled>' . htmlspecialchars($string['ondControlled'], ENT_XML1, 'UTF-8') . '</ondControlled>
                     <sector>' . htmlspecialchars($string['sector'], ENT_XML1, 'UTF-8') . '</sector>
                     <codeshare>' . htmlspecialchars($string['codeshare'], ENT_XML1, 'UTF-8') . '</codeshare>
                     <distance>' . htmlspecialchars($string['distance'], ENT_XML1, 'UTF-8') . '</distance>
                     <equipment>
                         <airEquipType>' . htmlspecialchars($string['airEquipType'], ENT_XML1, 'UTF-8') . '</airEquipType>
                         <changeofGauge>' . htmlspecialchars($string['changeOfGuage'], ENT_XML1, 'UTF-8') . '</changeofGauge>
                     </equipment>
                     <flightNotes>
                         <deiCode>' . htmlspecialchars($string['flightNotesDeiCodeOne'], ENT_XML1, 'UTF-8') . '</deiCode>
                         <explanation>' . htmlspecialchars($string['flightNotesExplanationOne'], ENT_XML1, 'UTF-8') . '</explanation>
                         <note>' . htmlspecialchars($string['flightNoteOne'], ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flightNotes>
                         <deiCode>' . htmlspecialchars($string['flightNotesDeiCodeTwo'], ENT_XML1, 'UTF-8') . '</deiCode>
                         <explanation>' . htmlspecialchars($string['flightNotesExplanationTwo'], ENT_XML1, 'UTF-8') . '</explanation>
                         <note>' . htmlspecialchars($string['flightNotesNoteTwo'], ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flightNotes>
                         <deiCode>' . htmlspecialchars($string['flightNoteDeiCodeThree'], ENT_XML1, 'UTF-8') . '</deiCode>
                         <explanation>' . htmlspecialchars($string['flightNoteExplanationThree'], ENT_XML1, 'UTF-8') . '</explanation>
                         <note>' . htmlspecialchars($string['flightNotesNoteThree'], ENT_XML1, 'UTF-8') . '</note>
                     </flightNotes>
                     <flownMileageQty>' . htmlspecialchars($string['flownMileageQty'], ENT_XML1, 'UTF-8') . '</flownMileageQty>
                     <iatciFlight>' . htmlspecialchars($string['iatciFlight'], ENT_XML1, 'UTF-8') . '</iatciFlight>
                     <journeyDuration>' . htmlspecialchars($string['journeyDuration'], ENT_XML1, 'UTF-8') . '</journeyDuration>
                     <onTimeRate>' . htmlspecialchars($string['onTimeRate'], ENT_XML1, 'UTF-8') . '</onTimeRate>
                     <remark>' . htmlspecialchars($string['remark'], ENT_XML1, 'UTF-8') . '</remark>
                     <secureFlightDataRequired>' . htmlspecialchars($string['secureFlightDataRequired'], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                     <stopQuantity>' . htmlspecialchars($string['stopQuantity'], ENT_XML1, 'UTF-8') . '</stopQuantity>
                     <ticketType>' . htmlspecialchars($string['ticketType'], ENT_XML1, 'UTF-8') . '</ticketType>
                    </flightSegment>
                    <involuntaryPermissionGiven/>
                    <sequenceNumber/>
                    </bookFlightSegmentList>
                    </bookOriginDestinationOptionList>
      ';
      }
      return $xml;
   }


   public function airTravelerList(
      $airTravelerListGender,
      $airTravelerPassengerTypeCode,
      $airTravelerListGivenName,
      $airTravelerListSurname,
      $airTravelerBirthDate,
      $contactPersonEmail,
      $contactPersonShareMarketInd,
      $contactPersonMarkedForSendingRezInfo,
      $contactPersonNameGivenName,
      $contactPersonSurname,
      $phoneNumberAreaCode,
      $phoneNumberCountryCode,
      $phoneNumberMarkedForSendingRezInfo,
      $phoneNumberSubscriberNumber,
      $shareMarketInd,
      $contactPersonSocialSecurityNumber,
      $shareContactInfo,
      $requestedSeatCount,
   ) {
      $xml = '
                   <airTravelerList>
                    <gender>' . htmlspecialchars($airTravelerListGender, ENT_XML1, 'UTF-8') . '</gender>
                    <hasStrecher/>
                    <parentSequence/>
                    <passengerTypeCode>' . htmlspecialchars($airTravelerPassengerTypeCode, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                    <personName>
                        <givenName>' . htmlspecialchars($airTravelerListGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                        <shareMarketInd/>
                        <surname>' . htmlspecialchars($airTravelerListSurname, ENT_XML1, 'UTF-8') . '</surname>
                    </personName>
                    <birthDate>' . htmlspecialchars($airTravelerBirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                    <accompaniedByInfant/>
                    <contactPerson>
                        <email>
                        <email>' . htmlspecialchars($contactPersonEmail, ENT_XML1, 'UTF-8') . '</email>
                        <markedForSendingRezInfo/>
                        <preferred/>
                        <shareMarketInd>' . htmlspecialchars($contactPersonShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </email>
                        <markedForSendingRezInfo>' . htmlspecialchars($contactPersonMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                        <personName>
                            <givenName>' . htmlspecialchars($contactPersonNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                            <shareMarketInd/>
                            <surname>' . htmlspecialchars($contactPersonSurname, ENT_XML1, 'UTF-8') . '</surname>
                        </personName>
                        <phoneNumber>
                            <areaCode>' . htmlspecialchars($phoneNumberAreaCode, ENT_XML1, 'UTF-8') . '</areaCode>
                            <countryCode>' . htmlspecialchars($phoneNumberCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                            <markedForSendingRezInfo>' . htmlspecialchars($phoneNumberMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                            <preferred/>
                            <shareMarketInd/>
                            <subscriberNumber>' . htmlspecialchars($phoneNumberSubscriberNumber, ENT_XML1, 'UTF-8') . '</subscriberNumber>
                        </phoneNumber>
                        <shareMarketInd>' . htmlspecialchars($shareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <socialSecurityNumber>' . htmlspecialchars($contactPersonSocialSecurityNumber, ENT_XML1, 'UTF-8') . '</socialSecurityNumber>
                        <useForInvoicing/>
                        <shareContactInfo>' . htmlspecialchars($shareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                    </contactPerson>
                    <requestedSeatCount>' . htmlspecialchars($requestedSeatCount, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                    <shareMarketInd/>
                    <unaccompaniedMinor/>
                  </airTravelerList>
      ';

      return $xml;
   }
}
