<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Test\Booking\CreateBookingOWRequest;
use App\Http\Requests\Test\Booking\CreateBookingRTRequest;
use App\Http\Requests\Test\Booking\CreateBookingTwoARequest;
use App\Services\Soap\CreateBookingBuilder;
use Illuminate\Http\Request;

class CreateBookingController extends Controller
{
    protected $createBookingBuilder;
    protected $craneOTASoapService;
    protected $craneAncillaryOTASoapService;

    public function __construct(CreateBookingBuilder $createBookingBuilder) {
        $this->createBookingBuilder = $createBookingBuilder;

        $this->craneOTASoapService = app('CraneOTASoapService');
        $this->craneAncillaryOTASoapService = app('CraneAncillaryOTASoapService');
    }

    public function createBookingRT(CreateBookingRTRequest $request) {
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];        
        $requestPurpose = $request->input('requestPurpose');
        $capturePayment = $request->input('capturePayment');
        $paymentCode = $request->input('paymentCode');
        $threeDomainSecurityEligible = $request->input('threeDomainSecurityEligible');
        $MCONumber = $request->input('MCONumber');
        $paymentAmountCurrencyCode = $request->input('paymentAmountCurrencyCode');
        $paymentType = $request->input('paymentType');
        $primaryPayment = $request->input('primaryPayment');

        $xml = $this->createBookingBuilder->createBookingRT(            
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,

            $requestPurpose,
            $capturePayment,
            $paymentCode,
            $threeDomainSecurityEligible,
            $MCONumber,
            $paymentAmountCurrencyCode,
            $paymentType,
            $primaryPayment
        );
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            dd($bookingReferenceIDList);
            // $result = "";
           

            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_reference_id" =>$bookingReferenceIDList
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingOW(CreateBookingOWRequest $request) {

        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];
        $requestPurpose = $validated["requestPurpose"];

        $xml = $this->createBookingBuilder->createBookingOW(
            $CreateBookOriginDestinationOptionList, 
            $airTravelerList,
            $requestPurpose
        );
       
        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);
            // dd($response);

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            dd($bookingReferenceIDList);
            // $result = "";

            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_reference_id" =>$bookingReferenceIDList
            ], 200);
            
            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function createBookingTwoA(CreateBookingTwoARequest $request){
        $validated = $request->validated();
        $CreateBookOriginDestinationOptionList = $validated["CreateBookOriginDestinationOptionList"];
        $airTravelerList = $validated["airTravelerList"];   

        $airTravelerListGenderThree = $request->input('airTravelerListGenderThree');
        $airTravelerListBirthDateThree = $request->input('airTravelerListBirthDateThree');
        $passengerTypeCodeThree = $request->input('passengerTypeCodeThree');
        $personNameGivenNameThree = $request->input('personNameGivenNameThree');
        $personNameSurnameThree = $request->input('personNameSurnameThree');
        $contactPersonShareContactInfoThree = $request->input('contactPersonShareContactInfoThree');
        $requestedSeatCountThree = $request->input('requestedSeatCountThree');
        $requestPurposeThree = $request->input('requestPurposeThree');
        $airTravelerSequenceOne = $request->input('airTravelerSequenceOne');
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
        $SSRCodeOne = $request->input('SSRCodeOne');
        $SSRExplanationOne = $request->input('SSRExplanationOne');
        $ticketedServiceQuantityOne = $request->input('ticketedServiceQuantityOne');
        $ticketedStatusOne = $request->input('ticketedStatusOne');  
        $airTravelerSequenceTwo = $request->input('airTravelerSequenceTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $SSRCodeTwo = $request->input('SSRCodeTwo');
        $SSRExplanationTwo = $request->input('SSRExplanationTwo');
        $ticketedServiceQuantityTwo = $request->input('ticketedServiceQuantityTwo');
        $ticketedStatusTwo = $request->input('ticketedStatusTwo'); 

        $xml = $this->createBookingBuilder->createBookingTwoA(
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,
            $airTravelerListGenderThree,
            $airTravelerListBirthDateThree,
            $passengerTypeCodeThree,
            $personNameGivenNameThree,
            $personNameSurnameThree,
            $contactPersonShareContactInfoThree,
            $requestedSeatCountThree,
            $requestPurposeThree,
            $airTravelerSequenceOne,
            $flightSegmentSequenceOne,
            $SSRCodeOne,
            $SSRExplanationOne,
            $ticketedServiceQuantityOne,
            $ticketedStatusOne,  
            $airTravelerSequenceTwo,
            $flightSegmentSequenceTwo,
            $SSRCodeTwo,
            $SSRExplanationTwo,
            $ticketedServiceQuantityTwo,
            $ticketedStatusTwo
        );

       // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"]["ID"];
            // $result = "";


            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_reference_id" =>$bookingReferenceIDList
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
}
