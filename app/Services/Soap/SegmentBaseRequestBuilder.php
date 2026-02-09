<?php

namespace App\Services\Soap;

use App\Services\Utility\FlightNotes;

class SegmentBaseRequestBuilder {

	protected $craneUsername;
	protected $cranePassword;

	public function __construct() {
			$this->craneUsername = config('app.crane.username');		
			$this->cranePassword = config('app.crane.password');
	}
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
                        <password>' . htmlspecialchars( $this->cranePassword, ENT_XML1, 'UTF-8') . '</password>
                        <userName>' . htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') . '</userName>
                        <preferredCurrency>NGN</preferredCurrency>
                     </clientInformation>
                     <!-- Zero or more repetitions: -->
                     '.
                        $this->bookFlightSegmentList($request->input('bookingFlightSegmentList'))
                     .'
                     <frequentFlyerRedemption/>
                     <ssrGroupCode>' . htmlspecialchars($request->input('ssrGroupCode'), ENT_XML1, 'UTF-8') . '</ssrGroupCode>
                  </SegmentBaseAvailableSpecialServicesRequest>
               </impl:SegmentBaseAvailableSpecialServices>
            </soapenv:Body>
         </soapenv:Envelope>
      ';
      return $xml;
   }

   private function bookFlightSegmentList($bookingFlightSegmentList) {
		$xml = '';

		foreach($bookingFlightSegmentList as $bookingFlightSegment) {
			$xml .= '
				<bookFlightSegmentList>
					<addOnSegment/>
					<bookingClass>
						<cabin>' . htmlspecialchars($bookingFlightSegment['bookingClassCabin'], ENT_XML1, 'UTF-8') . '</cabin>
						<resBookDesigCode>' . htmlspecialchars($bookingFlightSegment['bookingResBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
						<resBookDesigQuantity>' . htmlspecialchars($bookingFlightSegment['bookingClassResBookDesigQuantity'], ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
						<resBookDesigStatusCode>' . htmlspecialchars($bookingFlightSegment["bookingClassResBookDesigStatusCode"], ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
					</bookingClass>
					<!-- Optional: -->
					<fareInfo>
						<cabin>' . htmlspecialchars($bookingFlightSegment['fareInfoCabin'], ENT_XML1, 'UTF-8') . '</cabin>
						<cabinClassCode>' . htmlspecialchars($bookingFlightSegment['fareInfoCabinClassCode'], ENT_XML1, 'UTF-8') . '</cabinClassCode>
						<fareBaggageAllowance>
							<allowanceType>' . htmlspecialchars($bookingFlightSegment['fareBaggageAllowanceType'], ENT_XML1, 'UTF-8') . '</allowanceType>
							<maxAllowedPieces>' . htmlspecialchars($bookingFlightSegment['fareBaggageMaxAllowedPieces'], ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
							<maxAllowedWeight>
							<unitOfMeasureCode>' . htmlspecialchars($bookingFlightSegment["unitOfMeasureCode"], ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
							<weight>' . htmlspecialchars($bookingFlightSegment['weight'], ENT_XML1, 'UTF-8') . '</weight>
							</maxAllowedWeight>
						</fareBaggageAllowance>
						<fareGroupName>' . htmlspecialchars($bookingFlightSegment['fareGroupName'], ENT_XML1, 'UTF-8') . '</fareGroupName>
						<fareReferenceCode>' . htmlspecialchars($bookingFlightSegment['fareReferenceCode'], ENT_XML1, 'UTF-8') . '</fareReferenceCode>
						<fareReferenceID>' . htmlspecialchars($bookingFlightSegment['fareReferenceID'], ENT_XML1, 'UTF-8') . '</fareReferenceID>
						<fareReferenceName>' . htmlspecialchars($bookingFlightSegment['fareReferenceName'], ENT_XML1, 'UTF-8') . '</fareReferenceName>
						<flightSegmentSequence>' . htmlspecialchars($bookingFlightSegment['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
						<portTax>' . htmlspecialchars($bookingFlightSegment['portTax'], ENT_XML1, 'UTF-8') . '</portTax>
						<resBookDesigCode>' . htmlspecialchars($bookingFlightSegment['resBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
					</fareInfo>
					<!-- Optional: -->
					<flightSegment>
						<airline>
							<code>' . htmlspecialchars($bookingFlightSegment['airlineCode'], ENT_XML1, 'UTF-8') . '</code>
							<companyFullName>' . htmlspecialchars($bookingFlightSegment['airlineCompanyFullName'], ENT_XML1, 'UTF-8') . '</companyFullName>
						</airline>
						<arrivalAirport>
							<cityInfo>
							<city>
								<locationCode>' . htmlspecialchars($bookingFlightSegment['arrivalCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
								<locationName>' . htmlspecialchars($bookingFlightSegment['arrivalCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
								<locationNameLanguage>' . htmlspecialchars($bookingFlightSegment['arrivalCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
							</city>
							<country>
								<locationCode>' . htmlspecialchars($bookingFlightSegment['arrivalCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
								<locationName>' . htmlspecialchars($bookingFlightSegment['arrivalCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
								<locationNameLanguage>' . htmlspecialchars($bookingFlightSegment['arrivalCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
								<currency>
									<code>' . htmlspecialchars($bookingFlightSegment['arrivalCountryCurrencyCode'], ENT_XML1, 'UTF-8') . '</code>
								</currency>
							</country>
							</cityInfo>
							<codeContext>' . htmlspecialchars($bookingFlightSegment['arrivalCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
							<language>' . htmlspecialchars($bookingFlightSegment['arrivalLanguage'], ENT_XML1, 'UTF-8') . '</language>
							<locationCode>' . htmlspecialchars($bookingFlightSegment['arrivalLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
							<locationName>' . htmlspecialchars($bookingFlightSegment['arrivalLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
							<timeZoneInfo>' . htmlspecialchars($bookingFlightSegment['arrivalTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
						</arrivalAirport>
						<arrivalDateTime>' . htmlspecialchars($bookingFlightSegment['arrivalDateTime'], ENT_XML1, 'UTF-8') . '</arrivalDateTime>
						<arrivalDateTimeUTC>' . htmlspecialchars($bookingFlightSegment['arrivalDateTimeUTC'], ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
						<departureAirport>
							<cityInfo>
							<city>
								<locationCode>' . htmlspecialchars($bookingFlightSegment['departureCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
								<locationName>' . htmlspecialchars($bookingFlightSegment['departureCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
								<locationNameLanguage>' . htmlspecialchars($bookingFlightSegment['departureCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
							</city>
							<country>
								<locationCode>' . htmlspecialchars($bookingFlightSegment['departureCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
								<locationName>' . htmlspecialchars($bookingFlightSegment['departureCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
								<locationNameLanguage>' . htmlspecialchars($bookingFlightSegment['departureCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
								<currency>
									<code>NG' . htmlspecialchars($bookingFlightSegment['departureCountryCurrencyCode'], ENT_XML1, 'UTF-8') . 'N</code>
								</currency>
							</country>
							</cityInfo>
							<codeContext>' . htmlspecialchars($bookingFlightSegment['departureAirportCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
							<language>' . htmlspecialchars($bookingFlightSegment['departureAirportLanguage'], ENT_XML1, 'UTF-8') . '</language>
							<locationCode>' . htmlspecialchars($bookingFlightSegment['departureAirportLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
							<locationName>' . htmlspecialchars($bookingFlightSegment['departureAirportLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
							<timeZoneInfo>' . htmlspecialchars($bookingFlightSegment['departureAirportTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
						</departureAirport>
						<departureDateTime>' . htmlspecialchars($bookingFlightSegment["departureDateTime"], ENT_XML1, 'UTF-8') . '</departureDateTime>
						<departureDateTimeUTC>' . htmlspecialchars($bookingFlightSegment['departureDateTimeUTC'], ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
						<flightNumber>' . htmlspecialchars($bookingFlightSegment['flightNumber'], ENT_XML1, 'UTF-8') . '</flightNumber>
						<flightSegmentID>' . htmlspecialchars($bookingFlightSegment['flightSegmentID'], ENT_XML1, 'UTF-8') . '</flightSegmentID>
						<ondControlled>' . htmlspecialchars($bookingFlightSegment['ondControlled'], ENT_XML1, 'UTF-8') . '</ondControlled>
						<sector>' . htmlspecialchars($bookingFlightSegment["sector"], ENT_XML1, 'UTF-8') . '</sector>
						<codeshare>' . htmlspecialchars($bookingFlightSegment['codeShare'], ENT_XML1, 'UTF-8') . '</codeshare>
						<distance>' . htmlspecialchars($bookingFlightSegment['distance'], ENT_XML1, 'UTF-8') . '</distance>
						<equipment>
							<airEquipType>' . htmlspecialchars($bookingFlightSegment['airEquipType'], ENT_XML1, 'UTF-8') . '</airEquipType>
							<changeofGauge>' . htmlspecialchars($bookingFlightSegment['changeOfGauge'], ENT_XML1, 'UTF-8') . '</changeofGauge>
						</equipment>'.
					
						$this->flightNotes($bookingFlightSegment['flightNotes'])
				
						.'
						<flownMileageQty>' . htmlspecialchars($bookingFlightSegment['flownMileageQty'], ENT_XML1, 'UTF-8') . '</flownMileageQty>
						<iatciFlight>' . htmlspecialchars($bookingFlightSegment['iatciFlight'], ENT_XML1, 'UTF-8') . '</iatciFlight>
						<journeyDuration>' . htmlspecialchars($bookingFlightSegment['journeyDuration'], ENT_XML1, 'UTF-8') . '</journeyDuration>
						<onTimeRate>' . htmlspecialchars($bookingFlightSegment['onTimeRate'], ENT_XML1, 'UTF-8') . '</onTimeRate>
						<remark>' . htmlspecialchars($bookingFlightSegment['remark'], ENT_XML1, 'UTF-8') . '</remark>
						<secureFlightDataRequired>' . htmlspecialchars($bookingFlightSegment['secureFlightDataRequired'], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
						<stopQuantity>' . htmlspecialchars($bookingFlightSegment['stopQuantity'], ENT_XML1, 'UTF-8') . '</stopQuantity>
						<ticketType>' . htmlspecialchars($bookingFlightSegment['ticketType'], ENT_XML1, 'UTF-8') . '</ticketType>
					</flightSegment>
					<involuntaryPermissionGiven/>
					<sequenceNumber/>
               
            	</bookFlightSegmentList>';
      		}
      		return $xml;
   }

	private function flightNotes( $flightNotes ) {
		return (new FlightNotes())->flightNotesArray($flightNotes);
   	}
}