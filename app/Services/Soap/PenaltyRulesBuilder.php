<?php

namespace App\Services\Soap;


class PenaltyRulesBuilder {
    public function penaltyRules($fareBasisCode) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
         <soapenv:Header/>
         <soapenv:Body>
         <impl:PenaltyRules>
         <!-- Optional: -->
         <PenaltyRulesRequest>
            <!-- Optional: -->
            <clientInformation>
            <clientIP>129.0.0.1</clientIP>
            <member>false</member>
            <password>SCINTILLA</password>
            <userName>SCINTILLA</userName>
            <preferredCurrency>NGN</preferredCurrency>
            </clientInformation>
            <fareBasisCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareBasisCode>
         </PenaltyRulesRequest>
         </impl:PenaltyRules>
         </soapenv:Body>
      </soapenv:Envelope>';
      return $xml;
   }
}