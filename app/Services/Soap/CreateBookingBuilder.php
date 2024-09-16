<?php

namespace App\Services\Soap;

class CreateBookingBuilder
{
    public function createBookingRT(
        $CreateBookOriginDestinationOptionList,
        $airTravelerList,
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

               <bookOriginDestinationOptions>' .
            $this->CreateBookOriginDestinationOptionList($CreateBookOriginDestinationOptionList) .
            '</bookOriginDestinationOptions>

            </airItinerary>' .
            $this->airTravelerList(
                $airTravelerList
            )
            .  ' <infantWithSeatCount/>
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
        $airTravelerList,
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
$this->airTravelerList( $airTravelerList) .
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
        $airTravelerList
    ) {
        $xml = '';

        foreach ($airTravelerList as $string) {
            $xml .= '
            <airTravelerList>
                <gender>' . htmlspecialchars($string['airTravelerListGender'], ENT_XML1, 'UTF-8') . '</gender>
                <hasStrecher/>
                <parentSequence/>
                <passengerTypeCode>' . htmlspecialchars($string['airTravelerPassengerTypeCode'], ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                <personName>
                    <givenName>' . htmlspecialchars($string['airTravelerListGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                    <shareMarketInd/>
                    <surname>' . htmlspecialchars($string['airTravelerListSurname'], ENT_XML1, 'UTF-8') . '</surname>
                </personName>
                <birthDate>' . htmlspecialchars($string['airTravelerBirthDate'], ENT_XML1, 'UTF-8') . '</birthDate>
                <accompaniedByInfant/>
                <contactPerson>
                    <email>
                        <email>' . htmlspecialchars($string['contactPersonEmail'], ENT_XML1, 'UTF-8') . '</email>
                        <markedForSendingRezInfo/>
                        <preferred/>
                        <shareMarketInd>' . htmlspecialchars($string['contactPersonShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                    </email>
                    <markedForSendingRezInfo>' . htmlspecialchars($string['contactPersonMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                    <personName>
                        <givenName>' . htmlspecialchars($string['contactPersonNameGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                        <shareMarketInd/>
                        <surname>' . htmlspecialchars($string['contactPersonSurname'], ENT_XML1, 'UTF-8') . '</surname>
                    </personName>
                    <phoneNumber>
                        <areaCode>' . htmlspecialchars($string['phoneNumberAreaCode'], ENT_XML1, 'UTF-8') . '</areaCode>
                        <countryCode>' . htmlspecialchars($string['phoneNumberCountryCode'], ENT_XML1, 'UTF-8') . '</countryCode>
                        <markedForSendingRezInfo>' . htmlspecialchars($string['phoneNumberMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                        <preferred/>
                        <shareMarketInd/>
                        <subscriberNumber>' . htmlspecialchars($string['phoneNumberSubscriberNumber'], ENT_XML1, 'UTF-8') . '</subscriberNumber>
                    </phoneNumber>
                    <shareMarketInd>' . htmlspecialchars($string['shareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                    <socialSecurityNumber>' . htmlspecialchars($string['contactPersonSocialSecurityNumber'], ENT_XML1, 'UTF-8') . '</socialSecurityNumber>
                    <useForInvoicing/>
                    <shareContactInfo>' . htmlspecialchars($string['shareContactInfo'], ENT_XML1, 'UTF-8') . '</shareContactInfo>
                </contactPerson>
                <requestedSeatCount>' . htmlspecialchars($string['requestedSeatCount'], ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                <shareMarketInd/>
                <unaccompaniedMinor/>
            </airTravelerList>';
        }

        return $xml;
    }




