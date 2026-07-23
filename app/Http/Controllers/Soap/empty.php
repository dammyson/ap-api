<?php
"""
<?xml version="1.0" encoding="UTF-8"?>

      <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">

         <soapenv:Header/>

            <soapenv:Body>

               <impl:SegmentBaseAvailableSpecialServices>

                  <!-- Optional: -->

                  <SegmentBaseAvailableSpecialServicesRequest>

                     <!-- Optional: -->

                     <clientInformation>

                        <clientIP>129.0.0.1</clientIP>

                        <member>false</member>

                        <password>SCINTILLA</password>

                        <userName>SCINTILLA</userName>

                        <preferredCurrency>NGN</preferredCurrency>

                     </clientInformation>

                     <!-- Zero or more repetitions: -->


\t\t\t\t
<bookFlightSegmentList>

\t\t\t\t\t
<addOnSegment/>

\t\t\t\t\t
<bookingClass>

\t\t\t\t\t\t
<cabin>ECONOMY</cabin>

\t\t\t\t\t\t
<resBookDesigCode>T</resBookDesigCode>

\t\t\t\t\t\t
<resBookDesigQuantity>0</resBookDesigQuantity>

\t\t\t\t\t\t
<resBookDesigStatusCode>O</resBookDesigStatusCode>

\t\t\t\t\t
</bookingClass>

\t\t\t\t\t
<!-- Optional: -->

\t\t\t\t\t
<fareInfo>

\t\t\t\t\t\t
<cabin>ECONOMY</cabin>

\t\t\t\t\t\t
<cabinClassCode>Y</cabinClassCode>

\t\t\t\t\t\t
<fareBaggageAllowance>

\t\t\t\t\t\t\t
<allowanceType>WEIGHT</allowanceType>

\t\t\t\t\t\t\t
<maxAllowedPieces>0</maxAllowedPieces>

\t\t\t\t\t\t\t
<maxAllowedWeight>

\t\t\t\t\t\t\t
<unitOfMeasureCode>KG</unitOfMeasureCode>

\t\t\t\t\t\t\t
<weight>20</weight>

\t\t\t\t\t\t\t
</maxAllowedWeight>

\t\t\t\t\t\t
</fareBaggageAllowance>

\t\t\t\t\t\t
<fareGroupName>Eco Flexi Dom</fareGroupName>

\t\t\t\t\t\t
<fareReferenceCode>TOW</fareReferenceCode>

\t\t\t\t\t\t
<fareReferenceID>0ee57c9a80d612c1be1d8b3d18fd7120e1ac9b4adc14d712cb8abb59f75cf0530d7f221343d0f88ec201bb59c14841b77e2a2bf41079a3f0810168ea918640481460302b4a08ee6f8c6564f31659f2414ca7cd3d3daac5036d6266</fareReferenceID>

\t\t\t\t\t\t
<fareReferenceName>TOWDOM</fareReferenceName>

\t\t\t\t\t\t
<flightSegmentSequence>0</flightSegmentSequence>

\t\t\t\t\t\t
<portTax>T</portTax>

\t\t\t\t\t\t
<resBookDesigCode>V</resBookDesigCode>

\t\t\t\t\t
</fareInfo>

\t\t\t\t\t
<!-- Optional: -->

\t\t\t\t\t
<flightSegment>

\t\t\t\t\t\t
<airline>

\t\t\t\t\t\t\t
<code>P4</code>

\t\t\t\t\t\t\t
<companyFullName>Air Peace</companyFullName>

\t\t\t\t\t\t
</airline>

\t\t\t\t\t\t
<arrivalAirport>

\t\t\t\t\t\t\t
<cityInfo>

\t\t\t\t\t\t\t
<city>

\t\t\t\t\t\t\t\t
<locationCode>ABV</locationCode>

\t\t\t\t\t\t\t\t
<locationName>Abuja</locationName>

\t\t\t\t\t\t\t\t
<locationNameLanguage>EN</locationNameLanguage>

\t\t\t\t\t\t\t
</city>

\t\t\t\t\t\t\t
<country>

\t\t\t\t\t\t\t\t
<locationCode>NG</locationCode>

\t\t\t\t\t\t\t\t
<locationName>Nigeria</locationName>

\t\t\t\t\t\t\t\t
<locationNameLanguage>EN</locationNameLanguage>

\t\t\t\t\t\t\t\t
<currency>

\t\t\t\t\t\t\t\t\t
<code>NGN</code>

\t\t\t\t\t\t\t\t
</currency>

\t\t\t\t\t\t\t
</country>

\t\t\t\t\t\t\t
</cityInfo>

\t\t\t\t\t\t\t
<codeContext>IATA</codeContext>

\t\t\t\t\t\t\t
<language>EN</language>

\t\t\t\t\t\t\t
<locationCode>ABV</locationCode>

\t\t\t\t\t\t\t
<locationName>Abuja</locationName>

\t\t\t\t\t\t\t
<timeZoneInfo>Africa/Lagos</timeZoneInfo>

\t\t\t\t\t\t
</arrivalAirport>

\t\t\t\t\t\t
<arrivalDateTime>2026-07-29T07:50:00+01:00</arrivalDateTime>

\t\t\t\t\t\t
<arrivalDateTimeUTC>2026-07-29T06:50:00+01:00</arrivalDateTimeUTC>

\t\t\t\t\t\t
<departureAirport>

\t\t\t\t\t\t\t
<cityInfo>

\t\t\t\t\t\t\t
<city>

\t\t\t\t\t\t\t\t
<locationCode>LOS</locationCode>

\t\t\t\t\t\t\t\t
<locationName>Lagos</locationName>

\t\t\t\t\t\t\t\t
<locationNameLanguage>EN</locationNameLanguage>

\t\t\t\t\t\t\t
</city>

\t\t\t\t\t\t\t
<country>

\t\t\t\t\t\t\t\t
<locationCode>NG</locationCode>

\t\t\t\t\t\t\t\t
<locationName>Nigeria</locationName>

\t\t\t\t\t\t\t\t
<locationNameLanguage>EN</locationNameLanguage>

\t\t\t\t\t\t\t\t
<currency>

\t\t\t\t\t\t\t\t\t
<code>NGNGNN</code>

\t\t\t\t\t\t\t\t
</currency>

\t\t\t\t\t\t\t
</country>

\t\t\t\t\t\t\t
</cityInfo>

\t\t\t\t\t\t\t
<codeContext>IATA</codeContext>

\t\t\t\t\t\t\t
<language>EN</language>

\t\t\t\t\t\t\t
<locationCode>LOS</locationCode>

\t\t\t\t\t\t\t
<locationName>Lagos</locationName>

\t\t\t\t\t\t\t
<timeZoneInfo>Africa/Lagos</timeZoneInfo>

\t\t\t\t\t\t
</departureAirport>

\t\t\t\t\t\t
<departureDateTime>2026-07-29T06:30:00+01:00</departureDateTime>

\t\t\t\t\t\t
<departureDateTimeUTC>2026-07-29T05:30:00+01:00</departureDateTimeUTC>

\t\t\t\t\t\t
<flightNumber>7120</flightNumber>

\t\t\t\t\t\t
<flightSegmentID>1593597</flightSegmentID>

\t\t\t\t\t\t
<ondControlled>false</ondControlled>

\t\t\t\t\t\t
<sector>DOMESTIC</sector>

\t\t\t\t\t\t
<codeshare>false</codeshare>

\t\t\t\t\t\t
<distance>511</distance>

\t\t\t\t\t\t
<equipment>

\t\t\t\t\t\t\t
<airEquipType>B738</airEquipType>

\t\t\t\t\t\t\t
<changeofGauge>false</changeofGauge>

\t\t\t\t\t\t
</equipment>

\t\t\t\t\t\t
<flownMileageQty>0</flownMileageQty>

\t\t\t\t\t\t
<iatciFlight>false</iatciFlight>

\t\t\t\t\t\t
<journeyDuration>PT1H20M</journeyDuration>

\t\t\t\t\t\t
<onTimeRate>0</onTimeRate>

\t\t\t\t\t\t
<remark>DEPARTS FROM MM1 ZULU TERMINAL GAT OLD DOMESTIC</remark>

\t\t\t\t\t\t
<secureFlightDataRequired>false</secureFlightDataRequired>

\t\t\t\t\t\t
<stopQuantity>0</stopQuantity>

\t\t\t\t\t\t
<ticketType>PAPER</ticketType>

\t\t\t\t\t
</flightSegment>

\t\t\t\t\t
<involuntaryPermissionGiven/>

\t\t\t\t\t
<sequenceNumber/>


\t
</bookFlightSegmentList>

                     <frequentFlyerRedemption/>

                     <ssrGroupCode>BAG</ssrGroupCode>

                  </SegmentBaseAvailableSpecialServicesRequest>

               </impl:SegmentBaseAvailableSpecialServices>

            </soapenv:Body>

         </soapenv:Envelope>


""" // app\Http\Controllers\Soap\SegmentBaseController.php:30