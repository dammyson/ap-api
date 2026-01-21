<?php

namespace App\Services\Soap;

class SoapRequestBuilder
{
   public function GetFlightOneWay($preferredCurrency, $departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType)
   {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
                   <soapenv:Header/>
                   <soapenv:Body>
                      <impl:GetAvailability>
                         <AirAvailabilityRequest>
                            <clientInformation>
                                <clientIP>129.0.0.1</clientIP>
                                <member>false</member>
                                <password>SCINTILLA</password>
                                <userName>SCINTILLA</userName>
                                <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>
                            </clientInformation>
                            <originDestinationInformationList>
                               <dateOffset>0</dateOffset>
                               <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                               <destinationLocation>
                                  <locationCode>' . htmlspecialchars($destinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                               </destinationLocation>
                               <flexibleFaresOnly>false</flexibleFaresOnly>
                               <includeInterlineFlights>false</includeInterlineFlights>
                               <openFlight>false</openFlight>
                               <originLocation>
                                  <locationCode>' . htmlspecialchars($originLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                               </originLocation>
                            </originDestinationInformationList>
                            <travelerInformation>' .
                              $this->passengerTypeQuantityList($travelerInformation)
                           . '</travelerInformation>
                            <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                         </AirAvailabilityRequest>
                      </impl:GetAvailability>
                   </soapenv:Body>
                </soapenv:Envelope>';

      return $xml;
   }

   public function GetFlightRoundTrip($preferredCurrency, $departureDateTime, $destinationLocationCode, $originLocationCode, $travelerInformation, $tripType, $returnDateTime,)
   {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
              <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
              <soapenv:Header/>
              <soapenv:Body>
                 <impl:GetAvailability>
                    <AirAvailabilityRequest>
                       <clientInformation>
                          <clientIP>129.0.0.1</clientIP>
                          <member>false</member>
                          <password>SCINTILLA</password>
                          <userName>SCINTILLA</userName>
                          <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>
                       </clientInformation>
                       <originDestinationInformationList>
                          <dateOffset>0</dateOffset>
                          <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                          <destinationLocation>
                           <locationCode>' . htmlspecialchars($destinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </destinationLocation>
                          <flexibleFaresOnly>false</flexibleFaresOnly>
                          <includeInterlineFlights>false</includeInterlineFlights>
                          <openFlight>false</openFlight>
                          <originLocation>
                          <locationCode>' . htmlspecialchars($originLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </originLocation>
                       </originDestinationInformationList>
                       <originDestinationInformationList>
                          <dateOffset>0</dateOffset>
                           <departureDateTime>' . htmlspecialchars($returnDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                          <destinationLocation>
                          <locationCode>' . htmlspecialchars($originLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </destinationLocation>
                          <flexibleFaresOnly>false</flexibleFaresOnly>
                          <includeInterlineFlights>false</includeInterlineFlights>
                          <openFlight>false</openFlight>
                          <originLocation>
                          <locationCode>' . htmlspecialchars($destinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </originLocation>
                       </originDestinationInformationList>
                        <travelerInformation>' .
         $this->passengerTypeQuantityList($travelerInformation)
         . '</travelerInformation>
                       <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                    </AirAvailabilityRequest>
                 </impl:GetAvailability>
              <impl:GetAirAvailability/></soapenv:Body>
           </soapenv:Envelope>';

      return $xml;
   }


   public function GetFlightMultiCity($preferredCurrency, $multiDirectionalFlights, $travelerInformation, $tripType)
   {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
                   <soapenv:Header/>
                   <soapenv:Body>
                      <impl:GetAvailability>
                         <AirAvailabilityRequest>
                            <clientInformation>
                                <clientIP>129.0.0.1</clientIP>
                                <member>false</member>
                                <password>SCINTILLA</password>
                                <userName>SCINTILLA</userName>
                                <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>
                            </clientInformation>' .
                            $this->originDestinationInformationList($multiDirectionalFlights)
                           .' <travelerInformation>' .
                           $this->passengerTypeQuantityList($travelerInformation)
                           . '</travelerInformation>
                            <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                         </AirAvailabilityRequest>
                      </impl:GetAvailability>
                   </soapenv:Body>
                </soapenv:Envelope>';

      return $xml;
   }

   public function passengerTypeQuantityList(
      $travelerInformation
   ) {
      $xml = '';

      foreach ($travelerInformation as $string) {
         $xml .= '
               <passengerTypeQuantityList>
                  <hasStrecher/>
                  <passengerType>
                     <code>' . htmlspecialchars($string['passenger_type'], ENT_XML1, 'UTF-8') . '</code>
                  </passengerType>
                  <quantity>' . htmlspecialchars($string['passengers'], ENT_XML1, 'UTF-8') . '</quantity>
               </passengerTypeQuantityList>';
      }

      return $xml;
   }




   public function originDestinationInformationList(
      $multiDirectionalFlights
   ) {
      $xml = '';
      for ($i = 0; $i < count($multiDirectionalFlights); $i++) {
         $xml .= '
               <originDestinationInformationList>
                  <dateOffset>0</dateOffset>
                      <departureDateTime>' . htmlspecialchars($multiDirectionalFlights[$i]["departure_date"], ENT_XML1, 'UTF-8') . '</departureDateTime>
                     <destinationLocation>
                     <locationCode>' . htmlspecialchars($multiDirectionalFlights[$i]["arrival_airport"], ENT_XML1, 'UTF-8') . '</locationCode>
                     </destinationLocation>
                     <flexibleFaresOnly>false</flexibleFaresOnly>
                     <includeInterlineFlights>false</includeInterlineFlights>
                      <openFlight>false</openFlight>
                     <originLocation>
                     <locationCode>' . htmlspecialchars($multiDirectionalFlights[$i]["departure_airport"], ENT_XML1, 'UTF-8') . '</locationCode>
                   </originLocation>
               </originDestinationInformationList>';
      }

      return $xml;
   }
}
