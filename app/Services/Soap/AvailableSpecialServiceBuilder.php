<?php

namespace App\Services\Soap;

class AvailableSpecialServiceBuilder {

    public function AvailableSpecialServiceTwoA (
      $cityCode, 
      $code, 
      $codeContext, 
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
                 <impl:GetAvailableSpecialServices>
                 <AncillaryOtaSsrAvailRequest>
                 <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                 </clientInformation>
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
                 <cabinUpgradeAvailable/>
                 <frequentFlyerRedemption/>
                 </AncillaryOtaSsrAvailRequest>
                 </impl:GetAvailableSpecialServices>
              </soapenv:Body>
           </soapenv:Envelope>
        ';
        return $xml;
    }


    public function AvailableSpecialServiceOW(
      $cityCode, 
      $code, 
      $codeContext, 
      $companyFullName, 
      $companyShortName, 
      $companyCountryCode, 
      $ID, 
      $referenceID
      ) {
       $xml =  '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
           <soapenv:Body>
              <impl:GetAvailableSpecialServices>
                 <AncillaryOtaSsrAvailRequest>
                 <clientInformation>
                    <clientIP>129.0.0.1</clientIP>
                    <member>false</member>
                    <password>SCINTILLA</password>
                    <userName>SCINTILLA</userName>
                    <preferredCurrency>NGN</preferredCurrency>
                 </clientInformation>
                 <bookingReferenceID>
                 <companyName>
                    <cityCode>' . htmlspecialchars($cityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                    <code>' . htmlspecialchars($code, ENT_XML1, 'UTF-8') . '</code>
                    <codeContext>' . htmlspecialchars($codeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                    <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                    <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                    <countryCode>' . htmlspecialchars($companyCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                 </companyName>
                 <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                 <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                 </bookingReferenceID>
                 <cabinUpgradeAvailable/>
                 <frequentFlyerRedemption/>
                 </AncillaryOtaSsrAvailRequest>
              </impl:GetAvailableSpecialServices>
           </soapenv:Body>
           </soapenv:Envelope>';
         
         return $xml;
     }


   public function AvailableSpecialServiceRT(
      $cityCode, 
      $code, 
      $codeContext, 
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
              <impl:GetAvailableSpecialServices>
              <AncillaryOtaSsrAvailRequest>
              <clientInformation>
                 <clientIP>129.0.0.1</clientIP>
                 <member>false</member>
                 <password>SCINTILLA</password>
                 <userName>SCINTILLA</userName>
                 <preferredCurrency>NGN</preferredCurrency>
              </clientInformation>
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
              <cabinUpgradeAvailable/>
              <frequentFlyerRedemption/>
              </AncillaryOtaSsrAvailRequest>
              </impl:GetAvailableSpecialServices>
           </soapenv:Body>
        </soapenv:Envelope>';
      
        return $xml;
     }
}