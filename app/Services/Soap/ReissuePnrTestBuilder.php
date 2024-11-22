<?php
namespace App\Services\Soap;

use App\Services\Utility\FlightNotes;

class ReissuePnrTestBuilder {

    public $flightNotes;

    public function __construct(FlightNotes $flightNotes) {
        $this->flightNotes = $flightNotes;
    }

    public function reissuePnr(
        $ID, 
        $referenceID, 
        $bookingClassCabinOne, 
        $bookingClassResBookDesigCodeOne, 
        $bookingClassResBookDesigQuantityOne, 
        $bookignClassResBookDesigStatusCodeOne, 
        $fareInfoCabinOne, 
        $fareInfocabinClassCodeOne,
        $fareInfoCabinAllowanceTypeOne,
        $maxAllowedPiecesOne,
        $unitOfMeasureCodeOne,
        $weightOne,
        $fareGroupNameOne,
        $fareReferenceCodeOne,
        $fareReferenceIDOne,
        $fareReferenceNameOne,
        $flightSegmentSequenceOne,
        $portTaxOne,
        $resBookDesigCodeOne,
        $airlineCodeOne,
        $airlinecompanyFullNameOne,
        $arrivalAirportCityLocationCodeOne,
        $arrivalAirportCityLocationNameOne,
        $arrivalAirportLocationNameLanguageOne,
        $arrivalAirportCountryLocationCodeOne,
        $arrivalAirportCountryLocationNameOne,
        $arrivalAirportCountryLocationNameLanguageOne,
        $arrivalAirportCountryCurrencyCodeOne,
        $arrivalAirportCodeContextOne,
        $arrivalAirportLanguageOne,
        $arrivalAirportLocationCodeOne,
        $arrivalAirportLocationNameOne,
        $arrivalAirportTimeZoneInfoOne,
        $arrivalDateTimeOne,
        $arrivalDateTimeUTCOne,
        $departureAirportCityLocationCodeOne,
        $departureAirportCityLocationNameOne,
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCodeOne,
        $departureAirportCountryLocationNameOne,
        $departureAirportCountryLocationNameLanguageOne,
        $departureAirportCountryCodeOne,
        $departureAirportCodeContextOne,
        $departureAirportLanguageOne,
        $departureAirportLocationCodeOne,
        $departureAirportLocationNameOne,
        $departureTimeZoneInfoOne,
        $departureDateTimeOne,
        $departureDateTimeUTCOne,
        $flightNumberOne,
        $flightSegmentIDOne,
        $ondControlledOne,
        $sectorOne,
        $codeShareOne,
        $distanceOne,
        $equipmentAirEquipTypeOne,
        $equipmentChangeOfGaugeOne,
        $flightNotesOne,
        $flownMileageQtyOne,
        $iatciFlightOne,
        $journeyDurationOne,
        $onTimeRateOne,
        $remarkOne,
        $secureFlightDataRequiredOne,
        $stopQuantityOne,
        $ticketTypeOne,
        $actionCodeTwo,
        $addOnSegmentTwo,
        $bookingClassCabinTwo,
        $bookingCabinResBookDesigCodeTwo,
        $bookingCabinResBookDesigQuantityTwo,
        $fareInfoCabinTwo,
        $fareInfoCabinClassCodeTwo,
        $allowanceTypeTwo,
        $maxAllowedPiecesTwo,
        $unitOfMeasureCodeTwo,
        $weightTwo,
        $fareGroupNameTwo,
        $fareReferenceCodeTwo,
        $fareReferenceIDTwo,
        $fareReferenceNameTwo,
        $flightSegmentSequenceTwo,
        $resBookDesigCodeTwo,
        $airlineCodeTwo,
        $airlineCodeContextTwo,
        $arrivalAirportCityLocationCodeTwo,
        $arrivalAirportCityLocationNameTwo,
        $arrivalAirportCityLocationNameLanguageTwo,
        $arrivalAirportCountryLocationCodeTwo,
        $arrivalAirportCountryLocationNameTwo,
        $arrivalAirportLocationNameLanguageTwo,
        $arrivalAirportCountryCodeTwo,
        $arrivalAirportCodeContextTwo,
        $arrivalAirportLanguageTwo,
        $arrivalAirportLocationCodeTwo,
        $arrivalAirportLocationNameTwo,
        $arrivalAirportTerminalTwo,
        $arrivalAirportTimeZoneInfoTwo,
        $arrivalDateTimeTwo,
        $arrivalDateTimeUTCTwo,
        $departureAirportCityLocationCodeTwo,
        $departureAirportCityLocationNameTwo,
        $departureAirportCityLocationNameLanguageTwo,
        $departureAirportCountryLocationCodeTwo,
        $departureAirportCountryLocationNameTwo,
        $departureAirportLocationNameLanguageTwo,
        $departureAirportCountryCurrencyCodeTwo,
        $departureAirportCodeContextTwo,
        $departureAirportLanguageTwo,
        $departureAirportLocationCodeTwo,
        $departureAirportLocationNameTwo,
        $departureAirportTimeZoneInfoTwo,
        $departureDateTimeTwo,
        $departureDateTimeUTCTwo,
        $flightNumberTwo,
        $flightSegmentIDTwo,
        $ondControlledTwo,
        $sectorTwo,
        $codeShareTwo,
        $distanceTwo,
        $equipmentAirEquipTypeTwo,
        $equipmentChangeOfGaugeTwo,
        $flightNotesTwo,
        $flownMileageQtyTwo,
        $iatciFlightTwo,
        $journeyDurationTwo,
        $onTimeRateTwo,
        $remarkTwo,
        $secureFlightDataRequiredTwo,
        $segmentStatusByFirstLegTwo,
        $stopQuantityTwo,
        $involuntaryPermissionGivenTwo,
        $legStatusTwo,
        $referenceIDTwo,
        $responseCodeTwo,
        $sequenceNumberTwo,
        $statusTwo

    ) {
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <newSegments>
                        
                    </newSegments>
                    <oldSegments>
                        <!-- Zero or more repetitions: -->
                        <bookFlightSegment>
                            <actionCode>' . htmlspecialchars($actionCodeTwo, ENT_XML1, 'UTF-8') . '</actionCode>
                            <addOnSegment>' . htmlspecialchars($addOnSegmentTwo, ENT_XML1, 'UTF-8') . '</addOnSegment>
                            <bookingClass>
                                <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingCabinResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingCabinResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                            </bookingClass>
                            <fareInfo>
                                <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance>
                                    <allowanceType>' . htmlspecialchars($allowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                    <codeContext>' . htmlspecialchars($airlineCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($arrivalAirportCountryCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <terminal>' . htmlspecialchars($arrivalAirportTerminalTwo, ENT_XML1, 'UTF-8') . '</terminal>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                                <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                    
                                    $this->flightNotes->flightNotesArray($flightNotesTwo)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLegTwo, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                            </flightSegment>
                            <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGivenTwo, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                            <legStatus>' . htmlspecialchars($legStatusTwo, ENT_XML1, 'UTF-8') . '</legStatus>
                            <referenceID>' . htmlspecialchars($referenceIDTwo, ENT_XML1, 'UTF-8') . '</referenceID>
                            <responseCode>' . htmlspecialchars($responseCodeTwo, ENT_XML1, 'UTF-8') . '</responseCode>
                            <sequenceNumber>' . htmlspecialchars($sequenceNumberTwo, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                            <status>' . htmlspecialchars($statusTwo, ENT_XML1, 'UTF-8') . '</status>
                        </bookFlightSegment>
                    </oldSegments>
                </ReissuePnrPreviewRequest>
            </impl:ReissuePnrPreview>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }

    public function newSegment($newSegments) {
        $xml = '';

        foreach($newSegments as $newSegment) {
            $xml .= '
                <bookFlightSegment>
                    <addOnSegment/>
                    <bookingClass> 
                        <cabin>' . htmlspecialchars($newSegment['bookingClassCabin'], ENT_XML1, 'UTF-8') . '</cabin>
                        <resBookDesigCode>' . htmlspecialchars($newSegment['bookingClassResBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        <resBookDesigQuantity>' . htmlspecialchars($newSegment['bookingClassResBookDesigQuantity'], ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                        <resBookDesigStatusCode>' . htmlspecialchars($newSegment['bookignClassResBookDesigStatusCode'], ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                    </bookingClass>
                    <fareInfo> 
                        <cabin>' . htmlspecialchars($newSegment['fareInfoCabin'], ENT_XML1, 'UTF-8') . '</cabin>
                        <cabinClassCode>' . htmlspecialchars($newSegment['fareInfocabinClassCode'], ENT_XML1, 'UTF-8') . '</cabinClassCode>
                        <fareBaggageAllowance> 
                            <allowanceType>' . htmlspecialchars($newSegment['fareInfoCabinAllowanceType'], ENT_XML1, 'UTF-8') . '</allowanceType>
                            <maxAllowedPieces>' . htmlspecialchars($newSegment['maxAllowedPieces'], ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                            <maxAllowedWeight>
                                <unitOfMeasureCode>' . htmlspecialchars($newSegment['unitOfMeasureCode'], ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                <weight>' . htmlspecialchars($newSegment['weight'], ENT_XML1, 'UTF-8') . '</weight>
                            </maxAllowedWeight>
                        </fareBaggageAllowance>
                        <fareGroupName>' . htmlspecialchars($newSegment['fareGroupName'], ENT_XML1, 'UTF-8') . '</fareGroupName>
                        <fareReferenceCode>' . htmlspecialchars($newSegment['fareReferenceCode'], ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                        <fareReferenceID>' . htmlspecialchars($newSegment['fareReferenceID'], ENT_XML1, 'UTF-8') . '</fareReferenceID>
                        <fareReferenceName>' . htmlspecialchars($newSegment['fareReferenceName'], ENT_XML1, 'UTF-8') . '</fareReferenceName>
                        <flightSegmentSequence>' . htmlspecialchars($newSegment['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                        <portTax>' . htmlspecialchars($newSegment['portTax'], ENT_XML1, 'UTF-8') . '</portTax>
                        <resBookDesigCode>' . htmlspecialchars($newSegment['resBookDesigCode'], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                    </fareInfo>
                    <flightSegment>
                        <airline>
                            <code>' . htmlspecialchars($newSegment['airlineCode'], ENT_XML1, 'UTF-8') . '</code>
                            <companyFullName>' . htmlspecialchars($newSegment['airlinecompanyFullName'], ENT_XML1, 'UTF-8') . '</companyFullName>
                        </airline>
                        <arrivalAirport>
                            <cityInfo>
                                <city>
                                    <locationCode>' . htmlspecialchars($newSegment['arrivalAirportCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($newSegment['arrivalAirportCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($newSegment['arrivalAirportLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                </city>
                                <country>
                                    <locationCode>' . htmlspecialchars($newSegment['arrivalAirportCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($newSegment['arrivalAirportCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($newSegment['arrivalAirportCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                        <code>' . htmlspecialchars($newSegment['arrivalAirportCountryCurrencyCode'], ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                </country>
                            </cityInfo>
                            <codeContext>' . htmlspecialchars($newSegment['arrivalAirportCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
                            <language>' . htmlspecialchars($newSegment['arrivalAirportLanguage'], ENT_XML1, 'UTF-8') . '</language>
                            <locationCode>' . htmlspecialchars($newSegment['arrivalAirportLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                            <locationName>' . htmlspecialchars($newSegment['arrivalAirportLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                            <timeZoneInfo>' . htmlspecialchars($newSegment['arrivalAirportTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </arrivalAirport>
                        <arrivalDateTime>' . htmlspecialchars($newSegment['arrivalDateTime'], ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                        <arrivalDateTimeUTC>' . htmlspecialchars($newSegment['arrivalDateTimeUTC'], ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                        <departureAirport>
                            <cityInfo>
                                <city>
                                    <locationCode>' . htmlspecialchars($newSegment['departureAirportCityLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($newSegment['departureAirportCityLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($newSegment['departureAirportCityLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                </city>
                                <country>
                                    <locationCode>' . htmlspecialchars($newSegment['departureAirportCountryLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($newSegment['departureAirportCountryLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($newSegment['departureAirportCountryLocationNameLanguage'], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                        <code>' . htmlspecialchars($newSegment['departureAirportCountryCode'], ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                </country>
                            </cityInfo>
                            <codeContext>' . htmlspecialchars($newSegment['departureAirportCodeContext'], ENT_XML1, 'UTF-8') . '</codeContext>
                            <language>' . htmlspecialchars($newSegment['departureAirportLanguage'], ENT_XML1, 'UTF-8') . '</language>
                            <locationCode>' . htmlspecialchars($newSegment['departureAirportLocationCode'], ENT_XML1, 'UTF-8') . '</locationCode>
                            <locationName>' . htmlspecialchars($newSegment['departureAirportLocationName'], ENT_XML1, 'UTF-8') . '</locationName>
                            <timeZoneInfo>' . htmlspecialchars($newSegment['departureTimeZoneInfo'], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                        </departureAirport>
                        <departureDateTime>' . htmlspecialchars($newSegment['departureDateTime'], ENT_XML1, 'UTF-8') . '</departureDateTime>
                        <departureDateTimeUTC>' . htmlspecialchars($newSegment['departureDateTimeUTC'], ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                        <flightNumber>' . htmlspecialchars($newSegment['flightNumber'], ENT_XML1, 'UTF-8') . '</flightNumber>
                        <flightSegmentID>' . htmlspecialchars($newSegment['flightSegmentID'], ENT_XML1, 'UTF-8') . '</flightSegmentID>
                        <ondControlled>' . htmlspecialchars($newSegment['ondControlled'], ENT_XML1, 'UTF-8') . '</ondControlled>
                        <sector>' . htmlspecialchars($newSegment['sector'], ENT_XML1, 'UTF-8') . '</sector>
                        <codeshare>' . htmlspecialchars($newSegment['codeShare'], ENT_XML1, 'UTF-8') . '</codeshare>
                        <distance>' . htmlspecialchars($newSegment['distance'], ENT_XML1, 'UTF-8') . '</distance>
                        <equipment>
                            <airEquipType>' . htmlspecialchars($newSegment['equipmentAirEquipType'], ENT_XML1, 'UTF-8') . '</airEquipType>
                            <changeofGauge>' . htmlspecialchars($newSegment['equipmentChangeOfGauge'], ENT_XML1, 'UTF-8') . '</changeofGauge>
                        </equipment>'.
                        
                        $this->flightNotes->flightNotesArray($newSegment['flightNotes'])

                        .'<flownMileageQty>' . htmlspecialchars($newSegment['flownMileageQty'], ENT_XML1, 'UTF-8') . '</flownMileageQty>
                        <iatciFlight>' . htmlspecialchars($newSegment['iatciFlight'], ENT_XML1, 'UTF-8') . '</iatciFlight>
                        <journeyDuration>' . htmlspecialchars($newSegment['journeyDuration'], ENT_XML1, 'UTF-8') . '</journeyDuration>
                        <onTimeRate>' . htmlspecialchars($newSegment['onTimeRate'], ENT_XML1, 'UTF-8') . '</onTimeRate>
                        <remark>' . htmlspecialchars($newSegment['remark'], ENT_XML1, 'UTF-8') . '</remark>
                        <secureFlightDataRequired>' . htmlspecialchars($newSegment['secureFlightDataRequired'], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                        <stopQuantity>' . htmlspecialchars($newSegment['stopQuantity'], ENT_XML1, 'UTF-8') . '</stopQuantity>
                        <ticketType>' . htmlspecialchars($newSegment['ticketType'], ENT_XML1, 'UTF-8') . '</ticketType>
                    </flightSegment>
                    <involuntaryPermissionGiven/>
                    <sequenceNumber/>
                </bookFlightSegment>';
        }
    }

    public function reissuePnrCommit (
        $ID, 
        $referenceID, 
        $bookingClassCabinOne, 
        $bookingClassResBookDesigCodeOne, 
        $bookingClassResBookDesigQuantityOne, 
        $bookignClassResBookDesigStatusCodeOne, 
        $fareInfoCabinOne, 
        $fareInfocabinClassCodeOne,
        $fareInfoCabinAllowanceTypeOne,
        $maxAllowedPiecesOne,
        $unitOfMeasureCodeOne,
        $weightOne,
        $fareGroupNameOne,
        $fareReferenceCodeOne,
        $fareReferenceIDOne,
        $fareReferenceNameOne,
        $flightSegmentSequenceOne,
        $portTaxOne,
        $resBookDesigCodeOne,
        $airlineCodeOne,
        $airlinecompanyFullNameOne,
        $arrivalAirportCityLocationCodeOne,
        $arrivalAirportCityLocationNameOne,
        $arrivalAirportLocationNameLanguageOne,
        $arrivalAirportCountryLocationCodeOne,
        $arrivalAirportCountryLocationNameOne,
        $arrivalAirportCountryLocationNameLanguageOne,
        $arrivalAirportCountryCurrencyCodeOne,
        $arrivalAirportCodeContextOne,
        $arrivalAirportLanguageOne,
        $arrivalAirportLocationCodeOne,
        $arrivalAirportLocationNameOne,
        $arrivalAirportTimeZoneInfoOne,
        $arrivalDateTimeOne,
        $arrivalDateTimeUTCOne,
        $departureAirportCityLocationCodeOne,
        $departureAirportCityLocationNameOne,
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCodeOne,
        $departureAirportCountryLocationNameOne,
        $departureAirportCountryLocationNameLanguageOne,
        $departureAirportCountryCodeOne,
        $departureAirportCodeContextOne,
        $departureAirportLanguageOne,
        $departureAirportLocationCodeOne,
        $departureAirportLocationNameOne,
        $departureTimeZoneInfoOne,
        $departureDateTimeOne,
        $departureDateTimeUTCOne,
        $flightNumberOne,
        $flightSegmentIDOne,
        $ondControlledOne,
        $sectorOne,
        $codeShareOne,
        $distanceOne,
        $equipmentAirEquipTypeOne,
        $equipmentChangeOfGaugeOne,
        $flightNotesOne,
        $flownMileageQtyOne,
        $iatciFlightOne,
        $journeyDurationOne,
        $onTimeRateOne,
        $remarkOne,
        $secureFlightDataRequiredOne,
        $stopQuantityOne,
        $ticketTypeOne,
        $actionCodeTwo,
        $addOnSegmentTwo,
        $bookingClassCabinTwo,
        $bookingCabinResBookDesigCodeTwo,
        $bookingCabinResBookDesigQuantityTwo,
        $fareInfoCabinTwo,
        $fareInfoCabinClassCodeTwo,
        $allowanceTypeTwo,
        $maxAllowedPiecesTwo,
        $unitOfMeasureCodeTwo,
        $weightTwo,
        $fareGroupNameTwo,
        $fareReferenceCodeTwo,
        $fareReferenceIDTwo,
        $fareReferenceNameTwo,
        $flightSegmentSequenceTwo,
        $resBookDesigCodeTwo,
        $airlineCodeTwo,
        $airlineCodeContextTwo,
        $arrivalAirportCityLocationCodeTwo,
        $arrivalAirportCityLocationNameTwo,
        $arrivalAirportCityLocationNameLanguageTwo,
        $arrivalAirportCountryLocationCodeTwo,
        $arrivalAirportCountryLocationNameTwo,
        $arrivalAirportLocationNameLanguageTwo,
        $arrivalAirportCountryCodeTwo,
        $arrivalAirportCodeContextTwo,
        $arrivalAirportLanguageTwo,
        $arrivalAirportLocationCodeTwo,
        $arrivalAirportLocationNameTwo,
        $arrivalAirportTerminalTwo,
        $arrivalAirportTimeZoneInfoTwo,
        $arrivalDateTimeTwo,
        $arrivalDateTimeUTCTwo,
        $departureAirportCityLocationCodeTwo,
        $departureAirportCityLocationNameTwo,
        $departureAirportCityLocationNameLanguageTwo,
        $departureAirportCountryLocationCodeTwo,
        $departureAirportCountryLocationNameTwo,
        $departureAirportLocationNameLanguageTwo,
        $departureAirportCountryCurrencyCodeTwo,
        $departureAirportCodeContextTwo,
        $departureAirportLanguageTwo,
        $departureAirportLocationCodeTwo,
        $departureAirportLocationNameTwo,
        $departureAirportTimeZoneInfoTwo,
        $departureDateTimeTwo,
        $departureDateTimeUTCTwo,
        $flightNumberTwo,
        $flightSegmentIDTwo,
        $ondControlledTwo,
        $sectorTwo,
        $codeShareTwo,
        $distanceTwo,
        $equipmentAirEquipTypeTwo,
        $equipmentChangeOfGaugeTwo,
        $flightNotesTwo,
        $flownMileageQtyTwo,
        $iatciFlightTwo,
        $journeyDurationTwo,
        $onTimeRateTwo,
        $remarkTwo,
        $secureFlightDataRequiredTwo,
        $segmentStatusByFirstLegTwo,
        $stopQuantityTwo,
        $involuntaryPermissionGivenTwo,
        $legStatusTwo,
        $referenceIDTwo,
        $responseCodeTwo,
        $sequenceNumberTwo,
        $statusTwo
    ) {
        
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <fullfillment>
                        <paymentDetails>
                            <paymentDetailList>
                                <miscChargeOrder>
                                    <avsEnabled/>
                                    <capturePaymentToolNumber>false</capturePaymentToolNumber>
                                    <paymentCode>INV</paymentCode>
                                    <threeDomainSecurityEligible>false</threeDomainSecurityEligible>
                                    <transactionFeeApplies/>
                                    <MCONumber>4010026732</MCONumber>
                                </miscChargeOrder>
                                <payLater/>
                                <paymentAmount>
                                <currency>
                                    <code>NGN</code>
                                </currency>
                                <mileAmount/>
                                <value>124904.0</value>
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
                                <cabin>' . htmlspecialchars($bookingClassCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityOne, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                <resBookDesigStatusCode>' . htmlspecialchars($bookignClassResBookDesigStatusCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                            </bookingClass>
                            <fareInfo> 
                                <cabin>' . htmlspecialchars($fareInfoCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfocabinClassCodeOne, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance> 
                                    <allowanceType>' . htmlspecialchars($fareInfoCabinAllowanceTypeOne, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesOne, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeOne, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightOne, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameOne, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeOne, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDOne, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameOne, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <portTax>' . htmlspecialchars($portTaxOne, ENT_XML1, 'UTF-8') . '</portTax>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                    <companyFullName>' . htmlspecialchars($airlinecompanyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeOne, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($departureAirportCountryCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberOne, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDOne, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledOne, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorOne, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareOne, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceOne, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeOne, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeOne, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                
                                $this->flightNotes->flightNotesArray($flightNotesOne)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyOne, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightOne, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkOne, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredOne, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                                <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                            </flightSegment>
                            <involuntaryPermissionGiven/>
                            <sequenceNumber/>
                        </bookFlightSegment>
                    </newSegments>
                    <oldSegments>
                    <!-- Zero or more repetitions: -->
                    <bookFlightSegment>
                        <actionCode>' . htmlspecialchars($actionCodeTwo, ENT_XML1, 'UTF-8') . '</actionCode>
                        <addOnSegment>' . htmlspecialchars($addOnSegmentTwo, ENT_XML1, 'UTF-8') . '</addOnSegment>
                        <bookingClass>
                            <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                            <resBookDesigCode>' . htmlspecialchars($bookingCabinResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            <resBookDesigQuantity>' . htmlspecialchars($bookingCabinResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                        </bookingClass>
                        <fareInfo>
                            <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                            <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                            <fareBaggageAllowance>
                                <allowanceType>' . htmlspecialchars($allowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                                <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                <maxAllowedWeight>
                                    <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                    <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                                </maxAllowedWeight>
                            </fareBaggageAllowance>
                            <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                            <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                            <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                            <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                            <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                            <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                        </fareInfo>
                        <flightSegment>
                            <airline>
                                <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                <codeContext>' . htmlspecialchars($airlineCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                            </airline>
                            <arrivalAirport>
                                <cityInfo>
                                    <city>
                                        <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    </city>
                                    <country>
                                        <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        <currency>
                                        <code>' . htmlspecialchars($arrivalAirportCountryCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                        </currency>
                                    </country>
                                </cityInfo>
                                <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                <terminal>' . htmlspecialchars($arrivalAirportTerminalTwo, ENT_XML1, 'UTF-8') . '</terminal>
                                <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                            </arrivalAirport>
                            <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                            <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                            <departureAirport>
                                <cityInfo>
                                <city>
                                    <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                </city>
                                <country>
                                    <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <locationNameLanguage>' . htmlspecialchars($departureAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    <currency>
                                        <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                    </currency>
                                </country>
                                </cityInfo>
                                <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                            </departureAirport>
                            <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                            <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                            <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                            <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                            <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                            <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                            <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                            <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                            <equipment>
                                <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                                <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                            </equipment>'.
                                
                                $this->flightNotes->flightNotesArray($flightNotesTwo)

                            .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                            <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                            <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                            <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                            <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                            <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                            <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLegTwo, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                            <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                        </flightSegment>
                        <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGivenTwo, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                        <legStatus>' . htmlspecialchars($legStatusTwo, ENT_XML1, 'UTF-8') . '</legStatus>
                        <referenceID>' . htmlspecialchars($referenceIDTwo, ENT_XML1, 'UTF-8') . '</referenceID>
                        <responseCode>' . htmlspecialchars($responseCodeTwo, ENT_XML1, 'UTF-8') . '</responseCode>
                        <sequenceNumber>' . htmlspecialchars($sequenceNumberTwo, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                        <status>' . htmlspecialchars($statusTwo, ENT_XML1, 'UTF-8') . '</status>
                    </bookFlightSegment>
                    </oldSegments>
                </ReissuePnrCommitRequest>
            </impl:ReissuePnrCommit>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;

    }


    public function reissuePnrAddFlightPreview(
        $ID, 
        $referenceID, 
        $bookingClassCabinOne, 
        $bookingClassResBookDesigCodeOne, 
        $bookingClassResBookDesigQuantityOne, 
        $bookignClassResBookDesigStatusCodeOne, 
        $fareInfoCabinOne, 
        $fareInfocabinClassCodeOne,
        $fareInfoCabinAllowanceTypeOne,
        $maxAllowedPiecesOne,
        $unitOfMeasureCodeOne,
        $weightOne,
        $fareGroupNameOne,
        $fareReferenceCodeOne,
        $fareReferenceIDOne,
        $fareReferenceNameOne,
        $flightSegmentSequenceOne,
        $portTaxOne,
        $resBookDesigCodeOne,
        $airlineCodeOne,
        $airlinecompanyFullNameOne,
        $arrivalAirportCityLocationCodeOne,
        $arrivalAirportCityLocationNameOne,
        $arrivalAirportLocationNameLanguageOne,
        $arrivalAirportCountryLocationCodeOne,
        $arrivalAirportCountryLocationNameOne,
        $arrivalAirportCountryLocationNameLanguageOne,
        $arrivalAirportCountryCurrencyCodeOne,
        $arrivalAirportCodeContextOne,
        $arrivalAirportLanguageOne,
        $arrivalAirportLocationCodeOne,
        $arrivalAirportLocationNameOne,
        $arrivalAirportTimeZoneInfoOne,
        $arrivalDateTimeOne,
        $arrivalDateTimeUTCOne,
        $departureAirportCityLocationCodeOne,
        $departureAirportCityLocationNameOne,
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCodeOne,
        $departureAirportCountryLocationNameOne,
        $departureAirportCountryLocationNameLanguageOne,
        $departureAirportCountryCodeOne,
        $departureAirportCodeContextOne,
        $departureAirportLanguageOne,
        $departureAirportLocationCodeOne,
        $departureAirportLocationNameOne,
        $departureTimeZoneInfoOne,
        $departureDateTimeOne,
        $departureDateTimeUTCOne,
        $flightNumberOne,
        $flightSegmentIDOne,
        $ondControlledOne,
        $sectorOne,
        $codeShareOne,
        $distanceOne,
        $equipmentAirEquipTypeOne,
        $equipmentChangeOfGaugeOne,
        $flightNotesOne,
        $flownMileageQtyOne,
        $iatciFlightOne,
        $journeyDurationOne,
        $onTimeRateOne,
        $remarkOne,
        $secureFlightDataRequiredOne,
        $stopQuantityOne,
        $ticketTypeOne

    ) {

        // dd($flightNotesOne);
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <newSegments>
                        <bookFlightSegment>
                            <addOnSegment/>
                            <bookingClass> 
                                <cabin>' . htmlspecialchars($bookingClassCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityOne, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                <resBookDesigStatusCode>' . htmlspecialchars($bookignClassResBookDesigStatusCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                            </bookingClass>
                            <fareInfo> 
                                <cabin>' . htmlspecialchars($fareInfoCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfocabinClassCodeOne, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance> 
                                    <allowanceType>' . htmlspecialchars($fareInfoCabinAllowanceTypeOne, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesOne, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeOne, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightOne, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameOne, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeOne, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDOne, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameOne, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <portTax>' . htmlspecialchars($portTaxOne, ENT_XML1, 'UTF-8') . '</portTax>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                    <companyFullName>' . htmlspecialchars($airlinecompanyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeOne, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($departureAirportCountryCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberOne, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDOne, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledOne, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorOne, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareOne, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceOne, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeOne, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeOne, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                
                                $this->flightNotes->flightNotesArray($flightNotesOne)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyOne, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightOne, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkOne, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredOne, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                                <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                            </flightSegment>
                            <involuntaryPermissionGiven/>
                            <sequenceNumber/>
                        </bookFlightSegment>
                    </newSegments>
                </ReissuePnrPreviewRequest>
            </impl:ReissuePnrPreview>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }

    public function reissuePnrAddFlightCommit(
        $ID, 
        $referenceID, 
        $bookingClassCabinOne, 
        $bookingClassResBookDesigCodeOne, 
        $bookingClassResBookDesigQuantityOne, 
        $bookignClassResBookDesigStatusCodeOne, 
        $fareInfoCabinOne, 
        $fareInfocabinClassCodeOne,
        $fareInfoCabinAllowanceTypeOne,
        $maxAllowedPiecesOne,
        $unitOfMeasureCodeOne,
        $weightOne,
        $fareGroupNameOne,
        $fareReferenceCodeOne,
        $fareReferenceIDOne,
        $fareReferenceNameOne,
        $flightSegmentSequenceOne,
        $portTaxOne,
        $resBookDesigCodeOne,
        $airlineCodeOne,
        $airlinecompanyFullNameOne,
        $arrivalAirportCityLocationCodeOne,
        $arrivalAirportCityLocationNameOne,
        $arrivalAirportLocationNameLanguageOne,
        $arrivalAirportCountryLocationCodeOne,
        $arrivalAirportCountryLocationNameOne,
        $arrivalAirportCountryLocationNameLanguageOne,
        $arrivalAirportCountryCurrencyCodeOne,
        $arrivalAirportCodeContextOne,
        $arrivalAirportLanguageOne,
        $arrivalAirportLocationCodeOne,
        $arrivalAirportLocationNameOne,
        $arrivalAirportTimeZoneInfoOne,
        $arrivalDateTimeOne,
        $arrivalDateTimeUTCOne,
        $departureAirportCityLocationCodeOne,
        $departureAirportCityLocationNameOne,
        $departureAirportCityLocationNameLanguage,
        $departureAirportCountryLocationCodeOne,
        $departureAirportCountryLocationNameOne,
        $departureAirportCountryLocationNameLanguageOne,
        $departureAirportCountryCodeOne,
        $departureAirportCodeContextOne,
        $departureAirportLanguageOne,
        $departureAirportLocationCodeOne,
        $departureAirportLocationNameOne,
        $departureTimeZoneInfoOne,
        $departureDateTimeOne,
        $departureDateTimeUTCOne,
        $flightNumberOne,
        $flightSegmentIDOne,
        $ondControlledOne,
        $sectorOne,
        $codeShareOne,
        $distanceOne,
        $equipmentAirEquipTypeOne,
        $equipmentChangeOfGaugeOne,
        $flightNotesOne,
        $flownMileageQtyOne,
        $iatciFlightOne,
        $journeyDurationOne,
        $onTimeRateOne,
        $remarkOne,
        $secureFlightDataRequiredOne,
        $stopQuantityOne,
        $ticketTypeOne
    ) {
        
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <fullfillment>
                        <paymentDetails>
                            <paymentDetailList>
                                <miscChargeOrder>
                                    <avsEnabled/>
                                    <capturePaymentToolNumber>false</capturePaymentToolNumber>
                                    <paymentCode>INV</paymentCode>
                                    <threeDomainSecurityEligible>false</threeDomainSecurityEligible>
                                    <transactionFeeApplies/>
                                    <MCONumber>4010026732</MCONumber>
                                </miscChargeOrder>
                                <payLater/>
                                <paymentAmount>
                                <currency>
                                    <code>NGN</code>
                                </currency>
                                <mileAmount/>
                                <value>187904.0</value>
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
                                <cabin>' . htmlspecialchars($bookingClassCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingClassResBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingClassResBookDesigQuantityOne, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                <resBookDesigStatusCode>' . htmlspecialchars($bookignClassResBookDesigStatusCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigStatusCode>
                            </bookingClass>
                            <fareInfo> 
                                <cabin>' . htmlspecialchars($fareInfoCabinOne, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfocabinClassCodeOne, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance> 
                                    <allowanceType>' . htmlspecialchars($fareInfoCabinAllowanceTypeOne, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesOne, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeOne, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightOne, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameOne, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeOne, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDOne, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameOne, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceOne, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <portTax>' . htmlspecialchars($portTaxOne, ENT_XML1, 'UTF-8') . '</portTax>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeOne, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                    <companyFullName>' . htmlspecialchars($airlinecompanyFullNameOne, ENT_XML1, 'UTF-8') . '</companyFullName>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                                <code>' . htmlspecialchars($arrivalAirportCountryCurrencyCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeOne, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCityLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguage, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($departureAirportCountryLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($departureAirportCountryLocationNameLanguageOne, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($departureAirportCountryCodeOne, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextOne, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageOne, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeOne, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameOne, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureTimeZoneInfoOne, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeOne, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCOne, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberOne, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDOne, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledOne, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorOne, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareOne, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceOne, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeOne, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeOne, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                
                                $this->flightNotes->flightNotesArray($flightNotesOne)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyOne, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightOne, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationOne, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateOne, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkOne, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredOne, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <stopQuantity>' . htmlspecialchars($stopQuantityOne, ENT_XML1, 'UTF-8') . '</stopQuantity>
                                <ticketType>' . htmlspecialchars($ticketTypeOne, ENT_XML1, 'UTF-8') . '</ticketType>
                            </flightSegment>
                            <involuntaryPermissionGiven/>
                            <sequenceNumber/>
                        </bookFlightSegment>
                    </newSegments>
                </ReissuePnrCommitRequest>
            </impl:ReissuePnrCommit>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;

    }


    public function reissuePnrCancelFlightPreview(
        $ID, 
        $referenceID,
        $actionCodeTwo,
        $addOnSegmentTwo,
        $bookingClassCabinTwo,
        $bookingCabinResBookDesigCodeTwo,
        $bookingCabinResBookDesigQuantityTwo,
        $fareInfoCabinTwo,
        $fareInfoCabinClassCodeTwo,
        $allowanceTypeTwo,
        $maxAllowedPiecesTwo,
        $unitOfMeasureCodeTwo,
        $weightTwo,
        $fareGroupNameTwo,
        $fareReferenceCodeTwo,
        $fareReferenceIDTwo,
        $fareReferenceNameTwo,
        $flightSegmentSequenceTwo,
        $resBookDesigCodeTwo,
        $airlineCodeTwo,
        $airlineCodeContextTwo,
        $arrivalAirportCityLocationCodeTwo,
        $arrivalAirportCityLocationNameTwo,
        $arrivalAirportCityLocationNameLanguageTwo,
        $arrivalAirportCountryLocationCodeTwo,
        $arrivalAirportCountryLocationNameTwo,
        $arrivalAirportLocationNameLanguageTwo,
        $arrivalAirportCountryCodeTwo,
        $arrivalAirportCodeContextTwo,
        $arrivalAirportLanguageTwo,
        $arrivalAirportLocationCodeTwo,
        $arrivalAirportLocationNameTwo,
        $arrivalAirportTerminalTwo,
        $arrivalAirportTimeZoneInfoTwo,
        $arrivalDateTimeTwo,
        $arrivalDateTimeUTCTwo,
        $departureAirportCityLocationCodeTwo,
        $departureAirportCityLocationNameTwo,
        $departureAirportCityLocationNameLanguageTwo,
        $departureAirportCountryLocationCodeTwo,
        $departureAirportCountryLocationNameTwo,
        $departureAirportLocationNameLanguageTwo,
        $departureAirportCountryCurrencyCodeTwo,
        $departureAirportCodeContextTwo,
        $departureAirportLanguageTwo,
        $departureAirportLocationCodeTwo,
        $departureAirportLocationNameTwo,
        $departureAirportTimeZoneInfoTwo,
        $departureDateTimeTwo,
        $departureDateTimeUTCTwo,
        $flightNumberTwo,
        $flightSegmentIDTwo,
        $ondControlledTwo,
        $sectorTwo,
        $codeShareTwo,
        $distanceTwo,
        $equipmentAirEquipTypeTwo,
        $equipmentChangeOfGaugeTwo,
        $flightNotesTwo,
        $flownMileageQtyTwo,
        $iatciFlightTwo,
        $journeyDurationTwo,
        $onTimeRateTwo,
        $remarkTwo,
        $secureFlightDataRequiredTwo,
        $segmentStatusByFirstLegTwo,
        $stopQuantityTwo,
        $involuntaryPermissionGivenTwo,
        $legStatusTwo,
        $referenceIDTwo,
        $responseCodeTwo,
        $sequenceNumberTwo,
        $statusTwo

    ) {
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <oldSegments>
                        <!-- Zero or more repetitions: -->
                        <bookFlightSegment>
                            <actionCode>' . htmlspecialchars($actionCodeTwo, ENT_XML1, 'UTF-8') . '</actionCode>
                            <addOnSegment>' . htmlspecialchars($addOnSegmentTwo, ENT_XML1, 'UTF-8') . '</addOnSegment>
                            <bookingClass>
                                <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingCabinResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingCabinResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                            </bookingClass>
                            <fareInfo>
                                <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance>
                                    <allowanceType>' . htmlspecialchars($allowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                    <codeContext>' . htmlspecialchars($airlineCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($arrivalAirportCountryCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <terminal>' . htmlspecialchars($arrivalAirportTerminalTwo, ENT_XML1, 'UTF-8') . '</terminal>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                    <city>
                                        <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    </city>
                                    <country>
                                        <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($departureAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        <currency>
                                            <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                        </currency>
                                    </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                    
                                    $this->flightNotes->flightNotesArray($flightNotesTwo)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLegTwo, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                            </flightSegment>
                            <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGivenTwo, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                            <legStatus>' . htmlspecialchars($legStatusTwo, ENT_XML1, 'UTF-8') . '</legStatus>
                            <referenceID>' . htmlspecialchars($referenceIDTwo, ENT_XML1, 'UTF-8') . '</referenceID>
                            <responseCode>' . htmlspecialchars($responseCodeTwo, ENT_XML1, 'UTF-8') . '</responseCode>
                            <sequenceNumber>' . htmlspecialchars($sequenceNumberTwo, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                            <status>' . htmlspecialchars($statusTwo, ENT_XML1, 'UTF-8') . '</status>
                        </bookFlightSegment>
                    </oldSegments>
                </ReissuePnrPreviewRequest>
            </impl:ReissuePnrPreview>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }


    public function reissuePnrCancelFlightCommit (
        $ID, 
        $referenceID,
        $actionCodeTwo,
        $addOnSegmentTwo,
        $bookingClassCabinTwo,
        $bookingCabinResBookDesigCodeTwo,
        $bookingCabinResBookDesigQuantityTwo,
        $fareInfoCabinTwo,
        $fareInfoCabinClassCodeTwo,
        $allowanceTypeTwo,
        $maxAllowedPiecesTwo,
        $unitOfMeasureCodeTwo,
        $weightTwo,
        $fareGroupNameTwo,
        $fareReferenceCodeTwo,
        $fareReferenceIDTwo,
        $fareReferenceNameTwo,
        $flightSegmentSequenceTwo,
        $resBookDesigCodeTwo,
        $airlineCodeTwo,
        $airlineCodeContextTwo,
        $arrivalAirportCityLocationCodeTwo,
        $arrivalAirportCityLocationNameTwo,
        $arrivalAirportCityLocationNameLanguageTwo,
        $arrivalAirportCountryLocationCodeTwo,
        $arrivalAirportCountryLocationNameTwo,
        $arrivalAirportLocationNameLanguageTwo,
        $arrivalAirportCountryCodeTwo,
        $arrivalAirportCodeContextTwo,
        $arrivalAirportLanguageTwo,
        $arrivalAirportLocationCodeTwo,
        $arrivalAirportLocationNameTwo,
        $arrivalAirportTerminalTwo,
        $arrivalAirportTimeZoneInfoTwo,
        $arrivalDateTimeTwo,
        $arrivalDateTimeUTCTwo,
        $departureAirportCityLocationCodeTwo,
        $departureAirportCityLocationNameTwo,
        $departureAirportCityLocationNameLanguageTwo,
        $departureAirportCountryLocationCodeTwo,
        $departureAirportCountryLocationNameTwo,
        $departureAirportLocationNameLanguageTwo,
        $departureAirportCountryCurrencyCodeTwo,
        $departureAirportCodeContextTwo,
        $departureAirportLanguageTwo,
        $departureAirportLocationCodeTwo,
        $departureAirportLocationNameTwo,
        $departureAirportTimeZoneInfoTwo,
        $departureDateTimeTwo,
        $departureDateTimeUTCTwo,
        $flightNumberTwo,
        $flightSegmentIDTwo,
        $ondControlledTwo,
        $sectorTwo,
        $codeShareTwo,
        $distanceTwo,
        $equipmentAirEquipTypeTwo,
        $equipmentChangeOfGaugeTwo,
        $flightNotesTwo,
        $flownMileageQtyTwo,
        $iatciFlightTwo,
        $journeyDurationTwo,
        $onTimeRateTwo,
        $remarkTwo,
        $secureFlightDataRequiredTwo,
        $segmentStatusByFirstLegTwo,
        $stopQuantityTwo,
        $involuntaryPermissionGivenTwo,
        $legStatusTwo,
        $referenceIDTwo,
        $responseCodeTwo,
        $sequenceNumberTwo,
        $statusTwo
    ) {
        
        $xml  = '<?xml version="1.0" encoding="UTF-8"?>
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
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <fullfillment>
                        <paymentDetails>
                            <paymentDetailList>
                                <miscChargeOrder>
                                    <avsEnabled/>
                                    <capturePaymentToolNumber>false</capturePaymentToolNumber>
                                    <paymentCode>INV</paymentCode>
                                    <threeDomainSecurityEligible>false</threeDomainSecurityEligible>
                                    <transactionFeeApplies/>
                                    <MCONumber>4010026732</MCONumber>
                                </miscChargeOrder>
                                <payLater/>
                                <paymentAmount>
                                <currency>
                                    <code>NGN</code>
                                </currency>
                                <mileAmount/>
                                <value>124904.0</value>
                                </paymentAmount>
                                <paymentType>MISC_CHARGE_ORDER</paymentType>
                                <primaryPayment>true</primaryPayment>
                            </paymentDetailList>
                        </paymentDetails>
                    </fullfillment>
                    <oldSegments>
                        <!-- Zero or more repetitions: -->
                        <bookFlightSegment>
                            <actionCode>' . htmlspecialchars($actionCodeTwo, ENT_XML1, 'UTF-8') . '</actionCode>
                            <addOnSegment>' . htmlspecialchars($addOnSegmentTwo, ENT_XML1, 'UTF-8') . '</addOnSegment>
                            <bookingClass>
                                <cabin>' . htmlspecialchars($bookingClassCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <resBookDesigCode>' . htmlspecialchars($bookingCabinResBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                <resBookDesigQuantity>' . htmlspecialchars($bookingCabinResBookDesigQuantityTwo, ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                            </bookingClass>
                            <fareInfo>
                                <cabin>' . htmlspecialchars($fareInfoCabinTwo, ENT_XML1, 'UTF-8') . '</cabin>
                                <cabinClassCode>' . htmlspecialchars($fareInfoCabinClassCodeTwo, ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                <fareBaggageAllowance>
                                    <allowanceType>' . htmlspecialchars($allowanceTypeTwo, ENT_XML1, 'UTF-8') . '</allowanceType>
                                    <maxAllowedPieces>' . htmlspecialchars($maxAllowedPiecesTwo, ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                    <maxAllowedWeight>
                                        <unitOfMeasureCode>' . htmlspecialchars($unitOfMeasureCodeTwo, ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                        <weight>' . htmlspecialchars($weightTwo, ENT_XML1, 'UTF-8') . '</weight>
                                    </maxAllowedWeight>
                                </fareBaggageAllowance>
                                <fareGroupName>' . htmlspecialchars($fareGroupNameTwo, ENT_XML1, 'UTF-8') . '</fareGroupName>
                                <fareReferenceCode>' . htmlspecialchars($fareReferenceCodeTwo, ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                <fareReferenceID>' . htmlspecialchars($fareReferenceIDTwo, ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                <fareReferenceName>' . htmlspecialchars($fareReferenceNameTwo, ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                <flightSegmentSequence>' . htmlspecialchars($flightSegmentSequenceTwo, ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                <resBookDesigCode>' . htmlspecialchars($resBookDesigCodeTwo, ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                            </fareInfo>
                            <flightSegment>
                                <airline>
                                    <code>' . htmlspecialchars($airlineCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                    <codeContext>' . htmlspecialchars($airlineCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                </airline>
                                <arrivalAirport>
                                    <cityInfo>
                                        <city>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        </city>
                                        <country>
                                            <locationCode>' . htmlspecialchars($arrivalAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                            <locationName>' . htmlspecialchars($arrivalAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                            <locationNameLanguage>' . htmlspecialchars($arrivalAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                            <currency>
                                            <code>' . htmlspecialchars($arrivalAirportCountryCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                            </currency>
                                        </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($arrivalAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($arrivalAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($arrivalAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($arrivalAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <terminal>' . htmlspecialchars($arrivalAirportTerminalTwo, ENT_XML1, 'UTF-8') . '</terminal>
                                    <timeZoneInfo>' . htmlspecialchars($arrivalAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </arrivalAirport>
                                <arrivalDateTime>' . htmlspecialchars($arrivalDateTimeTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                <arrivalDateTimeUTC>' . htmlspecialchars($arrivalDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                <departureAirport>
                                    <cityInfo>
                                    <city>
                                        <locationCode>' . htmlspecialchars($departureAirportCityLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($departureAirportCityLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($departureAirportCityLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                    </city>
                                    <country>
                                        <locationCode>' . htmlspecialchars($departureAirportCountryLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                        <locationName>' . htmlspecialchars($departureAirportCountryLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                        <locationNameLanguage>' . htmlspecialchars($departureAirportLocationNameLanguageTwo, ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                        <currency>
                                            <code>' . htmlspecialchars($departureAirportCountryCurrencyCodeTwo, ENT_XML1, 'UTF-8') . '</code>
                                        </currency>
                                    </country>
                                    </cityInfo>
                                    <codeContext>' . htmlspecialchars($departureAirportCodeContextTwo, ENT_XML1, 'UTF-8') . '</codeContext>
                                    <language>' . htmlspecialchars($departureAirportLanguageTwo, ENT_XML1, 'UTF-8') . '</language>
                                    <locationCode>' . htmlspecialchars($departureAirportLocationCodeTwo, ENT_XML1, 'UTF-8') . '</locationCode>
                                    <locationName>' . htmlspecialchars($departureAirportLocationNameTwo, ENT_XML1, 'UTF-8') . '</locationName>
                                    <timeZoneInfo>' . htmlspecialchars($departureAirportTimeZoneInfoTwo, ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                </departureAirport>
                                <departureDateTime>' . htmlspecialchars($departureDateTimeTwo, ENT_XML1, 'UTF-8') . '</departureDateTime>
                                <departureDateTimeUTC>' . htmlspecialchars($departureDateTimeUTCTwo, ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                <flightNumber>' . htmlspecialchars($flightNumberTwo, ENT_XML1, 'UTF-8') . '</flightNumber>
                                <flightSegmentID>' . htmlspecialchars($flightSegmentIDTwo, ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                <ondControlled>' . htmlspecialchars($ondControlledTwo, ENT_XML1, 'UTF-8') . '</ondControlled>
                                <sector>' . htmlspecialchars($sectorTwo, ENT_XML1, 'UTF-8') . '</sector>
                                <codeshare>' . htmlspecialchars($codeShareTwo, ENT_XML1, 'UTF-8') . '</codeshare>
                                <distance>' . htmlspecialchars($distanceTwo, ENT_XML1, 'UTF-8') . '</distance>
                                <equipment>
                                    <airEquipType>' . htmlspecialchars($equipmentAirEquipTypeTwo, ENT_XML1, 'UTF-8') . '</airEquipType>
                                    <changeofGauge>' . htmlspecialchars($equipmentChangeOfGaugeTwo, ENT_XML1, 'UTF-8') . '</changeofGauge>
                                </equipment>'.
                                    
                                    $this->flightNotes->flightNotesArray($flightNotesTwo)

                                .'<flownMileageQty>' . htmlspecialchars($flownMileageQtyTwo, ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                <iatciFlight>' . htmlspecialchars($iatciFlightTwo, ENT_XML1, 'UTF-8') . '</iatciFlight>
                                <journeyDuration>' . htmlspecialchars($journeyDurationTwo, ENT_XML1, 'UTF-8') . '</journeyDuration>
                                <onTimeRate>' . htmlspecialchars($onTimeRateTwo, ENT_XML1, 'UTF-8') . '</onTimeRate>
                                <remark>' . htmlspecialchars($remarkTwo, ENT_XML1, 'UTF-8') . '</remark>
                                <secureFlightDataRequired>' . htmlspecialchars($secureFlightDataRequiredTwo, ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                <segmentStatusByFirstLeg>' . htmlspecialchars($segmentStatusByFirstLegTwo, ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                <stopQuantity>' . htmlspecialchars($stopQuantityTwo, ENT_XML1, 'UTF-8') . '</stopQuantity>
                            </flightSegment>
                            <involuntaryPermissionGiven>' . htmlspecialchars($involuntaryPermissionGivenTwo, ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                            <legStatus>' . htmlspecialchars($legStatusTwo, ENT_XML1, 'UTF-8') . '</legStatus>
                            <referenceID>' . htmlspecialchars($referenceIDTwo, ENT_XML1, 'UTF-8') . '</referenceID>
                            <responseCode>' . htmlspecialchars($responseCodeTwo, ENT_XML1, 'UTF-8') . '</responseCode>
                            <sequenceNumber>' . htmlspecialchars($sequenceNumberTwo, ENT_XML1, 'UTF-8') . '</sequenceNumber>
                            <status>' . htmlspecialchars($statusTwo, ENT_XML1, 'UTF-8') . '</status>
                        </bookFlightSegment>
                    </oldSegments>
                </ReissuePnrCommitRequest>
            </impl:ReissuePnrCommit>
        </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;

    }
}