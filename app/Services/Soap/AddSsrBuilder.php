<?php

namespace App\Services\Soap;

use App\Http\Requests\Soap\AddSsrRequest;
use App\Services\Utility\FlightNotes;

class AddSsrBuilder {


   protected $flightNotes;
   protected $craneUsername;
   protected $cranePassword;

   public function __construct(FlightNotes $flightNote) {
      $this->flightNotes = $flightNote;
      $this->craneUsername = config('app.crane.username');		
		$this->cranePassword = config('app.crane.password');

   }

   public function addSsr(AddSsrRequest $request) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
               <impl:AddSsr>
               <AddSsrRequest>
               <clientInformation>
               <clientIP>129.0.0.1</clientIP>
               <member>false</member>
               <password>' . htmlspecialchars($this->cranePassword, ENT_XML1, 'UTF-8') . '</password>
               <userName>' . htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') . '</userName>
               <preferredCurrency>' . htmlspecialchars($request->input('preferredCurrency'), ENT_XML1, 'UTF-8') . '</preferredCurrency>
               </clientInformation>
                  <airItinerary>
                     <adviceCodeSegmentExist>' . htmlspecialchars($request->input('adviceCodeSegmentExist'), ENT_XML1, 'UTF-8') . '</adviceCodeSegmentExist>
                        <bookOriginDestinationOptions>
                           <bookOriginDestinationOptionList>
                              <bookFlightSegmentList>
                                 <actionCode>' . htmlspecialchars($request->input('bookFlightSegmentListActionCode'), ENT_XML1, 'UTF-8') . '</actionCode>
                                 <addOnSegment>' . htmlspecialchars($request->input('bookFlightAddOnSegment'), ENT_XML1, 'UTF-8') . '</addOnSegment>
                                 <bookingClass>
                                    <cabin>' . htmlspecialchars($request->input('bookingClassCabin'), ENT_XML1, 'UTF-8') . '</cabin>
                                    <resBookDesigCode>' . htmlspecialchars($request->input('bookingClassResBookDesigCode'), ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                    <resBookDesigQuantity>' . htmlspecialchars($request->input('resBookDesignQuantity'), ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                                 </bookingClass>
                                 <fareInfo>
                                    <cabin>' . htmlspecialchars($request->input('fareInfoCabin'), ENT_XML1, 'UTF-8') . '</cabin>
                                    <cabinClassCode>' . htmlspecialchars($request->input('fareInfoCabinClassCode'), ENT_XML1, 'UTF-8') . '</cabinClassCode>
                                    <fareBaggageAllowance>
                                       <allowanceType>' . htmlspecialchars($request->input('fareBaggageAllowanceType'), ENT_XML1, 'UTF-8') . '</allowanceType>
                                       <maxAllowedPieces>' . htmlspecialchars($request->input('fareBaggageMaxAllowedPieces'), ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                                       <maxAllowedWeight>
                                          <unitOfMeasureCode>' . htmlspecialchars($request->input('unitOfMeasureCode'), ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                                          <weight>' . htmlspecialchars($request->input("fareBaggageAllowanceWeight"), ENT_XML1, 'UTF-8') . '</weight>
                                       </maxAllowedWeight>
                                    </fareBaggageAllowance>
                                    <fareGroupName>' . htmlspecialchars($request->input('fareGroupName'), ENT_XML1, 'UTF-8') . '</fareGroupName>
                                    <fareReferenceCode>' . htmlspecialchars($request->input('fareReferenceCode'), ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                                    <fareReferenceID>' . htmlspecialchars($request->input('fareReferenceID'), ENT_XML1, 'UTF-8') . '</fareReferenceID>
                                    <fareReferenceName>' . htmlspecialchars($request->input('fareReferenceName'), ENT_XML1, 'UTF-8') . '</fareReferenceName>
                                    <flightSegmentSequence>' . htmlspecialchars($request->input('bookFlightSegmentSequence'), ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                                    <resBookDesigCode>' . htmlspecialchars($request->input('resBookDesigCode'), ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                                 </fareInfo>
                                 <flightSegment>
                                    <airline>
                                       <code>' . htmlspecialchars($request->input('flightSegmentCode'), ENT_XML1, 'UTF-8') . '</code>
                                       <codeContext>' . htmlspecialchars($request->input('flightSegmentCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                                    </airline>
                                    <arrivalAirport>
                                       <cityInfo>
                                          <city>
                                             <locationCode>' . htmlspecialchars($request->input('arrivalAirportCityLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($request->input('arrivalAirportCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($request->input('arrivalAirportCityLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                          </city>
                                          <country>
                                             <locationCode>' . htmlspecialchars($request->input('arrivalAirportCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($request->input('arrivalAirportCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($request->input('arrivalAirportCountryLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                             <currency>
                                                <code>' . htmlspecialchars($request->input('arrivalAirportCountryCurrencyCode'), ENT_XML1, 'UTF-8') . '</code>
                                             </currency>
                                          </country>
                                       </cityInfo>
                                       <codeContext>' . htmlspecialchars($request->input('arrivalAirportCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                                       <language>' . htmlspecialchars($request->input('arrivalAirportLanguage'), ENT_XML1, 'UTF-8') . '</language>
                                       <locationCode>' . htmlspecialchars($request->input('arrivalAirportLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                       <locationName>' . htmlspecialchars($request->input('arrivalAirportLocationName'), ENT_XML1, 'UTF-8') . '</locationName>'. 

                                       $this->checkTerminal($request->input('arrivalAirportTerminal'))
                                      
                                       .'<timeZoneInfo>' . htmlspecialchars($request->input('arrivalAirportTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                    </arrivalAirport>
                                    <arrivalDateTime>' . htmlspecialchars($request->input('arrivalDateTime'), ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                                    <arrivalDateTimeUTC>' . htmlspecialchars($request->input('arrivalDateTimeUTC'), ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                                    <departureAirport>
                                       <cityInfo>
                                          <city>
                                             <locationCode>' . htmlspecialchars($request->input('departureAirportCitytLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($request->input('departureAirportCityLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($request->input('departureAirportCityLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                          </city>
                                          <country>
                                             <locationCode>' . htmlspecialchars($request->input('departureAirportCountryLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                             <locationName>' . htmlspecialchars($request->input('departureAirportCountryLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                             <locationNameLanguage>' . htmlspecialchars($request->input('departureCountryLocationNameLanguage'), ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                                             <currency>
                                                <code>' . htmlspecialchars($request->input("departureCountryCurrencyCode"), ENT_XML1, 'UTF-8') . '</code>
                                             </currency>
                                          </country>
                                       </cityInfo>
                                       <codeContext>' . htmlspecialchars($request->input('departureAirportCodeContext'), ENT_XML1, 'UTF-8') . '</codeContext>
                                       <language>' . htmlspecialchars($request->input('departureAirportLanguage'), ENT_XML1, 'UTF-8') . '</language>
                                       <locationCode>' . htmlspecialchars($request->input('departureAirportLocationCode'), ENT_XML1, 'UTF-8') . '</locationCode>
                                       <locationName>' . htmlspecialchars($request->input('departureAirportLocationName'), ENT_XML1, 'UTF-8') . '</locationName>
                                       <timeZoneInfo>' . htmlspecialchars($request->input('departureAirportTimeZoneInfo'), ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                                    </departureAirport>
                                    <departureDateTime>' . htmlspecialchars($request->input('departureDateTime'), ENT_XML1, 'UTF-8') . '</departureDateTime>
                                    <departureDateTimeUTC>' . htmlspecialchars($request->input('departureDateTimeUTC'), ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                                    <flightNumber>' . htmlspecialchars($request->input('flightNumber'), ENT_XML1, 'UTF-8') . '</flightNumber>
                                    <flightSegmentID>' . htmlspecialchars($request->input('flightSegmentID'), ENT_XML1, 'UTF-8') . '</flightSegmentID>
                                    <ondControlled>' . htmlspecialchars($request->input('ondControlled'), ENT_XML1, 'UTF-8') . '</ondControlled>
                                    <sector>' . htmlspecialchars($request->input('departureAirportSector'), ENT_XML1, 'UTF-8') . '</sector>
                                    <codeshare>' . htmlspecialchars($request->input('departureFlightCodeShare'), ENT_XML1, 'UTF-8') . '</codeshare>
                                    <distance>' . htmlspecialchars($request->input('departureFlightDistance'), ENT_XML1, 'UTF-8') . '</distance>
                                    <equipment>
                                       <airEquipType>' . htmlspecialchars($request->input('equipmentAirEquipType'), ENT_XML1, 'UTF-8') . '</airEquipType>
                                       <changeofGauge>' . htmlspecialchars($request->input('equipmentChangeOfGauge'), ENT_XML1, 'UTF-8') . '</changeofGauge>
                                    </equipment>
                                    '. 
                                       $this->flightNotes->flightNotesArray($request->input('flightNotes')) 
                                    .'
                                    <flownMileageQty>' . htmlspecialchars($request->input('flownMileageQty'), ENT_XML1, 'UTF-8') . '</flownMileageQty>
                                    <iatciFlight>' . htmlspecialchars($request->input('iatciFlight'), ENT_XML1, 'UTF-8') . '</iatciFlight>
                                    <journeyDuration>' . htmlspecialchars($request->input('journeyDuration'), ENT_XML1, 'UTF-8') . '</journeyDuration>
                                    <onTimeRate>' . htmlspecialchars($request->input('onTimeRate'), ENT_XML1, 'UTF-8') . '</onTimeRate>'.

                                    $this->checkRemark($request->input('remark'))
                                    


                                    .'<secureFlightDataRequired>' . htmlspecialchars($request->input('secureFlightDataRequired'), ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                                    <segmentStatusByFirstLeg>' . htmlspecialchars($request->input('segmentStatusByFirstLeg'), ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                                    <stopQuantity>' . htmlspecialchars($request->input("stopQuantity"), ENT_XML1, 'UTF-8') . '</stopQuantity>
                                    </flightSegment>
                                 <involuntaryPermissionGiven>' . htmlspecialchars($request->input('involuntaryPermissionGiven'), ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                                 <legStatus>' . htmlspecialchars($request->input('legStatus'), ENT_XML1, 'UTF-8') . '</legStatus>
                                 <referenceID>' . htmlspecialchars($request->input('referenceID'), ENT_XML1, 'UTF-8') . '</referenceID>
                                 <responseCode>' . htmlspecialchars($request->input('responseCode'), ENT_XML1, 'UTF-8') . '</responseCode>
                                 <sequenceNumber>' . htmlspecialchars($request->input('sequenceNumber'), ENT_XML1, 'UTF-8') . '</sequenceNumber>
                                 <status>' . htmlspecialchars($request->input('status'), ENT_XML1, 'UTF-8') . '</status>
                           </bookFlightSegmentList>
                        </bookOriginDestinationOptionList>
                     </bookOriginDestinationOptions>
                  </airItinerary>'.
                    $this->airTravelerList($request->input('airTravelerList')) .' '.
                    $this->ancillaryRequestList($request->input('ancillaryRequestList'))
                  .'<bookingReferenceID>
                     <companyName>
                        <cityCode>LOS</cityCode>
                        <code>P4</code>
                        <codeContext>CRANE</codeContext>
                        <companyFullName>SCINTILLA</companyFullName>
                        <companyShortName>SCINTILLA</companyShortName>
                        <countryCode>NG</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($request->input("bookingReferenceIDID"), ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($request->input('bookingReferenceID'), ENT_XML1, 'UTF-8') . '</referenceID>
                  </bookingReferenceID>
               </AddSsrRequest>
               </impl:AddSsr>
         </soapenv:Body>
      </soapenv:Envelope>';
      
      return $xml;  
   } 

   


   public function checkTerminal($arrivalAirportTerminal) {
        if (isset($arrivalAirportTerminal)) {
            return  '<terminal>' . htmlspecialchars($arrivalAirportTerminal, ENT_XML1, 'UTF-8') . '</terminal>';
        }
   }
   public function checkRemark($remark) {
        if(isset($remark)) {
        return '<remark>' . htmlspecialchars($remark, ENT_XML1, 'UTF-8') . '</remark>';
        }
        return '';
   }

   public function ancillaryRequestList($ancillaryRequestList) {

        $xml = '';
        
        foreach ($ancillaryRequestList as $string) {
            $xml .= '<ancillaryRequestList>
                        <airTravelerSequence>' . htmlspecialchars($string['airTravelerSequence'], ENT_XML1, 'UTF-8') . '</airTravelerSequence>
                        <flightSegmentSequence>' . htmlspecialchars($string['flightSegmentSequence'], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                        <ssrCode>' . htmlspecialchars($string['airTravelerSsrCode'], ENT_XML1, 'UTF-8') . '</ssrCode>
                        <ssrGroup>' . htmlspecialchars($string['airTravelerSsrGroup'], ENT_XML1, 'UTF-8') . '</ssrGroup>
                        <ssrExplanation>' . htmlspecialchars($string['ssrExplanation'], ENT_XML1, 'UTF-8') . '</ssrExplanation>
                    </ancillaryRequestList>';
        }
        
        return $xml;
   }

    public function airTravelerList($airTravelerList) {
        $xml = '';

        foreach($airTravelerList as $string) {
            $xml .= '<airTravelerList>
                     <accompaniedByInfant>' . htmlspecialchars($string['accompaniedByInfant'], ENT_XML1, 'UTF-8') . '</accompaniedByInfant>
                     <birthDate>' . htmlspecialchars($string['airTravelerbirthDate'], ENT_XML1, 'UTF-8') . '</birthDate>
                     <contactPerson>
                        <email>
                           <email>' . htmlspecialchars($string['contactPersonEmail'], ENT_XML1, 'UTF-8') . '</email>
                           <markedForSendingRezInfo>' . htmlspecialchars($string['airTravelerListEmailMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($string['emailPreferred'], ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($string['emailSharedMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </email>
                        <personName>
                           <givenName>' . htmlspecialchars($string['airTravelerListPersonNameGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                           <shareMarketInd>' . htmlspecialchars($string['airTravelerListpersonNameShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <surname>' . htmlspecialchars($string['airTravelerListPersonNameSurname'], ENT_XML1, 'UTF-8') . '</surname>
                        </personName>
                        <phoneNumber>
                           <areaCode>' . htmlspecialchars($string['phoneNumberAreaCode'], ENT_XML1, 'UTF-8') . '</areaCode>
                           <countryCode>' . htmlspecialchars($string['phoneCountryCode'], ENT_XML1, 'UTF-8') . '</countryCode>
                           <markedForSendingRezInfo>' . htmlspecialchars($string['phoneNumberEmailMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($string['phoneNumberPreferred'], ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($string['phoneNumberShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <subscriberNumber>' . htmlspecialchars($string['phoneNumberSubscriberNumber'], ENT_XML1, 'UTF-8') . '</subscriberNumber>
                        </phoneNumber>
                        <shareContactInfo>' . htmlspecialchars($string['airTravelerShareContactInfo'], ENT_XML1, 'UTF-8') . '</shareContactInfo>
                        <shareMarketInd>' . htmlspecialchars($string['airTravelerShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <useForInvoicing>' . htmlspecialchars($string['useForInvoicing'], ENT_XML1, 'UTF-8') . '</useForInvoicing>
                     </contactPerson>
                     <documentInfoList>
                        <birthDate>' . htmlspecialchars($string['documentInfoBirthDate'], ENT_XML1, 'UTF-8') . '</birthDate>
                        <docHolderFormattedName>
                           <givenName>' . htmlspecialchars($string['documentHolderFormattedGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                           <shareMarketInd>' . htmlspecialchars($string['documentHolderFormattedShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                           <surname>' . htmlspecialchars($string['documentHolderFormattedSurname'], ENT_XML1, 'UTF-8') . '</surname>
                        </docHolderFormattedName>
                        <gender>' . htmlspecialchars($string['documentHolderFormattedGender'], ENT_XML1, 'UTF-8') . '</gender>
                     </documentInfoList>
                     <emergencyContactInfo>
                        <contactName>
                           <shareMarketInd>' . htmlspecialchars($string['emergencyContactInfoshareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </contactName>
                        <decline>' . htmlspecialchars($string['decline'], ENT_XML1, 'UTF-8') . '</decline>
                        <email>
                           <markedForSendingRezInfo>' . htmlspecialchars($string['emergencyContactMarkedForSendingRezInfo'], ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                           <preferred>' . htmlspecialchars($string['emergencyContactPreferred'], ENT_XML1, 'UTF-8') . '</preferred>
                           <shareMarketInd>' . htmlspecialchars($string['emergencyContactShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        </email>
                        <shareContactInfo>' . htmlspecialchars($string['shareContactInfo'], ENT_XML1, 'UTF-8') . '</shareContactInfo>
                     </emergencyContactInfo>
                     <gender>' . htmlspecialchars($string['airTravelerGender'], ENT_XML1, 'UTF-8') . '</gender>
                     <hasStrecher>' . htmlspecialchars($string['airTravelerHasStrecher'], ENT_XML1, 'UTF-8') . '</hasStrecher>
                     <parentSequence>' . htmlspecialchars($string['parentSequence'], ENT_XML1, 'UTF-8') . '</parentSequence>
                     <passengerTypeCode>' . htmlspecialchars($string['passengerTypeCode'], ENT_XML1, 'UTF-8') . '</passengerTypeCode>
                     <personName>
                        <givenName>' . htmlspecialchars($string['personNameGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                        <nameTitle>' . htmlspecialchars($string['personNameTitle'], ENT_XML1, 'UTF-8') . '</nameTitle>
                        <shareMarketInd>' . htmlspecialchars($string['personNameshareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <surname>' . htmlspecialchars($string['personNameSurname'], ENT_XML1, 'UTF-8') . '</surname>
                     </personName>
                     <personNameEN>
                        <givenName>' . htmlspecialchars($string['personNameENGivenName'], ENT_XML1, 'UTF-8') . '</givenName>
                        <nameTitle>' . htmlspecialchars($string['personNameENTitle'], ENT_XML1, 'UTF-8') . '</nameTitle>
                        <shareMarketInd>' . htmlspecialchars($string['personNameENShareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                        <surname>' . htmlspecialchars($string['personNameENShareMarketSurname'], ENT_XML1, 'UTF-8') . '</surname>
                     </personNameEN>
                     <requestedSeatCount>' . htmlspecialchars($string['requestedSeatCount'], ENT_XML1, 'UTF-8') . '</requestedSeatCount>
                     <shareMarketInd>' . htmlspecialchars($string['shareMarketInd'], ENT_XML1, 'UTF-8') . '</shareMarketInd>
                     <travelerReferenceID>' . htmlspecialchars($string['travelerReferenceID'], ENT_XML1, 'UTF-8') . '</travelerReferenceID>
                     <unaccompaniedMinor>' . htmlspecialchars($string['airTravelUnaccompaniedMinor'], ENT_XML1, 'UTF-8') . '</unaccompaniedMinor>
                  </airTravelerList>';
        }

        return $xml;

    }


   /* 
   public function addWeightArray(
      $adviceCodeSegmentExist,
      $airItinerary,
      $airTravelerList,
      $ancillaryRequestList,
      $bookingReferenceIDID,
      $bookingReferenceID


   ) {
      // dd($airItinerary);
      $xml = '<?xml version="1.0" encoding="UTF-8"?>
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
               <impl:AddSsr>
               <AddSsrRequest>
               <clientInformation>
               <clientIP>129.0.0.1</clientIP>
               <member>false</member>
               <password>SCINTILLA</password>
               <userName>SCINTILLA</userName>
               <preferredCurrency>NGN</preferredCurrency>
               </clientInformation>
                  <airItinerary>
                  <adviceCodeSegmentExist>' . htmlspecialchars($adviceCodeSegmentExist, ENT_XML1, 'UTF-8') . '</adviceCodeSegmentExist>'.
                     $this->airItinerary($airItinerary)

                  .'</airItinerary>'.
                    $this->airTravelerList($airTravelerList) .' '.
                    $this->ancillaryRequestList($ancillaryRequestList)
                  .'<bookingReferenceID>
                     <companyName>
                        <cityCode>LOS</cityCode>
                        <code>P4</code>
                        <codeContext>CRANE</codeContext>
                        <companyFullName>SCINTILLA</companyFullName>
                        <companyShortName>SCINTILLA</companyShortName>
                        <countryCode>NG</countryCode>
                     </companyName>
                     <ID>' . htmlspecialchars($bookingReferenceIDID, ENT_XML1, 'UTF-8') . '</ID>
                     <referenceID>' . htmlspecialchars($bookingReferenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                  </bookingReferenceID>
               </AddSsrRequest>
               </impl:AddSsr>
         </soapenv:Body>
      </soapenv:Envelope>';
      
      return $xml;  
   }

   public function airItinerary($airItineraryList) {
      $xml = '';
      // dd($airItineraryList);
      foreach($airItineraryList as $airItinerary) {
         $xml .= '<bookOriginDestinationOptions>
            <bookOriginDestinationOptionList>
               <bookFlightSegmentList>
                  <actionCode>' . htmlspecialchars($airItinerary["bookFlightSegmentListActionCode"], ENT_XML1, 'UTF-8') . '</actionCode>
                  <addOnSegment>' . htmlspecialchars($airItinerary["bookFlightAddOnSegment"], ENT_XML1, 'UTF-8') . '</addOnSegment>
                  <bookingClass>
                     <cabin>' . htmlspecialchars($airItinerary["bookingClassCabin"], ENT_XML1, 'UTF-8') . '</cabin>
                     <resBookDesigCode>' . htmlspecialchars($airItinerary["bookingClassResBookDesigCode"], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                     <resBookDesigQuantity>' . htmlspecialchars($airItinerary["resBookDesignQuantity"], ENT_XML1, 'UTF-8') . '</resBookDesigQuantity>
                  </bookingClass>
                  <fareInfo>
                     <cabin>' . htmlspecialchars($airItinerary["fareInfoCabin"], ENT_XML1, 'UTF-8') . '</cabin>
                     <cabinClassCode>' . htmlspecialchars($airItinerary["fareInfoCabinClassCode"], ENT_XML1, 'UTF-8') . '</cabinClassCode>
                     <fareBaggageAllowance>
                        <allowanceType>' . htmlspecialchars($airItinerary["fareBaggageAllowanceType"], ENT_XML1, 'UTF-8') . '</allowanceType>
                        <maxAllowedPieces>' . htmlspecialchars($airItinerary["fareBaggageMaxAllowedPieces"], ENT_XML1, 'UTF-8') . '</maxAllowedPieces>
                        <maxAllowedWeight>
                           <unitOfMeasureCode>' . htmlspecialchars($airItinerary["unitOfMeasureCode"], ENT_XML1, 'UTF-8') . '</unitOfMeasureCode>
                           <weight>' . htmlspecialchars($airItinerary["fareBaggageAllowanceWeight"], ENT_XML1, 'UTF-8') . '</weight>
                        </maxAllowedWeight>
                     </fareBaggageAllowance>
                     <fareGroupName>' . htmlspecialchars($airItinerary["fareGroupName"], ENT_XML1, 'UTF-8') . '</fareGroupName>
                     <fareReferenceCode>' . htmlspecialchars($airItinerary["fareReferenceCode"], ENT_XML1, 'UTF-8') . '</fareReferenceCode>
                     <fareReferenceID>' . htmlspecialchars($airItinerary["fareReferenceID"], ENT_XML1, 'UTF-8') . '</fareReferenceID>
                     <fareReferenceName>' . htmlspecialchars($airItinerary["fareReferenceName"], ENT_XML1, 'UTF-8') . '</fareReferenceName>
                     <flightSegmentSequence>' . htmlspecialchars($airItinerary["bookFlightSegmentSequence"], ENT_XML1, 'UTF-8') . '</flightSegmentSequence>
                     <resBookDesigCode>' . htmlspecialchars($airItinerary["resBookDesigCode"], ENT_XML1, 'UTF-8') . '</resBookDesigCode>
                  </fareInfo>
                  <flightSegment>
                     <airline>
                        <code>' . htmlspecialchars($airItinerary["flightSegmentCode"], ENT_XML1, 'UTF-8') . '</code>
                        <codeContext>' . htmlspecialchars($airItinerary["flightSegmentCodeContext"], ENT_XML1, 'UTF-8') . '</codeContext>
                     </airline>
                     <arrivalAirport>
                        <cityInfo>
                           <city>
                              <locationCode>' . htmlspecialchars($airItinerary["arrivalAirportCityLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($airItinerary["arrivalAirportCityLocationName"], ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($airItinerary["arrivalAirportCityLocationNameLanguage"], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                           </city>
                           <country>
                              <locationCode>' . htmlspecialchars($airItinerary["arrivalAirportCountryLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($airItinerary["arrivalAirportCountryLocationName"], ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($airItinerary["arrivalAirportCountryLocationNameLanguage"], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              <currency>
                                 <code>' . htmlspecialchars($airItinerary["arrivalAirportCountryCurrencyCode"], ENT_XML1, 'UTF-8') . '</code>
                              </currency>
                           </country>
                        </cityInfo>
                        <codeContext>' . htmlspecialchars($airItinerary["arrivalAirportCodeContext"], ENT_XML1, 'UTF-8') . '</codeContext>
                        <language>' . htmlspecialchars($airItinerary["arrivalAirportLanguage"], ENT_XML1, 'UTF-8') . '</language>
                        <locationCode>' . htmlspecialchars($airItinerary["arrivalAirportLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($airItinerary["arrivalAirportLocationName"], ENT_XML1, 'UTF-8') . '</locationName>'. 

                        $this->checkTerminal($airItinerary["arrivalAirportTerminal"])
                        
                        .'<timeZoneInfo>' . htmlspecialchars($airItinerary["arrivalAirportTimeZoneInfo"], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </arrivalAirport>
                     <arrivalDateTime>' . htmlspecialchars($airItinerary["arrivalDateTime"], ENT_XML1, 'UTF-8') . '</arrivalDateTime>
                     <arrivalDateTimeUTC>' . htmlspecialchars($airItinerary["arrivalDateTimeUTC"], ENT_XML1, 'UTF-8') . '</arrivalDateTimeUTC>
                     <departureAirport>
                        <cityInfo>
                           <city>
                              <locationCode>' . htmlspecialchars($airItinerary["departureAirportCitytLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($airItinerary["departureAirportCityLocationName"], ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($airItinerary["departureAirportCityLocationNameLanguage"], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                           </city>
                           <country>
                              <locationCode>' . htmlspecialchars($airItinerary["departureAirportCountryLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                              <locationName>' . htmlspecialchars($airItinerary["departureAirportCountryLocationName"], ENT_XML1, 'UTF-8') . '</locationName>
                              <locationNameLanguage>' . htmlspecialchars($airItinerary["departureCountryLocationNameLanguage"], ENT_XML1, 'UTF-8') . '</locationNameLanguage>
                              <currency>
                                 <code>' . htmlspecialchars($airItinerary["departureCountryCurrencyCode"], ENT_XML1, 'UTF-8') . '</code>
                              </currency>
                           </country>
                        </cityInfo>
                        <codeContext>' . htmlspecialchars($airItinerary["departureAirportCodeContext"], ENT_XML1, 'UTF-8') . '</codeContext>
                        <language>' . htmlspecialchars($airItinerary["departureAirportLanguage"], ENT_XML1, 'UTF-8') . '</language>
                        <locationCode>' . htmlspecialchars($airItinerary["departureAirportLocationCode"], ENT_XML1, 'UTF-8') . '</locationCode>
                        <locationName>' . htmlspecialchars($airItinerary["departureAirportLocationName"], ENT_XML1, 'UTF-8') . '</locationName>
                        <timeZoneInfo>' . htmlspecialchars($airItinerary["departureAirportTimeZoneInfo"], ENT_XML1, 'UTF-8') . '</timeZoneInfo>
                     </departureAirport>
                     <departureDateTime>' . htmlspecialchars($airItinerary["departureDateTime"], ENT_XML1, 'UTF-8') . '</departureDateTime>
                     <departureDateTimeUTC>' . htmlspecialchars($airItinerary["departureDateTimeUTC"], ENT_XML1, 'UTF-8') . '</departureDateTimeUTC>
                     <flightNumber>' . htmlspecialchars($airItinerary["flightNumber"], ENT_XML1, 'UTF-8') . '</flightNumber>
                     <flightSegmentID>' . htmlspecialchars($airItinerary["flightSegmentID"], ENT_XML1, 'UTF-8') . '</flightSegmentID>
                     <ondControlled>' . htmlspecialchars($airItinerary["ondControlled"], ENT_XML1, 'UTF-8') . '</ondControlled>
                     <sector>' . htmlspecialchars($airItinerary["departureAirportSector"], ENT_XML1, 'UTF-8') . '</sector>
                     <codeshare>' . htmlspecialchars($airItinerary["departureFlightCodeShare"], ENT_XML1, 'UTF-8') . '</codeshare>
                     <distance>' . htmlspecialchars($airItinerary["departureFlightDistance"], ENT_XML1, 'UTF-8') . '</distance>
                     <equipment>
                        <airEquipType>' . htmlspecialchars($airItinerary["equipmentAirEquipType"], ENT_XML1, 'UTF-8') . '</airEquipType>
                        <changeofGauge>' . htmlspecialchars($airItinerary["equipmentChangeOfGauge"], ENT_XML1, 'UTF-8') . '</changeofGauge>
                     </equipment>
                     '. 
                        $this->flightNotes->flightNotesArray($airItinerary["flightNotes"]) 
                     .'
                     <flownMileageQty>' . htmlspecialchars($airItinerary["flownMileageQty"], ENT_XML1, 'UTF-8') . '</flownMileageQty>
                     <iatciFlight>' . htmlspecialchars($airItinerary["iatciFlight"], ENT_XML1, 'UTF-8') . '</iatciFlight>
                     <journeyDuration>' . htmlspecialchars($airItinerary["journeyDuration"], ENT_XML1, 'UTF-8') . '</journeyDuration>
                     <onTimeRate>' . htmlspecialchars($airItinerary["onTimeRate"], ENT_XML1, 'UTF-8') . '</onTimeRate>'.

                     $this->checkRemark($airItinerary["remark"])
                     


                     .'<secureFlightDataRequired>' . htmlspecialchars($airItinerary["secureFlightDataRequired"], ENT_XML1, 'UTF-8') . '</secureFlightDataRequired>
                     <segmentStatusByFirstLeg>' . htmlspecialchars($airItinerary["segmentStatusByFirstLeg"], ENT_XML1, 'UTF-8') . '</segmentStatusByFirstLeg>
                     <stopQuantity>' . htmlspecialchars($airItinerary["stopQuantity"], ENT_XML1, 'UTF-8') . '</stopQuantity>
                     </flightSegment>
                  <involuntaryPermissionGiven>' . htmlspecialchars($airItinerary["involuntaryPermissionGiven"], ENT_XML1, 'UTF-8') . '</involuntaryPermissionGiven>
                  <legStatus>' . htmlspecialchars($airItinerary["legStatus"], ENT_XML1, 'UTF-8') . '</legStatus>
                  <referenceID>' . htmlspecialchars($airItinerary["referenceID"], ENT_XML1, 'UTF-8') . '</referenceID>
                  <responseCode>' . htmlspecialchars($airItinerary["responseCode"], ENT_XML1, 'UTF-8') . '</responseCode>
                  <sequenceNumber>' . htmlspecialchars($airItinerary["sequenceNumber"], ENT_XML1, 'UTF-8') . '</sequenceNumber>
                  <status>' . htmlspecialchars($airItinerary["status"], ENT_XML1, 'UTF-8') . '</status>
            </bookFlightSegmentList>
         </bookOriginDestinationOptionList>
      </bookOriginDestinationOptions>';
      }

      return $xml;
      
   }
   */
}