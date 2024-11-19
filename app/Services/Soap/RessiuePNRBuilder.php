<?php
namespace App\Services\Soap;


class RessiusePNRBuilder {

    public function reissuePnr () {
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
        <soapenv:Header/>
        <soapenv:Body>
            <impl:ReissuePnrPreview>
                <ReissuePnrPreviewRequest>
                    <clientInformation>
                        <clientIP>129.0.0.1</clientIP>
                        <member>false</member>
                        <password>SCINTILLA</password>
                        <userName>SCINTILLA</userName>
                        <preferredCurrency>USD</preferredCurrency>
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
                        <ID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <newSegments>
                        <bookFlightSegment>
                            <addOnSegment/>
                            <bookingClass>
                                <cabin>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                <resBookDesigStatusCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                            </bookingClass>
                            <fareInfo>
                                <cabin>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance>
                                <allowanceType>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</allowanceType>
                                <maxAllowedPieces>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                <maxAllowedWeight>
                                    <unitOfMeasureCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                    <weight>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</weight>
                                </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <portTax>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</portTax>
                                <resBookDesigCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                            <airline>
                                <code>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</code>
                                <companyFullName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</companyFullName>
                            </airline>
                            <arrivalAirport>
                                <cityInfo>
                                    <city>
                                        <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    </city>
                                    <country>
                                        <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        <currency>
                                            <code>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</code>
                                        </currency>
                                    </country>
                                </cityInfo>
                                <codeContext>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeContext>
                                <language>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</language>
                                <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                <timeZoneInfo>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                            </arrivalAirport>
                            <arrivalDateTime>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                            <arrivalDateTimeUTC>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                            <departureAirport>
                                <cityInfo>
                                    <city>
                                        <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    </city>
                                    <country>
                                        <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        <currency>
                                        <code>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</code>
                                        </currency>
                                    </country>
                                </cityInfo>
                                <codeContext>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeContext>
                                <language>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</language>
                                <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                <timeZoneInfo>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '/timeZoneInfo>
                            </departureAirport>
                            <departureDateTime>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</departureDateTime>
                            <departureDateTimeUTC>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                            <flightNumber>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightNumber>
                            <flightSegmentID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                            <ondControlled>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</ondControlled>
                            <sector>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</sector>
                            <codeshare>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeshare>
                            <distance>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</distance>
                            <equipment>
                                <airEquipType>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</airEquipType>
                                <changeofGauge>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</changeofGauge>
                            </equipment>
                            <flightNotes>
                                <deiCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</deiCode>
                                <explanation>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</explanation>
                                <note>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</note>
                            </flightNotes>
                            
                            <flownMileageQty>0</flownMileageQty>
                            <iatciFlight>false</iatciFlight>
                            <journeyDuration>PT1H20M</journeyDuration>
                            <onTimeRate>0</onTimeRate>
                            <remark>Departs From MM1 Zulu Terminal, GAT (Old Domestic)</remark>
                            <secureFlightDataRequired>true</secureFlightDataRequired>
                            <stopQuantity>0</stopQuantity>
                            <ticketType>PAPER</ticketType>
                            </flightSegment>
                            <involuntaryPermissionGiven/>
                            <sequenceNumber/>
                        </bookFlightSegment>
                    </newSegments>
                    <oldSegments>
                    <!-- Zero or more repetitions: -->
                    <bookFlightSegment>
                        <actionCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</actionCode>
                        <addOnSegment>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</addOnSegment>
                        <bookingClass>
                            <cabin>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabin>
                            <resBookDesigCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            <resBookDesigQuantity>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                        </bookingClass>
                        <fareInfo>
                            <cabin>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabin>
                            <cabinClassCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                            <fareBaggageAllowance>
                            <allowanceType>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</allowanceType>
                            <maxAllowedPieces>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                            <maxAllowedWeight>
                            <unitOfMeasureCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                            <weight>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</weight>
                            </maxAllowedWeight>
                            </fareBaggageAllowance>
                            <fareGroupName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareGroupName>
                            <fareReferenceCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                            <fareReferenceID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                            <fareReferenceName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                            <flightSegmentSequence>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                            <resBookDesigCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        </fareInfo>
                        <flightSegment>
                        <airline>
                            <code>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</code>
                            <codeContext>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeContext>
                        </airline>
                        <arrivalAirport>
                            <cityInfo>
                                <city>
                                    <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                </city>
                                <country>
                                    <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                    <code>NGN</code>
                                    </currency>
                                </country>
                            </cityInfo>
                            <codeContext>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeContext>
                            <language>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</language>
                            <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                            <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                            <terminal>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</terminal>
                            <timeZoneInfo>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </arrivalAirport>
                        <arrivalDateTime>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                        <arrivalDateTimeUTC>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                        <departureAirport>
                            <cityInfo>
                            <city>
                                <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                            </city>
                            <country>
                                <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                                <locationNameLanguage>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                <currency>
                                <code>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</code>
                                </currency>
                            </country>
                            </cityInfo>
                            <codeContext>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeContext>
                            <language>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</language>
                            <locationCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationCode>
                            <locationName>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</locationName>
                            <timeZoneInfo>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </departureAirport>
                        <departureDateTime>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</departureDateTime>
                        <departureDateTimeUTC>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                        <flightNumber>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightNumber>
                        <flightSegmentID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                        <ondControlled>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</ondControlled>
                        <sector>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</sector>
                        <codeshare>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</codeshare>
                        <distance>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</distance>
                        <equipment>
                            <airEquipType>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</airEquipType>
                            <changeofGauge>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</changeofGauge>
                        </equipment>
                        <flightNotes>
                            <deiCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</deiCode>
                            <explanation>S' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</explanation>
                            <note>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</note>
                        </flightNotes>            
                        <flownMileageQty>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                        <iatciFlight>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</iatciFlight>
                        <journeyDuration>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</journeyDuration>
                        <onTimeRate>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</onTimeRate>
                        <remark>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</remark>
                        <secureFlightDataRequired>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                        <segmentStatusByFirstLeg>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                        <stopQuantity>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</stopQuantity>
                        </flightSegment>
                        <involuntaryPermissionGiven>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                        <legStatus>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</legStatus>
                        <referenceID>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</referenceID>
                        <responseCode>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</responseCode>
                        <sequenceNumber>' . htmlspecialchars($fareBasisCode, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                        <status>HK</status>
                    </bookFlightSegment>
                    </oldSegments>
                </ReissuePnrPreviewRequest>
            </impl:ReissuePnrPreview>
        </soapenv:Body>
        </soapenv:Envelope>';
    }
  

}