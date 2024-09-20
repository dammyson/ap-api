<?php

namespace App\Services\Soap;

class TicketReservationRequestBuilder
   {
      public function ticketReservationViewOnlyRT( 
         $companyNameCityCode,
         $companyNameCode,
         $companyNameCodeContext,
         $companyFullName,
         $companyShortName,
         $companyCountryCode,
         $ID,
         $referenceID,
         $requestPurpose
      ) {
        $xml =  '<?xml version="1.0" encoding="UTF-8"?>
        soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
            <soapenv:Header/>
                <soapenv:Body>
                <impl:TicketReservation>
                <!-- Optional: -->
                <AirTicketReservationRequest>
                    <!-- Optional: -->
                    <clientInformation>
                        <clientIP>129.0.0.1</clientIP>
                        <member>false</member>
                        <password>SCINTILLA</password>
                        <userName>SCINTILLA</userName>
                        <preferredCurrency>NGN</preferredCurrency>
                    </clientInformation>
                    <!-- Optional: -->
                    <bookingReferenceID>
                        <companyName>
                            <cityCode>' . htmlspecialchars($companyNameCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                            <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                            <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                            <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                            <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                            <countryCode>' . htmlspecialchars($companyCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                        </companyName>
                        <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                        <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                    </bookingReferenceID>
                    <!-- Optional: -->
                    <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                </AirTicketReservationRequest>
                </impl:TicketReservation>
            </soapenv:Body>
        </soapenv:Envelope>';

        return $xml;
    }

    public function ticketReservationViewOnly(
        $companyNameCityCode,
        $companyNameCode,
        $companyNameCodeContext,
        $companyFullName,
        $companyShortName,
        $companyNameCountryCode,
        $ID,
        $referenceID,
        $requestPurpose
    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
           <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
              <soapenv:Body>
                    <impl:TicketReservation>
                    <!-- Optional: -->
                       <AirTicketReservationRequest>
                       <!-- Optional: -->
                       <clientInformation>
                          <clientIP>129.0.0.1</clientIP>
                          <member>false</member>
                          <password>SCINTILLA</password>
                          <userName>SCINTILLA</userName>
                          <preferredCurrency>NGN</preferredCurrency>
                       </clientInformation>
                       <!-- Optional: -->
                       <bookingReferenceID>
                          <companyName>
                             <cityCode>' . htmlspecialchars($companyNameCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                             <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                             <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                             <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                             <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                             <countryCode>' . htmlspecialchars($companyNameCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                          </companyName>
                          <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                       </bookingReferenceID>
                       <!-- Optional: -->
                       <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                    </AirTicketReservationRequest>
                 </impl:TicketReservation>
              </soapenv:Body>
           </soapenv:Envelope>';
        return $xml;
    }

    public function ticketReservationCommitRT(  
        $companyNameCityCode,
        $companyNameCode,
        $companyNameCodeContext,
        $companyFullName,
        $companyShortName,
        $countryCode,
        $ID,
        $referenceID,
        $capturePaymentToolNumber,
        $paymentCode,
        $threeDomainSecurityEligible,
        $MCONumber,
        $paymentAmountCurrencyCode,
        $paymentAmountValue,
        $paymentType,
        $primaryPayment,
        $requestPurpose
    ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
           <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
              <soapenv:Header/>
                 <soapenv:Body>
                    <impl:TicketReservation>
                    <!-- Optional: -->
                    <AirTicketReservationRequest>
                       <!-- Optional: -->
                       <clientInformation>
                          <clientIP>129.0.0.1</clientIP>
                          <member>false</member>
                          <password>SCINTILLA</password>
                          <userName>SCINTILLA</userName>
                          <preferredCurrency>NGN</preferredCurrency>
                       </clientInformation>
                       <!-- Optional: -->
                       <bookingReferenceID>
                          <companyName>
                             <cityCode>' . htmlspecialchars($companyNameCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                             <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                             <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                             <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                             <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                             <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                          </companyName>
                          <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                       </bookingReferenceID>
                       <!-- Optional: -->
                       <fullfillment>
                          <paymentDetails>
                          <paymentDetailList>
                          <miscChargeOrder>
                             <avsEnabled/>
                             <capturePaymentToolNumber>' . htmlspecialchars($capturePaymentToolNumber, ENT_XML1, 'UTF-8') . '</capturePaymentToolNumber>
                             <paymentCode>' . htmlspecialchars($paymentCode, ENT_XML1, 'UTF-8') . '</paymentCode>
                             <threeDomainSecurityEligible>' . htmlspecialchars($threeDomainSecurityEligible, ENT_XML1, 'UTF-8') . '</threeDomainSecurityEligible>
                             <transactionFeeApplies/>
                             <MCONumber>' . htmlspecialchars($MCONumber, ENT_XML1, 'UTF-8') . '</MCONumber>
                          </miscChargeOrder>
                          <payLater/>
                          <paymentAmount>
                             <currency>
                                <code>' . htmlspecialchars($paymentAmountCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                             </currency>
                             <mileAmount/>
                             <value>' . htmlspecialchars($paymentAmountValue, ENT_XML1, 'UTF-8') . '</value>
                          </paymentAmount>
                          <paymentType>' . htmlspecialchars($paymentType, ENT_XML1, 'UTF-8') . '</paymentType>
                          <primaryPayment>' . htmlspecialchars($primaryPayment, ENT_XML1, 'UTF-8') . '</primaryPayment>
                          </paymentDetailList>
                          </paymentDetails>
                       </fullfillment>
                       <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                       </AirTicketReservationRequest>
                 </impl:TicketReservation>
              </soapenv:Body>
           </soapenv:Envelope>';
        return $xml;
    }

    public function ticketReservationCommit(
        $companyNameCityCode,
        $companyNameCode,
        $companyNameCodeContext,
        $companyFullName,
        $companyShortName,
        $companyNameCountryCode,
        $ID,
        $referenceID,
        $capturePaymentToolNumber,
        $paymentCode,
        $threeDomainSecurityEligible,
        $MCONumber,
        $code,
        $value,
        $paymentType,
        $primaryPayment,
        $requestPurpose
     ) {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
        <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
           <soapenv:Header/>
              <soapenv:Body>
                 <impl:TicketReservation>
                    <!-- Optional: -->
                       <AirTicketReservationRequest>
                       <!-- Optional: -->
                       <clientInformation>
                          <clientIP>129.0.0.1</clientIP>
                          <member>false</member>
                          <password>SCINTILLA</password>
                          <userName>SCINTILLA</userName>
                          <preferredCurrency>NGN</preferredCurrency>
                       </clientInformation>
                       <!-- Optional: -->
                       <bookingReferenceID>
                          <companyName>
                             <cityCode>' . htmlspecialchars($companyNameCityCode, ENT_XML1, 'UTF-8') . '</cityCode>
                             <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                             <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                             <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                             <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                             <countryCode>' . htmlspecialchars($companyNameCountryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                          </companyName>
                          <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                       </bookingReferenceID>
                       <!-- Optional: -->
                       <fullfillment>
                          <paymentDetails>
                          <paymentDetailList>
                             <miscChargeOrder>
                                <avsEnabled/>
                                <capturePaymentToolNumber>' . htmlspecialchars($capturePaymentToolNumber, ENT_XML1, 'UTF-8') . '</capturePaymentToolNumber>
                                <paymentCode>' . htmlspecialchars($paymentCode, ENT_XML1, 'UTF-8') . '</paymentCode>
                                <threeDomainSecurityEligible>' . htmlspecialchars($threeDomainSecurityEligible, ENT_XML1, 'UTF-8') . '</threeDomainSecurityEligible>
                                <transactionFeeApplies/>
                                <MCONumber>' . htmlspecialchars($MCONumber, ENT_XML1, 'UTF-8') . '</MCONumber>
                             </miscChargeOrder>
                             <payLater/>
                             <paymentAmount>
                             <currency>
                                <code>' . htmlspecialchars($code, ENT_XML1, 'UTF-8') . '</code>
                             </currency>
                             <mileAmount/>
                             <value>' . htmlspecialchars($value, ENT_XML1, 'UTF-8') . '</value>
                             </paymentAmount>
                             <paymentType>' . htmlspecialchars($paymentType, ENT_XML1, 'UTF-8') . '</paymentType>
                             <primaryPayment>' . htmlspecialchars($primaryPayment, ENT_XML1, 'UTF-8') . '</primaryPayment>
                          </paymentDetailList>
                          </paymentDetails>
                          <creditCardList>
                              <capturePaymentToolNumber>true</capturePaymentToolNumber>
                              <paymentReferenceID>1337</paymentReferenceID>
                              <cardHolderName>TEST TEST</cardHolderName>
                              <cardNumber>1111111111111111</cardNumber>
                              <validUntil>12/2018</validUntil>
                              <validationCode>111</validationCode>
                           </creditCardList>
                       </fullfillment>
                       <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                    </AirTicketReservationRequest>
                 </impl:TicketReservation>
              </soapenv:Body>
           </soapenv:Envelope>
        ';
        return $xml;
    }

    public function ticketReservationCommitTwoA (
        $companyNameCitycode,
        $companyNameCode,
        $companyNameCodeContext,
        $companyFullName,
        $companyShortName,
        $countryCode,
        $ID,
        $referenceID,
        $capturePaymentToolNumber,
        $paymentCode,
        $threeDomainSecurityEligible,
        $MCONumber,
        $paymentAmountCurrencyCode,
        $paymentAmountValue,
        $paymentType,
        $primaryPayment,
        $requestPurpose
    ) {
        
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
           <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
              <soapenv:Header/>
              <soapenv:Body>
                    <impl:TicketReservation>
                    <!-- Optional: -->
                    <AirTicketReservationRequest>
                       <!-- Optional: -->
                       <clientInformation>
                          <clientIP>129.0.0.1</clientIP>
                          <member>false</member>
                          <password>SCINTILLA</password>
                          <userName>SCINTILLA</userName>
                          <preferredCurrency>NGN</preferredCurrency>
                       </clientInformation>
                       <!-- Optional: -->
                       <bookingReferenceID>
                          <companyName>
                             <cityCode>' . htmlspecialchars($companyNameCitycode, ENT_XML1, 'UTF-8') . '</cityCode>
                             <code>' . htmlspecialchars($companyNameCode, ENT_XML1, 'UTF-8') . '</code>
                             <codeContext>' . htmlspecialchars($companyNameCodeContext, ENT_XML1, 'UTF-8') . '</codeContext>
                             <companyFullName>' . htmlspecialchars($companyFullName, ENT_XML1, 'UTF-8') . '</companyFullName>
                             <companyShortName>' . htmlspecialchars($companyShortName, ENT_XML1, 'UTF-8') . '</companyShortName>
                             <countryCode>' . htmlspecialchars($countryCode, ENT_XML1, 'UTF-8') . '</countryCode>
                          </companyName>
                          <ID>' . htmlspecialchars($ID, ENT_XML1, 'UTF-8') . '</ID>
                          <referenceID>' . htmlspecialchars($referenceID, ENT_XML1, 'UTF-8') . '</referenceID>
                       </bookingReferenceID>
                       <!-- Optional: -->
                       <fullfillment>
                          <paymentDetails>
                             <paymentDetailList>
                                <miscChargeOrder>
                                   <avsEnabled/>
                                   <capturePaymentToolNumber>' . htmlspecialchars($capturePaymentToolNumber, ENT_XML1, 'UTF-8') . '</capturePaymentToolNumber>
                                   <paymentCode>' . htmlspecialchars($paymentCode, ENT_XML1, 'UTF-8') . '</paymentCode>
                                   <threeDomainSecurityEligible>' . htmlspecialchars($threeDomainSecurityEligible, ENT_XML1, 'UTF-8') . '</threeDomainSecurityEligible>
                                   <transactionFeeApplies/>
                                   <MCONumber>' . htmlspecialchars($MCONumber, ENT_XML1, 'UTF-8') . '</MCONumber>
                                </miscChargeOrder>
                                <payLater/>
                                <paymentAmount>
                                   <currency>
                                      <code>' . htmlspecialchars($paymentAmountCurrencyCode, ENT_XML1, 'UTF-8') . '</code>
                                   </currency>
                                   <mileAmount/>
                                   <value>' . htmlspecialchars($paymentAmountValue, ENT_XML1, 'UTF-8') . '</value>
                                </paymentAmount>
                                <paymentType>' . htmlspecialchars($paymentType, ENT_XML1, 'UTF-8') . '</paymentType>
                                <primaryPayment>' . htmlspecialchars($primaryPayment, ENT_XML1, 'UTF-8') . '</primaryPayment>
                             </paymentDetailList>
                          </paymentDetails>
                       </fullfillment>
                       <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                       </AirTicketReservationRequest>
                 </impl:TicketReservation>
              </soapenv:Body>
           </soapenv:Envelope>
        ';

        return $xml;
     }

   public function ticketReservationViewOnlyTwoA(
      $cityCode,
      $code,
      $codeContext,
      $companyFullName,
      $companyShortName,
      $countryCode,
      $ID,
      $referenceID,
      $requestPurpose
   ) {

      $xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:impl="http://impl.soap.ws.crane.hititcs.com/">
               <soapenv:Header/>
                  <soapenv:Body>
                  <impl:TicketReservation>
                  <!-- Optional: -->
                  <AirTicketReservationRequest>
                  <!-- Optional: -->
                  <clientInformation>
                  <clientIP>129.0.0.1</clientIP>
                  <member>false</member>
                  <password>SCINTILLA</password>
                  <userName>SCINTILLA</userName>
                  <preferredCurrency>NGN</preferredCurrency>
                  </clientInformation>
                  <!-- Optional: -->
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
                  <!-- Optional: -->
                  <requestPurpose>' . htmlspecialchars($requestPurpose, ENT_XML1, 'UTF-8') . '</requestPurpose>
                  </AirTicketReservationRequest>
                  </impl:TicketReservation>
                  </soapenv:Body>
               </soapenv:Envelope>
               ';

         return $xml;
   }
}