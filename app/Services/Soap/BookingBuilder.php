<?php

namespace App\Services\Soap;

class BookingBuilder {
   protected $craneUsername;
   protected $cranePassword;

   public function __construct() {
		$this->craneUsername = config('app.crane.username');		
		$this->cranePassword = config('app.crane.password');
	}

    public function readBooking($ID, $passengerSurname) {
       $xml =  '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
           <soapenv:Body>
              <impl:ReadBooking>
                 <AirBookingReadRequest>
                    <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>' . $this->cranePassword . '</password>
                    <userName>' . $this->craneUsername . '</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                    </clientInformation>
                    <bookingReferenceID>
                       <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                    </bookingReferenceID>
                    <passenger>
                       <shareMarketInd/>
                       <surname>' . htmlspecialchars($passengerSurname, ENT_XML1, 'UTF-8') . '</surname>
                    </passenger>
                 </AirBookingReadRequest>
              </impl:ReadBooking>
           </soapenv:Body>
           </soapenv:Envelope>';
        return $xml;
    }

    public function readBookingTK(
        $ID, 
        $referenceID
    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
              <soapenv:Body>
              <impl:ReadBooking>
                 <AirBookingReadRequest>
                    <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>'. $this->cranePassword .'</password>
                    <userName>'. $this->craneUsername .'</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                    </clientInformation>
                    <bookingReferenceID>
                       <companyName>
                          <cityCode>LOS</cityCode>
                          <code>P4</code>
                          <codeContext>CRANE</codeContext>
                          <companyFullName>SCINTILLA</companyFullName>
                          <companyShortName>SCINTILLA</companyShortName>
                          <countryCode>NG</countryCode>
                       </companyName>
                       <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                       <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                 </AirBookingReadRequest>
              </impl:ReadBooking>
           </soapenv:Body>
           </soapenv:Envelope>
        ';
        return $xml;
      }

    
    public function RetrieveTicketHistory($bookingReferenceID) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <impl:GetTicketHistory>
                <!-- Optional: -->
                <TicketHistoryRequest>
                  <clientInformation>
                     <clientIP>129.0.0.1</clientIP>
                     <member>false</member>
                     <password>'. $this->cranePassword .'</password>
                     <userName>'. $this->craneUsername .'</userName>
                     <preferredCurrency>NGN</preferredCurrency>
                  </clientInformation>
                    <bookingReferenceId>' . htmlspecialchars($bookingReferenceID, ENT_XML1, 'UTF-8') . '</bookingReferenceId>
                </TicketHistoryRequest>
                </impl:GetTicketHistory>
            </soapenv:Body>
            </soapenv:Envelope>';
        return $xml;
    }

    public function retrievePNRHistory($ID) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
            <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
                <soapenv:Body>
                    <impl:GetAirBookingHistory>
                        <!-- Optional: -->
                        <AirBookingHistoryRequest>
                        <!-- Optional: -->
                        <clientInformation>
                        <clientIP>129.0.0.1</clientIP>
                        <member>false</member>
                        <password>'. $this->cranePassword .'</password>
                        <userName>'. $this->craneUsername .'</userName>
                        <preferredCurrency>NGN</preferredCurrency>
                        </clientInformation>
                        <!-- Optional: -->
                        <bookingReferenceID>
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        </bookingReferenceID>
                        </AirBookingHistoryRequest>
                    </impl:GetAirBookingHistory>
            </soapenv:Body>
            </soapenv:Envelope>';
        return $xml;
    }
}