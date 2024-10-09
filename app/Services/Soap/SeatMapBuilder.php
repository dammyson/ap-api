<?php

namespace App\Services\Soap;

class SeatMapBuilder {
    public function seatMap(
        $airlineCode, 
        $airlineCodeContext,
        $arrivalAirportCityLocationCode,
        $arrivalAirportCityLocationName, 
        $arrivalAirportCitylocationNameLanguage,
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
        $arrivalAirportDateTime, 
        $arrivalAirportDateTimeUTC,
        $departureAirportCityLocationCode, 
        $departureAirportCityLocationName, 
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCode, 
        $departureAirportCountryLocationName, 
        $departureAirportLocationNameLanguage, 
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
        $sector,
        $codeshare, 
        $distance, 
        $airEquipType, 
        $changeOfGuage,
        $flightNotes,         
        $flownMileageQty, 
        $iatciFlight, 
        $journeyDuration, 
        $onTimeRate, 
        $remark, 
        $secureFlightDataRequired,
        $segmentStatusByFirstLeg, 
        $stopQuantity, 
        $companyNameCitycode, 
        $companyNameCode, 
        $companyNameCodeContext,
        $companyFullName, 
        $companyShortName, 
        $countryCode, 
        $ID, 
        $referenceID
    
    ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
               <soapenv:Body>
                  <impl:GetSeatMap>
                     <AncillaryOtaSeatMapRequest>
                     <clientInformation>
                     <clientIP>129.0.0.1</clientIP>
                     <member>false</member>
                     <password>SCINTILLA</password>
                     <userName>SCINTILLA</userName>
                     <preferredCurrency>NGN</preferredCurrency>
                     </clientInformation>
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
                                    <locationNameLanguage>' . htmlspecialchars($arrivalAirportCitylocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
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
                                 <locationNameLanguage>' . htmlspecialchars($departureAirportLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
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
                        <sector>' . htmlspecialchars($sector, ENT_XML1, 'UTF-8') . '</sector>
                        <accumulatedDuration/>
                        <codeshare>' . htmlspecialchars($codeshare, ENT_XML1, 'UTF-8') . '</codeshare>
                        <distance>' . htmlspecialchars($distance, ENT_XML1, 'UTF-8') . '</distance>
                        <equipment>
                           <airEquipType>' . htmlspecialchars($airEquipType, ENT_XML1, 'UTF-8') . '</airEquipType>
                           <changeofGauge>' . htmlspecialchars($changeOfGuage, ENT_XML1, 'UTF-8') . '</changeofGauge>
                        </equipment>
                       
                        ' . $this->flightNotes($flightNotes) .'
                        
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
                     <frequentFlyerRedemption/>
                     <bookingReferenceID>
                     <companyName>
                        <cityCode>' . htmlspecialchars($companyNameCitycode, ENT_XML1, 'UTF-8') . '</cityCode>
                        <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                        <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                        <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                        <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                        <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                     </bookingReferenceID>
                     </AncillaryOtaSeatMapRequest>
                  </impl:GetSeatMap>
               </soapenv:Body>
            </soapenv:Envelope>
      
      ';
      return $xml;
   } 

   public function flightNotes($flightNotes) {
      $xml = '';
      foreach($flightNotes as $string) {
        $xml .= '<flightNotes>
            <deiCode>' . htmlspecialchars($string['deiCode'], ENT_XML1, 'UTF-8') . '</deiCode>
            <explanation>' . htmlspecialchars($string['explanation'], ENT_XML1, 'UTF-8') . '</explanation>
            <note>' . htmlspecialchars($string['note'], ENT_XML1, 'UTF-8') . '</note>
         </flightNotes>';
                        
      }

      return $xml;
   }
}