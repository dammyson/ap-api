<?php

namespace App\Services\Soap;


class GetAvailabilityBuilder {
   public function getAvailabilityGeneralParameters() {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
               <soapenv:Header/>
               <soapenv:Body>
               <impl:GetAvailabilityGeneralParameters>
               <AvailabilityGeneralParametersRequest>
               <clientInformation>
               <clientIP>129.0.0.1</clientIP>
               <member>false</member>
               <password>SCINTILLA</password>
               <userName>SCINTILLA</userName>
               </clientInformation>
               </AvailabilityGeneralParametersRequest>
               </impl:GetAvailabilityGeneralParameters>
               </soapenv:Body>
            </soapenv:Envelope>';

      return $xml;
   }

    public function getAvailabilityRT(
        $originDateOffsetOne, 
        $originDepartureDateTimeOne, 
        $originDestinationLocationCode,
        $flexibleFaresOnlyOne,
        $includeInterlineFlightsOne, 
        $openFlightOne,
        $originLocationCodeOne, 
        $originDataOffsetTwo, 
        $originDepartureDateTimeTwo,
        $destinationLocationCodeTwo, 
        $flexibleFaresOnlyTwo, 
        $includeInterlineFlightsTwo,
        $openFlightTwo, 
        $originLocationCodeTwo, 
        $travelerInformationCode, 
        $travelerQuantity,
        $tripType

    ) {
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
                          <dateOffset>' . htmlspecialchars($originDateOffsetOne, ENT_XML1, 'UTF-8') . '</dateOffset>
                          <departureDateTime>' . htmlspecialchars($originDepartureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                          <destinationLocation>
                             <locationCode>' . htmlspecialchars($originDestinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </destinationLocation>
                          <flexibleFaresOnly>' . htmlspecialchars($flexibleFaresOnlyOne, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                          <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlightsOne, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                          <openFlight>' . htmlspecialchars($openFlightOne, ENT_XML1, 'UTF-8') . '</openFlight>
                          <originLocation>
                             <locationCode>' . htmlspecialchars($originLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                          </originLocation>
                       </originDestinationInformationList>
                       <originDestinationInformationList>
                          <dateOffset>' . htmlspecialchars($originDataOffsetTwo, ENT_XML1, 'UTF-8') . '</dateOffset>
                          <departureDateTime>' . htmlspecialchars($originDepartureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                          <destinationLocation>
                             <locationCode>' . htmlspecialchars($destinationLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          </destinationLocation>
                          <flexibleFaresOnly>' . htmlspecialchars($flexibleFaresOnlyTwo, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                          <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlightsTwo, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                          <openFlight>' . htmlspecialchars($openFlightTwo, ENT_XML1, 'UTF-8') . '</openFlight>
                          <originLocation>
                             <locationCode>' . htmlspecialchars($originLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                          </originLocation>
                       </originDestinationInformationList>
                       <travelerInformation>
                          <passengerTypeQuantityList>
                          <hasStrecher/>
                          <passengerType>
                          <code>' . htmlspecialchars($travelerInformationCode, ENT_XML1, 'UTF-8') . '</code>
                          </passengerType>
                          <quantity>' . htmlspecialchars($travelerQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                          </passengerTypeQuantityList>
                       </travelerInformation>
                       <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                    </AirAvailabilityRequest>
                    </impl:GetAvailability>
                 <impl:GetAirAvailability/>
              </soapenv:Body>
           </soapenv:Envelope>';
        return $xml;
    }

    public function getAvailabilityOW(
        $originDateOffset, 
        $departureDateTime, 
        $destinationLocationCode,
        $flexibleFareOnly, 
        $includeInterlineFlights, 
        $openFlight,
        $originLocationCode, 
        $passengerTypeCode, 
        $passengerQuantity, 
        $tripType
    ) {
        $xml ='<?xml version="1.0" encoding="UTF-8"?>
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
                       <dateOffset>' . htmlspecialchars($originDateOffset, ENT_XML1, 'UTF-8') . '</dateOffset>
                       <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                       <destinationLocation>
                          <locationCode>' . htmlspecialchars($destinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                       </destinationLocation>
                       <flexibleFaresOnly>' . htmlspecialchars($flexibleFareOnly, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                       <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlights, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                       <openFlight>' . htmlspecialchars($openFlight, ENT_XML1, 'UTF-8') . '</openFlight>
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
                    <quantity>' . htmlspecialchars($passengerQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                    </passengerTypeQuantityList>
                    </travelerInformation>
                    <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                 </AirAvailabilityRequest>
              </impl:GetAvailability>
              <impl:GetAirAvailability/>
           </soapenv:Body>
        </soapenv:Envelope>';
        return $xml;
    }

