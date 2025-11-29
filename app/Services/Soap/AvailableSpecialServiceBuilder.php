<?php

namespace App\Services\Soap;

class AvailableSpecialServiceBuilder {


    public function AvailableSpecialService(
      $request
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
                        <cityCode>LOS</cityCode>
                        <code>P4</code>
                        <codeContext>CRANE</codeContext>
                        <companyFullName>SCINTILLA</companyFullName>
                        <companyShortName>SCINTILLA</companyShortName>
                        <countryCode>NG</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($request->input('ID'), ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($request->input('referenceID'), ENT_XML1, 'UTF-8') . '</referenceID>
                 </bookingReferenceID>
                 <cabinUpgradeAvailable/>
                 <frequentFlyerRedemption/>
                  <ssrGroupCode>' . htmlspecialchars($request->input('ssrGroupCode'), ENT_XML1, 'UTF-8') . '</ssrGroupCode>

                 </AncillaryOtaSsrAvailRequest>
              </impl:GetAvailableSpecialServices>
           </soapenv:Body>
           </soapenv:Envelope>';
         
         return $xml;
     }
}