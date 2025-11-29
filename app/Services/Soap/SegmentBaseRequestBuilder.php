<?php

namespace App\Services\Soap;

use App\Services\Utility\FlightNotes;

class SegmentBaseRequestBuilder {
   public function segmentBaseAvailableSpecialServices(
     $request
   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
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
                           <cabin>' . htmlspecialchars($request->input('bookingClassCabin'), ENT_XML1, 'UTF-8') . '</cabin>
                           <resBookDesigCode>' . htmlspecialchars($request->input('bookingResBookDesigCode'), ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                           <resBookDesigQuantity>' . htmlspecialchars($request->input('bookingClassResBookDesigQuantity'), ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                           <resBookDesigStatusCode>' . htmlspecialchars($request->input("bookingClassResBookDesigStatusCode"), ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                        </bookingClass>
                        <!-- Optional: -->
                        <fareInfo>
                           <cabin>' . htmlspecialchars($request->input('fareInfoCabin'), ENT_XML1, 'UTF-8') . '</cabin>
                           <cabinClassCode>' . htmlspecialchars($request->input('fareInfoCabinClassCode'), ENT_XML1, 'UTF-8') . '</cabinClassCode>
                           <fareBaggageAllowance>
                              <allowanceType>' . htmlspecialchars($request->input('fareBaggageAllowanceType'), ENT_XML1, 'UTF-8') . '</allowanceType>
                              <maxAllowedPieces>' . htmlspecialchars($request->input('fareBaggageMaxAllowedPieces'), ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                              <maxAllowedWeight>
                                 <unitOfMeasureCode>' . htmlspecialchars($request->input("unitOfMeasureCode"), ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                 <weight>' . htmlspecialchars($request->input('weight'), ENT_XML1, 'UTF-8') . '</weight>
                              </maxAllowedWeight>
                           </fareBaggageAllowance>
                           <fareGroupName>' . htmlspecialchars($request->input('fareGroupName'), ENT_XML1, 'UTF-8') . '</fareGroupName>
                           <fareReferenceCode>' . htmlspecialchars($request->input('fareReferenceCode'), ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                           <fareReferenceID>' . htmlspecialchars($request->input('fareReferenceID'), ENT_XML1, 'UTF-8') . '</fareReferenceID>
                           <fareReferenceName>' . htmlspecialchars($request->input('fareReferenceName'), ENT_XML1, 'UTF-8') . '</fareReferenceName>
                           <flightSegmentSequence>' . htmlspecialchars($request->input('flightSegmentSequence'), ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                           <portTax>' . htmlspecialchars($request->input('portTax'), ENT_XML1, 'UTF-8') . '</portTax>
                           <resBookDesigCode>' . htmlspecialchars($request->input('resBookDesigCode'), ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        </fareInfo>
                        <!-- Optional: -->
                        <flightSegment>
                           <airline>
                              <code>' . htmlspecialchars($request->input('airlineCode'), ENT_XML1, 'UTF-8') . '</code>
                              <companyFullName>' . htmlspecialchars($request->input('airlineCompanyFullName'), ENT_XML1, 'UTF-8') . '</companyFullName>
                           </airline>
                           <arrivalAirport>
                              <cityInfo>
                                 <city>
                                    <locationCode>' . htmlspecialchars($request->input('arrivalCityLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('arrivalCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('arrivalCityLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($request->input('arrivalCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('arrivalCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('arrivalCountryLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>' . htmlspecialchars($request->input('arrivalCountryCurrencyCode'), ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                 </country>
                              </cityInfo>
                              <codeContext>' . htmlspecialchars($request->input('arrivalCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                              <language>' . htmlspecialchars($request->input('arrivalLanguage'), ENT_XML1, 'UTF-8') . '</language>
                              <locationCode>' . htmlspecialchars($request->input('arrivalLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($request->input('arrivalLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                              <timeZoneInfo>' . htmlspecialchars($request->input('arrivalTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                           </arrivalAirport>
                           <arrivalDateTime>' . htmlspecialchars($request->input('arrivalDateTime'), ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                           <arrivalDateTimeUTC>' . htmlspecialchars($request->input('arrivalDateTimeUTC'), ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                           <departureAirport>
                              <cityInfo>
                                 <city>
                                    <locationCode>' . htmlspecialchars($request->input('departureCityLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('departureCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('departureCityLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($request->input('departureCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($request->input('departureCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($request->input('departureCountryLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>NG' . htmlspecialchars($request->input('departureCountryCurrencyCode'), ENT_XML1, 'UTF-8') . 'N</code>
                                    </currency>
                                 </country>
                              </cityInfo>
                              <codeContext>' . htmlspecialchars($request->input('departureAirportCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                              <language>' . htmlspecialchars($request->input('departureAirportLanguage'), ENT_XML1, 'UTF-8') . '</language>
                              <locationCode>' . htmlspecialchars($request->input('departureAirportLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($request->input('departureAirportLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                              <timeZoneInfo>' . htmlspecialchars($request->input('departureAirportTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                           </departureAirport>
                           <departureDateTime>' . htmlspecialchars($request->input("departureDateTime"), ENT_XML1, 'UTF-8') . '</departureDateTime>
                           <departureDateTimeUTC>' . htmlspecialchars($request->input('departureDateTimeUTC'), ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                           <flightNumber>' . htmlspecialchars($request->input('flightNumber'), ENT_XML1, 'UTF-8') . '</flightNumber>
                           <flightSegmentID>' . htmlspecialchars($request->input('flightSegmentID'), ENT_XML1, 'UTF-8') . '</flightSegmentID>
                           <ondControlled>' . htmlspecialchars($request->input('ondControlled'), ENT_XML1, 'UTF-8') . '</ondControlled>
                           <sector>' . htmlspecialchars($request->input("sector"), ENT_XML1, 'UTF-8') . '</sector>
                           <codeshare>' . htmlspecialchars($request->input('codeShare'), ENT_XML1, 'UTF-8') . '</codeshare>
                           <distance>' . htmlspecialchars($request->input('distance'), ENT_XML1, 'UTF-8') . '</distance>
                           <equipment>
                              <airEquipType>' . htmlspecialchars($request->input('airEquipType'), ENT_XML1, 'UTF-8') . '</airEquipType>
                              <changeofGauge>' . htmlspecialchars($request->input('changeOfGauge'), ENT_XML1, 'UTF-8') . '</changeofGauge>
                           </equipment>'.
                        
                           $this->flightNotes($request->input('flightNotes'))
                    
                           .'
                           <flownMileageQty>' . htmlspecialchars($request->input('flownMileageQty'), ENT_XML1, 'UTF-8') . '</flownMileageQty>
                           <iatciFlight>' . htmlspecialchars($request->input('iatciFlight'), ENT_XML1, 'UTF-8') . '</iatciFlight>
                           <journeyDuration>' . htmlspecialchars($request->input('journeyDuration'), ENT_XML1, 'UTF-8') . '</journeyDuration>
                           <onTimeRate>' . htmlspecialchars($request->input('onTimeRate'), ENT_XML1, 'UTF-8') . '</onTimeRate>
                           <remark>' . htmlspecialchars($request->input('remark'), ENT_XML1, 'UTF-8') . '</remark>
                           <secureFlightDataRequired>' . htmlspecialchars($request->input('secureFlightDataRequired'), ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                           <stopQuantity>' . htmlspecialchars($request->input('stopQuantity'), ENT_XML1, 'UTF-8') . '</stopQuantity>
                           <ticketType>' . htmlspecialchars($request->input('ticketType'), ENT_XML1, 'UTF-8') . '</ticketType>
                        </flightSegment>
                        <involuntaryPermissionGiven/>
                        <sequenceNumber/>
                     </bookFlightSegmentList>
                     <frequentFlyerRedemption/>
                     <ssrGroupCode>' . htmlspecialchars($request->input('ssrGroupCode'), ENT_XML1, 'UTF-8') . '</ssrGroupCode>
                  </SegmentBaseAvailableSpecialServicesRequest>
               </impl:SegmentBaseAvailableSpecialServices>
            </soapenv:Body>
         </soapenv:Envelope>
      ';
      return $xml;
   	}

	private function flightNotes( $flightNotes ) {
		return (new FlightNotes())->flightNotesArray($flightNotes);
   	}
}