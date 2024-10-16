<?php

namespace App\Services\Soap;

class CancelBookingBuilder  {
   public function cancelBookingCommit(
      $ID, 
      $referenceID, 
   ) {

      $xml ='<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
         <soapenv:Header/>
         <soapenv:Body>
            <impl:CancelBooking>
            <!-- Optional: -->
            <AirCancelBookingRequest>
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
            <companyName>
               <cityCode>LOS</cityCode>
               <code>P4</code>
               <codeContext>CRANE</codeContext>
               <companyFullName>SCINTILLA</companyFullName>
               <companyShortName>SCINTILLA</companyShortName>
               <countryCode>NG</countryCode>>
            </companyName>
            <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
            <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
            </bookingReferenceID>
            <!-- Optional: -->
            <requestPurpose>COMMIT</requestPurpose>
            </AirCancelBookingRequest>
            </impl:CancelBooking>
         </soapenv:Body>
      </soapenv:Envelope>';
      return $xml;
    }


    

   public function cancelBookingViewOnly(      
      $ID, 
      $referenceID
   ) {
    
   $xml = '<?xml version="1.0" encoding="UTF-8"?>
    <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
       <soapenv:Header/>
       <soapenv:Body>
          <impl:CancelBooking>
          <!-- Optional: -->
          <AirCancelBookingRequest>
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
          <!-- Optional: -->
          <requestPurpose>VIEW_ONLY</requestPurpose>
          </AirCancelBookingRequest>
          </impl:CancelBooking>
       </soapenv:Body>
    </soapenv:Envelope>';
   return $xml;
 }

}