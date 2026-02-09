<?php

namespace App\Services\Soap;

use App\Http\Requests\Test\seatMapRequest;

class SeatMapBuilder {
   protected $craneUsername;
   protected $cranePassword;

   public function __construct() {
      $this->craneUsername = config('app.crane.username');            
      $this->cranePassword = config('app.crane.password');
   }

   public function seatMap(
         $request
    
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
                     <password>'. htmlspecialchars($this->cranePassword, ENT_XML1, 'UTF-8') .'</password>
                     <userName>'. htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') .'</userName>
                     <preferredCurrency>NGN</preferredCurrency>
                     </clientInformation>
                     <flightSegment>
                        <airline>
                           <code>' . htmlspecialchars($request->input('airlineCode'), ENT_XML1, 'UTF-8') . '</code>
                           <codeContext>' . htmlspecialchars($request->input('airlineCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                        </airline>
                        <arrivalAirport>
                              <cityInfo>
                                 <city>
                                    <locationCode>' . htmlspecialchars($request->input('arrivalAirportCityLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('arrivalAirportCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('arrivalAirportCitylocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($request->input('arrivalAirportCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('arrivalAirportCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('arrivalAirportCountryLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>' . htmlspecialchars($request->input('arrivalAirportCountryCurrencyCode'), ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                 </country>
                              </cityInfo>
                           <codeContext>' . htmlspecialchars($request->input('arrivalAirportCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                           <language>' . htmlspecialchars($request->input("arrivalAirportLanguage"), ENT_XML1, 'UTF-8') . '</language>
                           <locationCode>' . htmlspecialchars($request->input('arrivalAirportLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                           <locationName>' . htmlspecialchars($request->input('arrivalAirportLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                           <terminal>' . htmlspecialchars($request->input('arrivalAirportTerminal'), ENT_XML1, 'UTF-8') . '</terminal>
                           <timeZoneInfo>' . htmlspecialchars($request->input('arrivalAirportTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </arrivalAirport>
                        <arrivalDateTime>' . htmlspecialchars($request->input('arrivalAirportDateTime'), ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                        <arrivalDateTimeUTC>' . htmlspecialchars($request->input('arrivalAirportDateTimeUTC'), ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                        <departureAirport>
                           <cityInfo>
                              <city>
                                 <locationCode>' . htmlspecialchars($request->input('departureAirportCityLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($request->input('departureAirportCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($request->input('departureAirportCityLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              </city>
                              <country>
                                 <locationCode>' . htmlspecialchars($request->input('departureAirportCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                 <locationName>' . htmlspecialchars($request->input('departureAirportCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                 <locationNameLanguage>' . htmlspecialchars($request->input('departureAirportLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 <currency>
                                    <code>' . htmlspecialchars($request->input('departureAirportCurrencyCode'), ENT_XML1, 'UTF-8') . '</code>
                                 </currency>
                              </country>
                           </cityInfo>
                           <codeContext>' . htmlspecialchars($request->input('departureAirportCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                           <language>' . htmlspecialchars($request->input('departureAirportLanguage'), ENT_XML1, 'UTF-8') . '</language>
                           <locationCode>' . htmlspecialchars($request->input('departureAirportLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                           <locationName>' . htmlspecialchars($request->input('departureAirportLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                           <timeZoneInfo>' . htmlspecialchars($request->input('departureAirportTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </departureAirport>
                        <departureDateTime>' . htmlspecialchars($request->input('departureDateTime'), ENT_XML1, 'UTF-8') . '</departureDateTime>
                        <departureDateTimeUTC>' . htmlspecialchars($request->input('departureDateTimeUTC'), ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                        <flightNumber>' . htmlspecialchars($request->input('flightNumber'), ENT_XML1, 'UTF-8') . '</flightNumber>
                        <flightSegmentID>' . htmlspecialchars($request->input('flightSegmentID'), ENT_XML1, 'UTF-8') . '</flightSegmentID>
                        <ondControlled>' . htmlspecialchars($request->input('ondControlled'), ENT_XML1, 'UTF-8') . '</ondControlled>
                        <sector>' . htmlspecialchars($request->input('sector'), ENT_XML1, 'UTF-8') . '</sector>
                        <accumulatedDuration/>
                        <codeshare>' . htmlspecialchars($request->input('codeshare'), ENT_XML1, 'UTF-8') . '</codeshare>
                        <distance>' . htmlspecialchars($request->input('distance'), ENT_XML1, 'UTF-8') . '</distance>
                        <equipment>
                           <airEquipType>' . htmlspecialchars($request->input('airEquipType'), ENT_XML1, 'UTF-8') . '</airEquipType>
                           <changeofGauge>' . htmlspecialchars($request->input('changeOfGuage'), ENT_XML1, 'UTF-8') . '</changeofGauge>
                        </equipment>
                       
                        ' . $this->flightNotes($request->input('flightNotes')) .'
                        
                        <flownMileageQty>' . htmlspecialchars($request->input('flownMileageQty'), ENT_XML1, 'UTF-8') . '</flownMileageQty>
                        <groundDuration/>
                        <iatciFlight>' . htmlspecialchars($request->input('iatciFlight'), ENT_XML1, 'UTF-8') . '</iatciFlight>
                        <journeyDuration>' . htmlspecialchars($request->input('journeyDuration'), ENT_XML1, 'UTF-8') . '</journeyDuration>
                        <onTimeRate>' . htmlspecialchars($request->input('onTimeRate'), ENT_XML1, 'UTF-8') . '</onTimeRate>
                        <remark>' . htmlspecialchars($request->input('remark'), ENT_XML1, 'UTF-8') . '</remark>
                        <secureFlightDataRequired>' . htmlspecialchars($request->input('secureFlightDataRequired'), ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                        <segmentStatusByFirstLeg>' . htmlspecialchars($request->input('segmentStatusByFirstLeg'), ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                        <stopQuantity>' . htmlspecialchars($request->input('stopQuantity'), ENT_XML1, 'UTF-8') . '</stopQuantity>
                        <trafficRestriction>
                           <code/>
                           <explanation/>
                        </trafficRestriction>
                     </flightSegment>
                     <frequentFlyerRedemption/>
                     <bookingReferenceID>
                     <companyName>
                        <cityCode>LOS</cityCode>
                        <code>P4</code>
                        <codeContext>CRANE</codeContext>
                        <companyFullName>SCINTILLA</companyFullName>
                        <companyShortName>SCINTILLA</companyShortName>
                        <countryCode>NG</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($request->input('ID'), ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($request->input('referenceID'), ENT_XML1, 'UTF-8') . '</referenceID>
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