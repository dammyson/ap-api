<?php

namespace App\Services\Soap;

class SoapRequestBuilder
{
   public function GetFlightOneWay($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType)
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
                                <preferredCurrency>NGN</preferredCurrency>
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
                         </AirAvailabilityRequest>
                      </impl:GetAvailability>
                   </soapenv:Body>
                </soapenv:Envelope>';

      return $xml;
   }

   public function GetFlightRoundTrip($departureDateTime, $destinationLocationCode, $originLocationCode, $passengerTypeCode, $quantity, $tripType, $returnDateTime,)
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
                          <preferredCurrency>NGN</preferredCurrency>
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
                    </AirAvailabilityRequest>
                 </impl:GetAvailability>
              <impl:GetAirAvailability/></soapenv:Body>
           </soapenv:Envelope>';

      return $xml;
   }
}

