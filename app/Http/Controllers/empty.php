"""
<?xml version="1.0" encoding="UTF-8"?>

        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">

        <soapenv:Header/>

        <soapenv:Body>

            <impl:ReissuePnrCommit>

                <!-- Optional: -->

                <ReissuePnrCommitRequest>

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

                        <ID>12EMGN</ID>

                        <referenceID>13493388</referenceID>

                    </bookingReferenceID>

                    <fullfillment>

                        <paymentDetails>

                            <paymentDetailList>

                                <miscChargeOrder>

                                    <avsEnabled/>

                                    <capturePaymentToolNumber>false</capturePaymentToolNumber>

                                    <paymentCode>INV</paymentCode>

                                    <threeDomainSecurityEligible>false</threeDomainSecurityEligible>

                                    <transactionFeeApplies/><MCONumber>4010026733</MCONumber>

                                </miscChargeOrder>

                                <payLater/>

                                <paymentAmount>

                                    <currency>

                                        <code>NGN</code>

                                    </currency>

                                    <mileAmount/>

                                    <value>160</value>

                                </paymentAmount>

                                <paymentType>MISC_CHARGE_ORDER</paymentType>

                                <primaryPayment>true</primaryPayment>

                            </paymentDetailList>

                        </paymentDetails>

                    </fullfillment>

                    <newSegments>

                        <bookFlightSegment>

                            <addOnSegment/>

                            <bookingClass> 

                                <cabin>BUSINESS</cabin>

                                <resBookDesigCode>C</resBookDesigCode>

                                <resBookDesigQuantity>7</resBookDesigQuantity>

                                <resBookDesigStatusCode>O</resBookDesigStatusCode>

                            </bookingClass>

                            <fareInfo> 

                                <cabin>BUSINESS</cabin>

                                <cabinClassCode>C</cabinClassCode>

                                <fareBaggageAllowance> 

                                    <allowanceType>WEIGHT</allowanceType>

                                    <maxAllowedPieces>0</maxAllowedPieces>

                                    <maxAllowedWeight>

                                        <unitOfMeasureCode>KG</unitOfMeasureCode>

                                        <weight>30</weight>

                                    </maxAllowedWeight>

                                </fareBaggageAllowance>

                                <fareGroupName>Business Dom</fareGroupName>

                                <fareReferenceCode>COW</fareReferenceCode>

                                <fareReferenceID>0fe3799d83d712d38d0dbc3a7ce27734ffa7c03884488608c099c821e149e6055e21691c51c2a3ddc056e15fc15415aa387f3fb1072cf9a0ca146bfbebf5375b0e7a227f5b1eb265d9382e0678940a1532068ae5d1e0c4271cd791233b1af5d114724ce7f0b8d18e457b85aa1b87ac086507f19adced005b72f4147cc614e049b78c6d5b3005b0cd679cac93f640753527f9aea31d22dba7ebe73920f93e72a2cfc6f6fa5cda5a54a4aa4d12b2f1ea07452771c55b24d562c326140ababde3fa0883c608323433ac74f0e49575e405f59ea0a2939374c9c95c4cbe8f817f28d76ae0c517481f06d5b5f6c66ad98d5cb1f91b8d95210b586c58da6fbb4c4034052ba6a4022876498833a326b7ecf7081f</fareReferenceID>

                                <fareReferenceName>COWDOM</fareReferenceName>

                                <flightSegmentSequence>1</flightSegmentSequence>

                                <portTax>T</portTax>

                                <resBookDesigCode>C</resBookDesigCode>

                            </fareInfo>

                            <flightSegment>

                                <airline>

                                    <code>P4</code>

                                    <companyFullName>Air Peace</companyFullName>

                                </airline>

                                <arrivalAirport>

                                    <cityInfo>

                                        <city>

                                            <locationCode>ABV</locationCode>

                                            <locationName>Abuja</locationName>

                                            <locationNameLanguage>EN</locationNameLanguage>

                                        </city>

                                        <country>

                                            <locationCode>NG</locationCode>

                                            <locationName>Nigeria</locationName>

                                            <locationNameLanguage>EN</locationNameLanguage>

                                            <currency>

                                                <code>NGN</code>

                                            </currency>

                                        </country>

                                    </cityInfo>

                                    <codeContext>IATA</codeContext>

                                    <language>EN</language>

                                    <locationCode>ABV</locationCode>

                                    <locationName>Abuja</locationName>

                                    <timeZoneInfo>Africa/Lagos</timeZoneInfo>

                                </arrivalAirport>

                                <arrivalDateTime>2026-05-29T07:50:00+01:00</arrivalDateTime>

                                <arrivalDateTimeUTC>2026-05-29T06:50:00+01:00</arrivalDateTimeUTC>

                                <departureAirport>

                                    <cityInfo>

                                        <city>

                                            <locationCode>LOS</locationCode>

                                            <locationName>Lagos</locationName>

                                            <locationNameLanguage>EN</locationNameLanguage>

                                        </city>

                                        <country>

                                            <locationCode>NG</locationCode>

                                            <locationName>Nigeria</locationName>

                                            <locationNameLanguage>EN</locationNameLanguage>

                                            <currency>

                                            <code>NGN</code>

                                            </currency>

                                        </country>

                                    </cityInfo>

                                    <codeContext>IATA</codeContext>

                                    <language>EN</language>

                                    <locationCode>LOS</locationCode>

                                    <locationName>Lagos</locationName>

                                    <timeZoneInfo>Africa/Lagos</timeZoneInfo>

                                </departureAirport>

                                <departureDateTime>2026-05-29T06:30:00+01:00</departureDateTime>

                                <departureDateTimeUTC>2026-05-29T05:30:00+01:00</departureDateTimeUTC>

                                <flightNumber>7120</flightNumber>

                                <flightSegmentID>1172298</flightSegmentID>

                                <ondControlled>false</ondControlled>

                                <sector>Domestic</sector>

                                <codeshare>false</codeshare>

                                <distance>511</distance>

                                <equipment>

                                    <airEquipType>B737-500</airEquipType>

                                    <changeofGauge>false</changeofGauge>

                                </equipment>

            <flightNotes>

                <deiCode>504</deiCode>

                <explanation>Secure Flight Info</explanation>

                <note>T</note>

            </flightNotes><flownMileageQty>0</flownMileageQty>

                                <iatciFlight>false</iatciFlight>

                                <journeyDuration>PT1H20M</journeyDuration>

                                <onTimeRate>0</onTimeRate>

                                <remark>some remark</remark>

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

                        <actionCode>HK</actionCode>

                        <addOnSegment>false</addOnSegment>

                        <bookingClass>

                            <cabin>ECONOMY</cabin>

                            <resBookDesigCode>V</resBookDesigCode>

                            <resBookDesigQuantity>0</resBookDesigQuantity>

                        </bookingClass>

                        <fareInfo>

                            <cabin>ECONOMY</cabin>

                            <cabinClassCode>Y</cabinClassCode>

                            <fareBaggageAllowance>

                                <allowanceType>WEIGHT</allowanceType>

                                <maxAllowedPieces>0</maxAllowedPieces>

                                <maxAllowedWeight>

                                    <unitOfMeasureCode>KG</unitOfMeasureCode>

                                    <weight>15</weight>

                                </maxAllowedWeight>

                            </fareBaggageAllowance>

                            <fareGroupName>Eco Non Flexi Dom</fareGroupName>

                            <fareReferenceCode>VOW</fareReferenceCode>

                            <fareReferenceID>0fe3779b82d712c1be1d8b3d18fd7120e1ac9b4adc1bd41dc98fbb50f15cf5530d7f224a16d8fcd6c755ef09c81e47b12f252ff31328a4a1825069bfc4d44d4d153e6b29180bb56fd8396a452078068b6e094d1c77bbf0a692fe85</fareReferenceID>

                            <fareReferenceName>VOWDOM</fareReferenceName>

                            <flightSegmentSequence>0</flightSegmentSequence>

                            <resBookDesigCode>V</resBookDesigCode>

                        </fareInfo>

                        <flightSegment>

                            <airline>

                                <code>P4</code>

                                <codeContext>IATA</codeContext>

                            </airline>

                            <arrivalAirport>

                                <cityInfo>

                                    <city>

                                        <locationCode>ABV</locationCode>

                                        <locationName>Abuja</locationName>

                                        <locationNameLanguage>EN</locationNameLanguage>

                                    </city>

                                    <country>

                                        <locationCode>NG</locationCode>

                                        <locationName>Nigeria</locationName>

                                        <locationNameLanguage>EN</locationNameLanguage>

                                        <currency>

                                        <code>NGN</code>

                                        </currency>

                                    </country>

                                </cityInfo>

                                <codeContext>IATA</codeContext>

                                <language>EN</language>

                                <locationCode>ABV</locationCode>

                                <locationName>Abuja</locationName>

                                <terminal>B1</terminal>

                                <timeZoneInfo>Africa/Lagos</timeZoneInfo>

                            </arrivalAirport>

                            <arrivalDateTime>2026-05-27T07:50:00+01:00</arrivalDateTime>

                            <arrivalDateTimeUTC>2026-05-27T06:50:00+01:00</arrivalDateTimeUTC>

                            <departureAirport>

                                <cityInfo>

                                <city>

                                    <locationCode>LOS</locationCode>

                                    <locationName>Lagos</locationName>

                                    <locationNameLanguage>EN</locationNameLanguage>

                                </city>

                                <country>

                                    <locationCode>NG</locationCode>

                                    <locationName>Nigeria</locationName>

                                    <locationNameLanguage>EN</locationNameLanguage>

                                    <currency>

                                        <code>NGN</code>

                                    </currency>

                                </country>

                                </cityInfo>

                                <codeContext>IATA</codeContext>

                                <language>EN</language>

                                <locationCode>LOS</locationCode>

                                <locationName>Lagos</locationName>

                                <timeZoneInfo>Africa/Lagos</timeZoneInfo>

                            </departureAirport>

                            <departureDateTime>2026-05-27T06:30:00+01:00</departureDateTime>

                            <departureDateTimeUTC>2026-05-27T05:30:00+01:00</departureDateTimeUTC>

                            <flightNumber>7120</flightNumber>

                            <flightSegmentID>1172296</flightSegmentID>

                            <ondControlled>false</ondControlled>

                            <sector>DOMESTIC</sector>

                            <codeshare>false</codeshare>

                            <distance>511</distance>

                            <equipment>

                                <airEquipType>B737-500</airEquipType>

                                <changeofGauge>false</changeofGauge>

                            </equipment>

            <flightNotes>

                <deiCode>504</deiCode>

                <explanation>Secure Flight Info</explanation>

                <note>T</note>

            </flightNotes><flownMileageQty>0</flownMileageQty>

                            <iatciFlight>false</iatciFlight>

                            <journeyDuration>PT1H20M</journeyDuration>

                            <onTimeRate>0</onTimeRate>

                            <remark>Departs From MM1 Zulu Terminal, GAT (Old Domestic)</remark>

                            <secureFlightDataRequired>true</secureFlightDataRequired>

                            <segmentStatusByFirstLeg>RZ</segmentStatusByFirstLeg>

                            <stopQuantity>0</stopQuantity>

                        </flightSegment>

                        <involuntaryPermissionGiven>false</involuntaryPermissionGiven>

                        <legStatus>RZ</legStatus>

                        <referenceID>15910958</referenceID>

                        <responseCode>HK</responseCode>

                        <sequenceNumber>0</sequenceNumber>

                        <status>HK</status>

                    </bookFlightSegment>

                    </oldSegments>

                </ReissuePnrCommitRequest>

            </impl:ReissuePnrCommit>

        </soapenv:Body>

        </soapenv:Envelope>
""" // app\Http\Controllers\Soap\ReissuePNRController.php:252