    public function getAvailabilityMD(
        $originDataOffsetOne, 
        $departureDateTimeOne,
        $destinationLocationCodeOne,
        $flexibleFareOnlyOne, 
        $includeInterlineFlightsOne, 
        $openFlightOne,
        $originLocationCodeOne, 
        $originDataOffsetTwo, 
        $departureDateTimeTwo, 
        $destinationLocationCodeTwo,
        $flexibleFareOnlyTwo, 
        $includeInterlineFlightsTwo, 
        $openFlightTwo,
        $originLocationCodeTwo, 
        $passengerTypeCode, 
        $passengerQuantity,
        $tripType
    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
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
                       <dateOffset>' . htmlspecialchars($originDataOffsetOne, ENT_XML1, 'UTF-8') . '</dateOffset>
                       <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '/departureDateTime>
                       <destinationLocation>
                          <locationCode>' . htmlspecialchars($destinationLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                       </destinationLocation>
                       <flexibleFaresOnly>' . htmlspecialchars($flexibleFareOnlyOne, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                       <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlightsOne, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                       <openFlight>' . htmlspecialchars($openFlightOne, ENT_XML1, 'UTF-8') . '</openFlight>
                       <originLocation>
                          <locationCode>' . htmlspecialchars($originLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                       </originLocation>
                    </originDestinationInformationList>
                    <originDestinationInformationList>
                       <dateOffset>' . htmlspecialchars($originDataOffsetTwo, ENT_XML1, 'UTF-8') . '</dateOffset>
                       <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                       <destinationLocation>
                          <locationCode>' . htmlspecialchars($destinationLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                       </destinationLocation>
                       <flexibleFaresOnly>' . htmlspecialchars($flexibleFareOnlyTwo, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                       <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlightsTwo, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                       <openFlight>' . htmlspecialchars($openFlightTwo, ENT_XML1, 'UTF-8') . '</openFlight>
                       <originLocation>
                          <locationCode>' . htmlspecialchars($originLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                       </originLocation>
                    </originDestinationInformationList>
                    <travelerInformation>
                       <passengerTypeQuantityList>
                       <hasStrecher/>
                       <passengerType>
                          <code>' . htmlspecialchars($passengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                       </passengerType> 
                       <quantity>' . htmlspecialchars($passengerQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                       </passengerTypeQuantityList>
                    </travelerInformation>
                    <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                 </AirAvailabilityRequest>
              </impl:GetAvailability>
              <impl:GetAirAvailability/>
           </soapenv:Body>
           </soapenv:Envelope>';
        return $xml;
    }

    public function getAvailabilityTwoA(
        $dataOffset, 
        $departureDateTime, 
        $destinationLocationCode, 
        $flexibleFareOnly, 
        $includeInterlineFlights, 
        $openFlight, 
        $originLocationCode, 
        $adultPassengerTypeCode, 
        $adultQuantity,
        $childPassengerTypeCode, 
        $childQuantity, 
        $infantPassengerTypeCode,
        $infantQuantity, 
        $tripType
    ) {
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
                          <dateOffset>' . htmlspecialchars($dataOffset, ENT_XML1, 'UTF-8') . '</dateOffset>
                          <departureDateTime>' . htmlspecialchars($departureDateTime, ENT_XML1, 'UTF-8') . '</departureDateTime>
                          <destinationLocation>
                             <locationCode>' . htmlspecialchars($destinationLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </destinationLocation>
                          <flexibleFaresOnly>' . htmlspecialchars($flexibleFareOnly, ENT_XML1, 'UTF-8') . '</flexibleFaresOnly>
                          <includeInterlineFlights>' . htmlspecialchars($includeInterlineFlights, ENT_XML1, 'UTF-8') . '</includeInterlineFlights>
                          <openFlight>' . htmlspecialchars($openFlight, ENT_XML1, 'UTF-8') . '</openFlight>
                          <originLocation>
                             <locationCode>' . htmlspecialchars($originLocationCode, ENT_XML1, 'UTF-8') . '</locationCode>
                          </originLocation>
                       </originDestinationInformationList>
                       <travelerInformation>
                          <passengerTypeQuantityList>
                             <hasStrecher/>
                             <passengerType>
                                <code>' . htmlspecialchars($adultPassengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                             </passengerType>
                             <quantity>' . htmlspecialchars($adultQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                          </passengerTypeQuantityList>
                          <passengerTypeQuantityList>
                             <hasStrecher/>
                             <passengerType>
                             <code>' . htmlspecialchars($childPassengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                             </passengerType>
                             <quantity>' . htmlspecialchars($childQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                          </passengerTypeQuantityList>
                          <passengerTypeQuantityList>
                          <hasStrecher/>
                          <passengerType>
                          <code>' . htmlspecialchars($infantPassengerTypeCode, ENT_XML1, 'UTF-8') . '</code>
                          </passengerType>
                          <quantity>' . htmlspecialchars($infantQuantity, ENT_XML1, 'UTF-8') . '</quantity>
                          </passengerTypeQuantityList>
                       </travelerInformation>
                       <tripType>' . htmlspecialchars($tripType, ENT_XML1, 'UTF-8') . '</tripType>
                    </AirAvailabilityRequest>
                 </impl:GetAvailability>
                 <impl:GetAirAvailability/>
              </soapenv:Body>
           </soapenv:Envelope>
        ';
        return $xml;
    }
  
}