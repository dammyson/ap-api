<?php

namespace App\Services\Soap;

use App\Services\Utility\FlightNotes;

class GetAirExtraChargesAndProductBuilder {

	private function passengerTypeQuantityList($passengerList) {
		$xml = '';

		foreach($passengerList as $passenger) {
		  $xml .=	'<passengerTypeQuantityList>
						<hasStrecher/>
						<passengerType>
							<code>'. $passenger['passengerTypeCode'] .'</code>
						</passengerType>
						<quantity>'. $passenger['quantity'] .'</quantity>
					</passengerTypeQuantityList>';
		}
	}

	private function checkRemark($string) {
        if (isset($string['remark'])) {
            return  '<remark>' . htmlspecialchars($string['remark'], ENT_XML1, 'UTF-8') . '</remark>';
        }
    }


  	private function bookFlightSegmentList($bookFlightSegmentList)
    {
        //dd($CreateBookOriginDestinationOptionList[0]['flightSegmeneSequence'] );

        $xml = '';

        foreach ($bookFlightSegmentList as $string) {
            $xml .= '
                  <bookFlightSegmentList>
                        <addOnSegment/>
                        <bookingClass>
                           <cabin>' . htmlspecialchars($string["bookingClassCabin"], ENT_XML1, 'UTF-8') . '</cabin>
                           <resBookDesigCode>' . htmlspecialchars($string['bookingClassResBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                           <resBookDesigQuantity>' . htmlspecialchars($string['bookingClassResBookDesigQuantity'], ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                           <resBookDesigStatusCode>' . htmlspecialchars($string['bookingClassResBookDesigStatusCode']   , ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                        </bookingClass>
                        <fareInfo>
                           <cabin>' . htmlspecialchars($string['fareInfoCabin'], ENT_XML1, 'UTF-8') . '</cabin>
                           <cabinClassCode>' . htmlspecialchars($string['fareInfoCabinClassCode'], ENT_XML1, 'UTF-8') . '</cabinClassCode>
                           <fareBaggageAllowance>
                              <allowanceType>' . htmlspecialchars($string['fareBaggageAllowanceType'], ENT_XML1, 'UTF-8') . '</allowanceType>
                              <maxAllowedPieces>' . htmlspecialchars($string['fareBaggageMaxAllowedPieces'], ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                              <maxAllowedWeight>
                                 <unitOfMeasureCode>' . htmlspecialchars($string['unitOfMeasureCode'], ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                 <weight>' . htmlspecialchars($string['weight'], ENT_XML1, 'UTF-8') . '</weight>
                              </maxAllowedWeight>
                           </fareBaggageAllowance>
                           <fareGroupName>' . htmlspecialchars($string['fareGroupName'], ENT_XML1, 'UTF-8') . '</fareGroupName>
                           <fareReferenceCode>' . htmlspecialchars($string['fareReferenceCode'], ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                           <fareReferenceID>' . htmlspecialchars($string['fareReferenceID'], ENT_XML1, 'UTF-8') . '</fareReferenceID> 
                           <fareReferenceName>' . htmlspecialchars($string['fareReferenceName'], ENT_XML1, 'UTF-8') . '</fareReferenceName>
                           <flightSegmentSequence>' . htmlspecialchars($string['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                           <portTax>' . htmlspecialchars($string['portTax'], ENT_XML1, 'UTF-8') . '</portTax>
                           <resBookDesigCode>' . htmlspecialchars($string['resBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        </fareInfo>
                        <flightSegment>
                           <airline>
                              <code>P4</code>
                              <companyFullName>Air Peace</companyFullName>
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
                                    <locationNameLanguage>' . htmlspecialchars($string['arrivalAirportCountryLocationNameLangauge'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>' . htmlspecialchars($string['arrivalAirportCountryCurrencyCode'], ENT_XML1, 'UTF-8') . '</code>
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
                                    <locationCode>' . htmlspecialchars($string['departureAirportCitytLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($string['departureAirportCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($string['departureAirportCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                 </city>
                                 <country>
                                    <locationCode>' . htmlspecialchars($string['departureAirportCountrytLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($string['departureAirportCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($string['departureAirportCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                       <code>' . htmlspecialchars($string['departureAirportCountyCurrencyCode'], ENT_XML1, 'UTF-8') . '</code>
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
                           <codeshare>' . htmlspecialchars($string['codeShare'], ENT_XML1, 'UTF-8') . '</codeshare>
                           <distance>' . htmlspecialchars($string['distance'], ENT_XML1, 'UTF-8') . '</distance>
                           <equipment>
                              <airEquipType>' . htmlspecialchars($string['airEquipType'], ENT_XML1, 'UTF-8') . '</airEquipType>
                              <changeofGauge>' . htmlspecialchars($string['changeOfGuage'], ENT_XML1, 'UTF-8') . '</changeofGauge>   
                           </equipment>'. 
                              $this->flightNotes($string['flightNotes'])
                           .'                           
                           <flownMileageQty>' . htmlspecialchars($string['flownMileageQty'], ENT_XML1, 'UTF-8') . '</flownMileageQty>
                           <iatciFlight>' . htmlspecialchars($string['iatciFlight'], ENT_XML1, 'UTF-8') . '</iatciFlight>
                           <journeyDuration>' . htmlspecialchars($string['journeyDuration'], ENT_XML1, 'UTF-8') . '</journeyDuration>
                           <onTimeRate>' . htmlspecialchars($string['onTimeRate'], ENT_XML1, 'UTF-8') . '</onTimeRate>'. 
						   	$this->checkRemark($string)
						   .'
                           <secureFlightDataRequired>' . htmlspecialchars($string['secureFlightDataRequired'], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                           <stopQuantity>' . htmlspecialchars($string['stopQuantity'], ENT_XML1, 'UTF-8') . '</stopQuantity>
                           <ticketType>' . htmlspecialchars($string['ticketType'], ENT_XML1, 'UTF-8') . '</ticketType>
                        </flightSegment>
                        <involuntaryPermissionGiven/>
                        <sequenceNumber/>
                     </bookFlightSegmentList>
               ';
        }
        return $xml;
    }

    private function flightNotes( $flightNotes ) {
        return (new FlightNotes())->flightNotesArray($flightNotes);
    }
   
    public function getExtraChargesAndProduct(
		$preferredCurrency,
      	$bookFlightSegmentList,
		$locationCode,
		$passengerTypeQuantityList,        
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
					<preferredCurrency>'.$preferredCurrency .'</preferredCurrency>
				</clientInformation>'. 

                 	$this->bookFlightSegmentList($bookFlightSegmentList)
                 .'
                
                <journeyStartLocation>
                     <locationCode>' . htmlspecialchars($locationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                </journeyStartLocation>
                <frequentFlyerRedemption/>
                <travelerInformation>'. 
					$this->passengerTypeQuantityList($passengerTypeQuantityList)
				.'
                 	
                </travelerInformation>
				<tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
				</AirExtraChargesAndProductsRequest>
           </impl:GetAirExtraChargesAndProducts>
           </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }

	
   
   
   

}

























































































































































