<?php

namespace App\Services\Soap;

class GetAirportMatrixBuilder {
    
    public function GetAirportMatrix() {
        $xml ='<?xml version="1.0" encoding="UTF-8"?> 
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
                <impl:GetAirPortMatrix>
                    <AirPortMatrixRequest>
                        <clientInformation>
                            <clientIP>129.0.0.1</clientIP>
                            <member>false</member>
                            <password>SCINTILLA</password>
                            <userName>SCINTILLA</userName>
                        </clientInformation>
                    </AirPortMatrixRequest>
                </impl:GetAirPortMatrix>
            </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;


    }
}