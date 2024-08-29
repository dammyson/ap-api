<?php

namespace App\Services\Soap;

class VoidTicketRequestBuilder {

   public function voidTicketPricing( 
      $bookingReferenceCompanyCityCode, 
      $bookingReferenceCompanyCode, 
      $bookingReferenceCompanyCodeContext, 
      $bookingReferenceCompanyFullName, 
      $bookingReferenceCompanyShortName, 
      $bookingReferenceCompanyCountryCode, 
      $ID, 
      $referenceID, 
      $parentBookingCompanyCityCode, 
      $parentBookingCompanyCode, 
      $parentBookingCodeContext, 
      $parentBookingCompanyFullName, 
      $parentBookingCompanyShortName, 
      $parentBookingCountryCode, 
      $parentBookingID, 
      $parentBookingReferenceID, 
      $operationType
    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
          <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
             <soapenv:Header/>
                <soapenv:Body>
                   <impl:VoidTicket>
                   <!-- Optional: -->
                   <VoidTicketRequest>
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
                            <cityCode>' . htmlspecialchars($bookingReferenceCompanyCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                            <code>' . htmlspecialchars($bookingReferenceCompanyCode, ENT_XML1, 'UTF-8') . '</code>
                            <codeContext>' . htmlspecialchars($bookingReferenceCompanyCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                            <companyFullName>' . htmlspecialchars($bookingReferenceCompanyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                            <companyShortName>' . htmlspecialchars($bookingReferenceCompanyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                            <countryCode>' . htmlspecialchars($bookingReferenceCompanyCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                         </companyName>
                         <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                         <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                         <parentBookingReferenceID>
                            <companyName>
                               <cityCode>' . htmlspecialchars($parentBookingCompanyCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                               <code>' . htmlspecialchars($parentBookingCompanyCode, ENT_XML1, 'UTF-8') . '</code>
                               <codeContext>' . htmlspecialchars($parentBookingCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                               <companyFullName>' . htmlspecialchars($parentBookingCompanyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                               <companyShortName>' . htmlspecialchars($parentBookingCompanyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                               <countryCode>' . htmlspecialchars($parentBookingCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                            </companyName>
                            <ID>' . htmlspecialchars($parentBookingID, ENT_XML1, 'UTF-8') . '</ID>
                            <referenceID>' . htmlspecialchars($parentBookingReferenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                         </parentBookingReferenceID>
                      </bookingReferenceID>
                      <!-- Optional: -->
                      <operationType>' . htmlspecialchars($operationType, ENT_XML1, 'UTF-8') . '</operationType>
                      </VoidTicketRequest>
                </impl:VoidTicket>
             </soapenv:Body>
          </soapenv:Envelope>';
        
         return $xml;
    }

   public function voidTicketCommit( 
      $companyNameCityCodeOne, 
      $companyNameCodeOne, 
      $codeContextOne, 
      $companyFullNameOne, 
      $companyShortNameOne, 
      $companyCountryCodeOne, 
      $IDOne, 
      $referenceIDOne, 
      $companyNameCityCodeTwo,
      $companyCodeTwo,
      $companyCodeContextTwo,
      $companyFullNameTwo,
      $companyShortNameTwo,
      $companyCountryCodeTwo,
      $IDTwo,
      $referenceIDTwo,
      $operationType
   ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
               <soapenv:Body>
               <impl:VoidTicket>
               <!-- Optional: -->
               <VoidTicketRequest>
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
                     <cityCode>' . htmlspecialchars($companyNameCityCodeOne, ENT_XML1, 'UTF-8') . '</cityCode>
                     <code>' . htmlspecialchars($companyNameCodeOne, ENT_XML1, 'UTF-8') . '</code>
                     <codeContext>' . htmlspecialchars($codeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                     <companyFullName>' . htmlspecialchars($companyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                     <companyShortName>' . htmlspecialchars($companyShortNameOne, ENT_XML1, 'UTF-8') . '</companyShortName>
                     <countryCode>' . htmlspecialchars($companyCountryCodeOne, ENT_XML1, 'UTF-8') . '</countryCode>
                  </companyName>
                  <ID>' . htmlspecialchars($IDOne, ENT_XML1, 'UTF-8') . '</ID>
                  <referenceID>' . htmlspecialchars($referenceIDOne, ENT_XML1, 'UTF-8') . '</referenceID>
                  <parentBookingReferenceID>
                     <companyName>
                        <cityCode>' . htmlspecialchars($companyNameCityCodeTwo, ENT_XML1, 'UTF-8') . '</cityCode>
                        <code>' . htmlspecialchars($companyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                        <codeContext>' . htmlspecialchars($companyCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                        <companyFullName>' . htmlspecialchars($companyFullNameTwo, ENT_XML1, 'UTF-8') . '</companyFullName>
                        <companyShortName>' . htmlspecialchars($companyShortNameTwo, ENT_XML1, 'UTF-8') . '</companyShortName>
                        <countryCode>' . htmlspecialchars($companyCountryCodeTwo, ENT_XML1, 'UTF-8') . '</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($IDTwo, ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($referenceIDTwo, ENT_XML1, 'UTF-8') . '</referenceID>
                  </parentBookingReferenceID>
               </bookingReferenceID>
               <!-- Optional: -->
               <operationType>' . htmlspecialchars($operationType, ENT_XML1, 'UTF-8') . '</operationType>
               </VoidTicketRequest>
               </impl:VoidTicket>
            </soapenv:Body>
            </soapenv:Envelope>';
      
         return $xml;
   }

}