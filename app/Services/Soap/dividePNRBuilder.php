<?php

namespace App\Services\Soap;
class DividePNRBuilder {
   
   protected $craneUsername;
   protected $cranePassword;

   public function __construct() {
			$this->craneUsername = config('app.crane.username');		
			$this->cranePassword = config('app.crane.password');
	}
   public function dividePNR(  
        $companyNameCitycode, 
        $companyNameCode, 
        $companyNameCodeContext, 
        $companyFullName, 
        $companyShortName, 
        $companyCountryCode, 
        $ID, 
        $referenceID, 
        $accompaniedByInfant, 
        $dividedTravelerBirthDate, 
        $contactPersonEmail, 
        $contactPersonMarkedForSendingRezInfo, 
        $contactPersonPreferred,
        $shareMarketInd, 
        $personNameGivenName, 
        $personNameShareMarketInd, 
        $personNameSurName, 
        $phoneNumberAreaCode, 
        $phoneNumberCountryCode,
        $phoneNumberMarkedForSendingRezInfo, 
        $phoneNumberPreferred, 
        $phoneNumberShareMarketInd, 
        $phoneNumberSubscriberNumber, 
        $contactPersonShareContactInfo,
        $contactPersonShareMarketInd, 
        $useForInvoicing, 
        $documentInfoListBirthDate, 
        $documentHolderFormattedNameGivenName,
        $documentInfoListShareMarketInd,
        $documentInfoListSurname, 
        $documentInfoListGender, 
        $contactNameShareMarketInd, 
        $emergencyContactInfoDecline, 
        $emergencyContactInfoMarkedForSendingRezInfo,
        $emergencyContactInfoPreferred, 
        $emergencyContactInfoShareMarketInd, 
        $emergencyContactShareContactInfo, 
        $emergencyContactInfoGender, 
        $emergencyContactInfoHasStrecher,
        $emergencyContactInfoParentSequence, 
        $emergencyContactInfoPassengerTypeCode, 
        $emergencyContactInfoPersonNameGivenName,
        $emergencyContactInfoPersonNameTitle,
        $emergencyContactInfoPersonNameShareMarketInd, 
        $emergencyContactInfoPersonNameSurname, 
        $personNameENGivenName,
        $personNameENNameTitle, 
        $personNameENShareMarketInd, 
        $personNameENSurname, 
        $requestedSeatCount, 
        $divideTravelerShareMarketInd,
        $travelerReferenceID, 
        $unaccompaniedMinor
    ) {
      $xml = '<?xml version="1.0" encoding="UTF-8"?>      
         <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
            <soapenv:Body>
               <impl:DividePnr>
               <!-- Optional: -->
               <AirDividePnrRequest>
               <!-- Optional: -->
               <clientInformation>
               <clientIP>129.0.0.1</clientIP>
               <member>false</member>
               <password>' . htmlspecialchars($this->cranePassword, ENT_XML1, 'UTF-8') . '</password>
               <userName>' . htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') . '</userName>
               <preferredCurrency>NGN</preferredCurrency>
               </clientInformation>
               <bookingReferenceID>
                  <companyName>
                     <cityCode>' . htmlspecialchars($companyNameCitycode, ENT_XML1, 'UTF-8') . '</cityCode>
                     <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                     <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                     <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                     <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                     <countryCode>' . htmlspecialchars($companyCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                  </companyName>
                  <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                  <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
               </bookingReferenceID>
               <!-- Zero or more repetitions: -->
               <dividedTravelerList>
               <accompaniedByInfant>' . htmlspecialchars($accompaniedByInfant, ENT_XML1, 'UTF-8') . '</accompaniedByInfant>
               <birthDate>' . htmlspecialchars($dividedTravelerBirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
               <contactPerson>
                  <email>
                     <email>' . htmlspecialchars($contactPersonEmail, ENT_XML1, 'UTF-8') . '</email>
                     <markedForSendingRezInfo>' . htmlspecialchars($contactPersonMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                     <preferred>' . htmlspecialchars($contactPersonPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                     <shareMarketInd>' . htmlspecialchars($shareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  </email>
                  <personName>
                     <givenName>' . htmlspecialchars($personNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                     <shareMarketInd>' . htmlspecialchars($personNameShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                     <surname>' . htmlspecialchars($personNameSurName, ENT_XML1, 'UTF-8') . '</surname>
                  </personName>
                  <phoneNumber>
                     <areaCode>' . htmlspecialchars($phoneNumberAreaCode, ENT_XML1, 'UTF-8') . '</areaCode>
                     <countryCode>' . htmlspecialchars($phoneNumberCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                     <markedForSendingRezInfo>' . htmlspecialchars($phoneNumberMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                     <preferred>' . htmlspecialchars($phoneNumberPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                     <shareMarketInd>' . htmlspecialchars($phoneNumberShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                     <subscriberNumber>' . htmlspecialchars($phoneNumberSubscriberNumber, ENT_XML1, 'UTF-8') . '</subscriberNumber>
                  </phoneNumber>
                  <shareContactInfo>' . htmlspecialchars($contactPersonShareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
                  <shareMarketInd>' . htmlspecialchars($contactPersonShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  <useForInvoicing>' . htmlspecialchars($useForInvoicing, ENT_XML1, 'UTF-8') . '</useForInvoicing>
               </contactPerson>
               <documentInfoList>
                  <birthDate>' . htmlspecialchars($documentInfoListBirthDate, ENT_XML1, 'UTF-8') . '</birthDate>
                  <docHolderFormattedName>
                     <givenName>' . htmlspecialchars($documentHolderFormattedNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                     <shareMarketInd>' . htmlspecialchars($documentInfoListShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                     <surname>' . htmlspecialchars($documentInfoListSurname, ENT_XML1, 'UTF-8') . '</surname>
                  </docHolderFormattedName>
                  <gender>' . htmlspecialchars($documentInfoListGender, ENT_XML1, 'UTF-8') . '</gender>
               </documentInfoList>
               <emergencyContactInfo>
                  <contactName>
                     <shareMarketInd>' . htmlspecialchars($contactNameShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  </contactName>
                  <decline>' . htmlspecialchars($emergencyContactInfoDecline, ENT_XML1, 'UTF-8') . '</decline>
                  <email>
                  <markedForSendingRezInfo>' . htmlspecialchars($emergencyContactInfoMarkedForSendingRezInfo, ENT_XML1, 'UTF-8') . '</markedForSendingRezInfo>
                  <preferred>' . htmlspecialchars($emergencyContactInfoPreferred, ENT_XML1, 'UTF-8') . '</preferred>
                  <shareMarketInd>' . htmlspecialchars($emergencyContactInfoShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  </email>
                  <shareContactInfo>' . htmlspecialchars($emergencyContactShareContactInfo, ENT_XML1, 'UTF-8') . '</shareContactInfo>
               </emergencyContactInfo>
               <gender>' . htmlspecialchars($emergencyContactInfoGender, ENT_XML1, 'UTF-8') . '</gender>
               <hasStrecher>' . htmlspecialchars($emergencyContactInfoHasStrecher, ENT_XML1, 'UTF-8') . '</hasStrecher>
               <parentSequence>' . htmlspecialchars($emergencyContactInfoParentSequence, ENT_XML1, 'UTF-8') . '</parentSequence>
               <passengerTypeCode>' . htmlspecialchars($emergencyContactInfoPassengerTypeCode, ENT_XML1, 'UTF-8') . '</passengerTypeCode>
               <personName>
                  <givenName>' . htmlspecialchars($emergencyContactInfoPersonNameGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                  <nameTitle>' . htmlspecialchars($emergencyContactInfoPersonNameTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                  <shareMarketInd>' . htmlspecialchars($emergencyContactInfoPersonNameShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  <surname>' . htmlspecialchars($emergencyContactInfoPersonNameSurname, ENT_XML1, 'UTF-8') . '</surname>
               </personName>
               <personNameEN>
                  <givenName>' . htmlspecialchars($personNameENGivenName, ENT_XML1, 'UTF-8') . '</givenName>
                  <nameTitle>' . htmlspecialchars($personNameENNameTitle, ENT_XML1, 'UTF-8') . '</nameTitle>
                  <shareMarketInd>' . htmlspecialchars($personNameENShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
                  <surname>' . htmlspecialchars($personNameENSurname, ENT_XML1, 'UTF-8') . '</surname>
               </personNameEN>
               <requestedSeatCount>' . htmlspecialchars($requestedSeatCount, ENT_XML1, 'UTF-8') . '</requestedSeatCount>
               <shareMarketInd>' . htmlspecialchars($divideTravelerShareMarketInd, ENT_XML1, 'UTF-8') . '</shareMarketInd>
               <travelerReferenceID>' . htmlspecialchars($travelerReferenceID, ENT_XML1, 'UTF-8') . '</travelerReferenceID>
               <unaccompaniedMinor>' . htmlspecialchars($unaccompaniedMinor, ENT_XML1, 'UTF-8') . '</unaccompaniedMinor>
               </dividedTravelerList>
               </AirDividePnrRequest>
               </impl:DividePnr>
            </soapenv:Body>
        </soapenv:Envelope>';
        return $xml;
   }
}