    public function createBookingTwoA(
        $CreateBookOriginDestinationOptionList,
        $airTravelerList,

        $airTravelerListGenderThree,
        $airTravelerListBirthDateThree,
        $passengerTypeCodeThree,
        $personNameGivenNameThree,
        $personNameSurnameThree,
        $contactPersonShareContactInfoThree,
        $requestedSeatCountThree,
        $requestPurposeThree,
        $airTravelerSequenceOne,
        $flightSegmentSequenceOne,
        $SSRCodeOne,
        $SSRExplanationOne,
        $ticketedServiceQuantityOne,
        $ticketedStatusOne,
        $airTravelerSequenceTwo,
        $flightSegmentSequenceTwo,
        $SSRCodeTwo,
        $SSRExplanationTwo,
        $ticketedServiceQuantityTwo,
        $ticketedStatusTwo,
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
            $this->airTravelerList($airTravelerList) .
            '  <airTravelerList>
                 <gender>' . htmlspecialchars($airTravelerListGenderThree, ENT_XML1, 'UTF-8') . '</gender>
                 <accompaniedByInfant/>
                 <birthDate>' . htmlspecialchars($airTravelerListBirthDateThree, ENT_XML1, 'UTF-8') . '</birthDate>
                 <hasStrecher/>
                 <parentSequence/>
                 <passengerTypeCode>' . htmlspecialchars($passengerTypeCodeThree, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                 <personName>
                    <givenName>' . htmlspecialchars($personNameGivenNameThree, ENT_XML1, 'UTF-8') . '</givenName>
                    <shareMarketInd/>
                    <surname>' . htmlspecialchars($personNameSurnameThree, ENT_XML1, 'UTF-8') . '</surname>
                 </personName>
                 <contactPerson>
                    <shareContactInfo>' . htmlspecialchars($contactPersonShareContactInfoThree, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                    <shareMarketInd/>
                    <useForInvoicing/>
                 </contactPerson>
                 <requestedSeatCount>' . htmlspecialchars($requestedSeatCountThree, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                 <shareMarketInd/>
                 <unaccompaniedMinor/>
              </airTravelerList>
              <infantWithSeatCount/>
              <requestPurpose>' . htmlspecialchars($requestPurposeThree, ENT_XML1, 'UTF-8') . '</requestPurpose>
              <specialRequestDetails>
                 <specialServiceRequestList>
                    <airTravelerSequence>' . htmlspecialchars($airTravelerSequenceOne, ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                    <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                    <SSR>
                    <allowedQuantityPerPassenger/>
                    <bundleRelatedSsr/>
                    <code>' . htmlspecialchars($SSRCodeOne, ENT_XML1, 'UTF-8') . '</code>
                    <exchangeable/>
                    <explanation>' . htmlspecialchars($SSRExplanationOne, ENT_XML1, 'UTF-8') . '</explanation>
                    <extraBaggage/>
                    <free/>
                    <iciAllowed/>
                    <refundable/>
                    <showOnItinerary/>
                    <unitOfMeasureExist/>
                    </SSR>
                    <serviceQuantity>' . htmlspecialchars($ticketedServiceQuantityOne, ENT_XML1, 'UTF-8') . '</serviceQuantity>
                    <status>' . htmlspecialchars($ticketedStatusOne, ENT_XML1, 'UTF-8') . '</status>
                    <ticketed/>
                 </specialServiceRequestList>
                 <specialServiceRequestList>
                    <airTravelerSequence>' . htmlspecialchars($airTravelerSequenceTwo, ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                    <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                    <SSR>
                    <allowedQuantityPerPassenger/>
                    <bundleRelatedSsr/>
                    <code>' . htmlspecialchars($SSRCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                    <exchangeable/>
                    <explanation>' . htmlspecialchars($SSRExplanationTwo, ENT_XML1, 'UTF-8') . '</explanation>
                    <extraBaggage/>
                    <free/>
                    <iciAllowed/>
                    <refundable/>
                    <showOnItinerary/>
                    <unitOfMeasureExist/>
                    </SSR>
                    <serviceQuantity>' . htmlspecialchars($ticketedServiceQuantityTwo, ENT_XML1, 'UTF-8') . '</serviceQuantity>
                    <status>' . htmlspecialchars($ticketedStatusTwo, ENT_XML1, 'UTF-8') . '</status>
                    <ticketed/>
                 </specialServiceRequestList>
              </specialRequestDetails>
              </AirBookingRequest>
           </impl:CreateBooking>
        </soapenv:Body>
     </soapenv:Envelope>';

        return $xml;
    }
}
