<?php

namespace App\Services\Soap;

class BookingBuilder {

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
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
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
        $companyCityCode, 
        $companyCode, 
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
              <impl:ReadBooking>
                 <AirBookingReadRequest>
                    <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                    </clientInformation>
                    <bookingReferenceID>
                       <companyName>
                          <cityCode>' . htmlspecialchars($companyCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                          <code>' . htmlspecialchars($companyCode, ENT_XML1, 'UTF-8') . '</code>
                          <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                          <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                          <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                          <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
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
                <password>SCINTILLA</password>
                <userName>SCINTILLA</userName>
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
                        <password>SCINTILLA</password>
                        <userName>SCINTILLA</userName>
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