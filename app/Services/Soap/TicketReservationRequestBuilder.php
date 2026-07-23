<?php

namespace App\Services\Soap;

use App\Services\Utility\IndexUtils;

class TicketReservationRequestBuilder
   {
      
      protected $indexUtils;
      protected $craneUsername;
      protected $cranePassword;

      public function __construct(IndexUtils $indexUtils) {
         $this->indexUtils = $indexUtils;
         $this->craneUsername = config('app.crane.username');            
         $this->cranePassword = config('app.crane.password');

      }  

      public function ticketReservationViewOnly(
         $preferredCurrency,
         $ID,
         $referenceID,
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
                           <password>'. htmlspecialchars($this->cranePassword, ENT_XML1, 'UTF-8') .'</password>
                           <userName>'. htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') .'</userName>
                           <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>
                        </clientInformation>
                        <!-- Optional: -->
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
                        <!-- Optional: -->
                        <requestPurpose>VIEW_ONLY</requestPurpose>
                     </AirTicketReservationRequest>
                  </impl:TicketReservation>
               </soapenv:Body>
            </soapenv:Envelope>';
         return $xml;
      }


      public function ticketReservationCommit(
         $preferredCurrency,
         $ID,
         $referenceID,
         $value        
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
                           <password>'. htmlspecialchars($this->cranePassword, ENT_XML1, 'UTF-8') .'</password>
                           <userName>'. htmlspecialchars($this->craneUsername, ENT_XML1, 'UTF-8') .'</userName>
                           <preferredCurrency>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</preferredCurrency>
                        </clientInformation>
                        <!-- Optional: -->
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
                        <!-- Optional: -->
                        <fullfillment>
                           <paymentDetails>
                           <paymentDetailList>
                              <miscChargeOrder>
                                 <avsEnabled/>
                                 <capturePaymentToolNumber>false</capturePaymentToolNumber>
                                 <paymentCode>INV</paymentCode>
                                 <threeDomainSecurityEligible>false</threeDomainSecurityEligible>
                                 <transactionFeeApplies/>
                                 <MCONumber>' . $this->indexUtils->checkCurrency($preferredCurrency) . '</MCONumber>
                              </miscChargeOrder>
                              <payLater/>
                              <paymentAmount>
                                 <currency>
                                    <code>' . htmlspecialchars($preferredCurrency, ENT_XML1, 'UTF-8') . '</code>
                                 </currency>
                                 <mileAmount/>
                                 <value>' . htmlspecialchars($value, ENT_XML1, 'UTF-8') . '</value>
                              </paymentAmount>
                              <paymentType>MISC_CHARGE_ORDER</paymentType>
                              <primaryPayment>true</primaryPayment>
                           </paymentDetailList>
                           </paymentDetails>
                        </fullfillment>
                        <requestPurpose>COMMIT</requestPurpose>
                     </AirTicketReservationRequest>
                  </impl:TicketReservation>
               </soapenv:Body>
            </soapenv:Envelope>
         ';
         return $xml;
      }

   

}