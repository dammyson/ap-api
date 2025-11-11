<?php

namespace App\Services\Soap;

class CreateBookingBuilder
{  

    public function CreateBookOriginDestinationOptionList($CreateBookOriginDestinationOptionList)
    {

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
                    
                    '.
                        
                    $this->flightNotes($string['flightNotes'])
                    
                    .'
                     <flownMileageQty>' . htmlspecialchars($string['flownMileageQty'], ENT_XML1, 'UTF-8') . '</flownMileageQty>
                     <iatciFlight>' . htmlspecialchars($string['iatciFlight'], ENT_XML1, 'UTF-8') . '</iatciFlight>
                     <journeyDuration>' . htmlspecialchars($string['journeyDuration'], ENT_XML1, 'UTF-8') . '</journeyDuration>
                     <onTimeRate>' . htmlspecialchars($string['onTimeRate'], ENT_XML1, 'UTF-8') . '</onTimeRate>'.

                    $this->checkRemark($string)

                    

                    .'<secureFlightDataRequired>' . htmlspecialchars($string['secureFlightDataRequired'], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
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


    public function checkRemark($string) {
        if (isset($string['remark'])) {
            return  '<remark>' . htmlspecialchars($string['remark'], ENT_XML1, 'UTF-8') . '</remark>';
        }
    }
    public function flightNotes(
        $flightNotes
    ) {
        $flightNotesXml  = '';
                    
        foreach($flightNotes as $flightNote) {
           $flightNotesXml .=  '
            <flightNotes>
                <deiCode>' . htmlspecialchars($flightNote['deiCode'], ENT_XML1, 'UTF-8') . '</deiCode>
                <explanation>' . htmlspecialchars($flightNote['explanation'], ENT_XML1, 'UTF-8') . '</explanation>
                <note>' . htmlspecialchars($flightNote['note'], ENT_XML1, 'UTF-8') . '</note>
            </flightNotes>';
        }

        return $flightNotesXml;

    }


    public function airTravelerChildList(
        $airTravelerChildList
    ) {
        $xml = '';
        if ($airTravelerChildList) {
            foreach ($airTravelerChildList as $string) {
                $xml .= '
                    <airTravelerList>
                        <accompaniedByInfant>false</accompaniedByInfant>
                        <gender>' . htmlspecialchars($string['airTravelerListGenderChild'], ENT_XML1, 'UTF-8') . '</gender>
                        <birthDate>' . htmlspecialchars($string['airTravelerListBirthDateChild'], ENT_XML1, 'UTF-8') . '</birthDate>
                        <parentSequence/>
                        <passengerTypeCode>CHLD</passengerTypeCode>
                        <personName>
                            <givenName>' . htmlspecialchars($string['personNameGivenNameChild'], ENT_XML1, 'UTF-8') . '</givenName>
                            <surname>' . htmlspecialchars($string['personNameSurnameChild'], ENT_XML1, 'UTF-8') . '</surname>
                        </personName>
                        <nationality>
                            <locationCode>' . htmlspecialchars($string['nationalityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                        </nationality>
                        <requestedSeatCount>' . htmlspecialchars($string['requestedSeatCountChild'], ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                        <unaccompaniedMinor/>'.
                            $this->documentInfoList($string)
                        .'
                    </airTravelerList>';
    
            }
    
            return $xml;
        }
        

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
                <nationality>
                    <locationCode>' . htmlspecialchars($string['nationalityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                </nationality>
                <personAcceptedLegalText>kabul ediyorum</personAcceptedLegalText>
                <unaccompaniedMinor>false</unaccompaniedMinor>'.
                $this->documentInfoList($string)
            .'</airTravelerList>';
        }

        return $xml;
    }

    private function documentInfoList($document) {

        if(isset($document['documentInfoList'])) {
            $xml = '';
            foreach($document['documentInfoList'] as $string) {
                $xml = '<documentInfoList>
                    <birthDate>' . htmlspecialchars($string['birthDate'], ENT_XML1, 'UTF-8') . '</birthDate>
                    <docExpireDate>' . htmlspecialchars($string['docExpireDate'], ENT_XML1, 'UTF-8') . '</docExpireDate>
                    <docHolderFormattedName>
                        <givenName>' . htmlspecialchars($string['givenName'], ENT_XML1, 'UTF-8') . '</givenName>
                        <shareMarketInd>' . htmlspecialchars($string['shareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <surname>' . htmlspecialchars($string['surname'], ENT_XML1, 'UTF-8') . '</surname>
                    </docHolderFormattedName>
                    <docHolderNationality>' . htmlspecialchars($string['docHolderNationality'], ENT_XML1, 'UTF-8') . '</docHolderNationality>
                    <docID>' . htmlspecialchars($string['docID'], ENT_XML1, 'UTF-8') . '</docID>
                    <docType>' . htmlspecialchars($string['docType'], ENT_XML1, 'UTF-8') . '</docType>
                    <gender>M</gender>
                </documentInfoList>';
            }

            return $xml;
        }
    }


    public function createBooking(
        $preferredCurrency,
        $CreateBookOriginDestinationOptionList,
        $contactInfoList,
        $airTravelerList,
        $airTravelerChildList,
        $requestPurpose,
        $otherServiceInformationList,
        $specialServiceRequestList
       
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
                <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>

              </clientInformation>
              <airItinerary>
                 <adviceCodeSegmentExist/>
                  <bookOriginDestinationOptions>' .
            $this->CreateBookOriginDestinationOptionList($CreateBookOriginDestinationOptionList) .
            '</bookOriginDestinationOptions>
              </airItinerary>' .
            $this->airTravelerList($airTravelerList) .' '.

           
            $this->airTravelerChildList($airTravelerChildList)
                
            
            .'

            
              <infantWithSeatCount/>
              <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
              '.
                $this->contactInfoListRequest($contactInfoList)
              .'<specialRequestDetails>
                '. 
                    $this->otherServiceInformationList($otherServiceInformationList)
                 .''.
                    $this->specialServiceRequestList($specialServiceRequestList)
                
              .'</specialRequestDetails>
              </AirBookingRequest>
           </impl:CreateBooking>
        </soapenv:Body>
     </soapenv:Envelope>';

        return $xml;
    }

 
    public function specialServiceRequestList($specialServiceRequestList) {
        if($specialServiceRequestList)
        { 
            $xml = '';
        
            foreach($specialServiceRequestList as $string) {
                $xml .= '
                    <specialServiceRequestList>
                        <airTravelerSequence>' . htmlspecialchars($string['airTravelerSequence'], ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                        <flightSegmentSequence>' . htmlspecialchars($string['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                        <SSR>
                            <allowedQuantityPerPassenger/>
                            <bundleRelatedSsr/>
                            <code>' . htmlspecialchars($string['SSRCode'], ENT_XML1, 'UTF-8') . '</code>
                            <explanation>' . htmlspecialchars($string['SSRExplanation'], ENT_XML1, 'UTF-8') . '</explanation>
                            <exchangeable/>
                            <extraBaggage/>
                            <free/>
                            <iciAllowed/>
                            <refundable/>
                            <showOnItinerary/>
                            <unitOfMeasureExist/>
                        </SSR>                        
                        <serviceQuantity>' . htmlspecialchars($string['ticketedServiceQuantity'], ENT_XML1, 'UTF-8') . '</serviceQuantity>
                        <status>' . htmlspecialchars($string['ticketedStatus'], ENT_XML1, 'UTF-8') . '</status>
                        <ticketed/>
                    </specialServiceRequestList>
                ';
            }

            return $xml;
        }
    }
    public function contactInfoListRequest($contactInfoList) {
        // dump("test");
        if($contactInfoList)
        {   
            // dd(" iran");
            $xml = '';
        
            foreach($contactInfoList as $string) {
                $xml .= '<contactInfoList>
                            <companyInfo>
                                <companyFullName>' . htmlspecialchars($string['companyFullName'], ENT_XML1, 'UTF-8') . '</companyFullName>
                                <companyLegalName>' . htmlspecialchars($string['companyLegalName'], ENT_XML1, 'UTF-8') . '</companyLegalName>
                                <taxNumber>' . htmlspecialchars($string['taxNumber'], ENT_XML1, 'UTF-8') . '</taxNumber>
                                <taxOffice>' . htmlspecialchars($string['taxOffice'], ENT_XML1, 'UTF-8') . '</taxOffice>
                            </companyInfo>
                            <adress>
                                <addressLineList>' . htmlspecialchars($string['addressLineList'], ENT_XML1, 'UTF-8') . '</addressLineList>
                                <adressUseType>' . htmlspecialchars($string['adressUseType'], ENT_XML1, 'UTF-8') . '</adressUseType>
                                <bldgRoom>' . htmlspecialchars($string['bldgRoom'], ENT_XML1, 'UTF-8') . '</bldgRoom>
                                <cityCode>' . htmlspecialchars($string['cityCode'], ENT_XML1, 'UTF-8') . '</cityCode>
                                <cityName>' . htmlspecialchars($string['cityName'], ENT_XML1, 'UTF-8') . '</cityName>
                                <countryCode>' . htmlspecialchars($string['countryCode'], ENT_XML1, 'UTF-8') . '</countryCode>
                                <countryName>' . htmlspecialchars($string['countryName'], ENT_XML1, 'UTF-8') . '</countryName>
                                <formatted>' . htmlspecialchars($string['formatted'], ENT_XML1, 'UTF-8') . '</formatted>
                                <postalCode>' . htmlspecialchars($string['postalCode'], ENT_XML1, 'UTF-8') . '</postalCode>
                                <preferred>' . htmlspecialchars($string['preferred'], ENT_XML1, 'UTF-8') . '</preferred>
                                <shareMarketInd>' . htmlspecialchars($string['shareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                                <stateProvince>' . htmlspecialchars($string['stateProvince'], ENT_XML1, 'UTF-8') . '</stateProvince>
                                <streetNumber>' . htmlspecialchars($string['streetNumber'], ENT_XML1, 'UTF-8') . '</streetNumber>
                            </adress>
                        
                            <email>
                                <email>' . htmlspecialchars($string['email'], ENT_XML1, 'UTF-8') . '</email>
                                <markedForSendingRezInfo/>
                                <preferred/>
                                <shareMarketInd/>
                            </email>
                            <markedForSendingRezInfo>' . htmlspecialchars($string['markedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                            <personName>
                                <givenName>' . htmlspecialchars($string['givenName'], ENT_XML1, 'UTF-8') . '</givenName>
                                <shareMarketInd/>
                                <surname>' . htmlspecialchars($string['surname'], ENT_XML1, 'UTF-8') . '</surname>
                            </personName>
                            <phoneNumber>
                                <areaCode>' . htmlspecialchars($string['areaCode'], ENT_XML1, 'UTF-8') . '</areaCode>
                                <countryCode>' . htmlspecialchars($string['phoneNumberCountryCode'], ENT_XML1, 'UTF-8') . '</countryCode>
                                <markedForSendingRezInfo>' . htmlspecialchars($string['phoneNumberMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                                <phoneUseType>' . htmlspecialchars($string['phoneUseType'], ENT_XML1, 'UTF-8') . '</phoneUseType>
                                <preferred/>
                                <shareMarketInd/>
                                <subscriberNumber>' . htmlspecialchars($string['subscriberNumber'], ENT_XML1, 'UTF-8') . '</subscriberNumber>
                            </phoneNumber>
                        <shareContactInfo/>
                        <shareMarketInd/>
                        <socialSecurityNumber>' . htmlspecialchars($string['socialSecurityNumber'], ENT_XML1, 'UTF-8') . '</socialSecurityNumber>
                        <useForInvoicing>' . htmlspecialchars($string['useForInvoicing'], ENT_XML1, 'UTF-8') . '</useForInvoicing>
                    </contactInfoList>';
            }

            return $xml;
        }
    }

    public function otherServiceInformationList($otherServiceInformationList) {
        if (isset($otherServiceInformationList)) {
             $xml = '<otherServiceInformationList>';

            foreach($otherServiceInformationList as $string) {
                $xml .= '
                    <otherServiceInformationList>
                        <airTravelerSequence>' . htmlspecialchars($string['airTravelerSequence'], ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                        <code>' . htmlspecialchars($string['code'], ENT_XML1, 'UTF-8') . '</code>
                        <explanation>' . htmlspecialchars($string['explanation'], ENT_XML1, 'UTF-8') . '</explanation>
                        <flightSegmentSequence/>
                    </otherServiceInformationList>';
            }
            $xml .= '</otherServiceInformationList>';

            // dd($xml);
            
            return $xml;
        }
       
                

    }
}
