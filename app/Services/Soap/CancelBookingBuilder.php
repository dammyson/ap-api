<?php

namespace App\Services\Soap;

class CancelBookingBuilder  {
   public function cancelBookingCommit(
      $cityCode, 
      $code, 
      $codeContext, 
      $companyFullName, 
      $companyShortName, 
      $countryCode, 
      $ID, 
      $referenceID, 
      $requestPurpose
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
            <cityCode>' . htmlspecialchars($cityCode, ENT_XML1, 'UTF-8') . '</cityCode>
            <code>' . htmlspecialchars($code, ENT_XML1, 'UTF-8') . '</code>
            <codeContext>' . htmlspecialchars($codeContext, ENT_XML1, 'UTF-8') . '</codeContext>
            <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
            <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
            <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
            </companyName>
            <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
            <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
            </bookingReferenceID>
            <!-- Optional: -->
            <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
            </AirCancelBookingRequest>
            </impl:CancelBooking>
         </soapenv:Body>
      </soapenv:Envelope>';
      return $xml;
    }


    

   public function cancelBookingViewOnly(
      $cityCode, 
      $code, 
      $codeContext, 
      $companyFullName, 
      $companyShortName, 
      $countryCode, 
      $ID, 
      $referenceID,
      $requestPurpose
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
          <cityCode>' . htmlspecialchars($cityCode, ENT_XML1, 'UTF-8') . '</cityCode>
          <code>' . htmlspecialchars($code, ENT_XML1, 'UTF-8') . '</code>
          <codeContext>' . htmlspecialchars($codeContext, ENT_XML1, 'UTF-8') . '</codeContext>
          <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
          <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
          <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
          </companyName>
          <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
          </bookingReferenceID>
          <!-- Optional: -->
          <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
          </AirCancelBookingRequest>
          </impl:CancelBooking>
       </soapenv:Body>
    </soapenv:Envelope>';
   return $xml;
 }

}