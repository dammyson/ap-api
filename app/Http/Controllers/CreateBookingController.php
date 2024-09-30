<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BookingRecord;
use App\Http\Controllers\Controller;
use App\Services\Soap\CreateBookingBuilder;
use App\Http\Requests\Test\Booking\CreateBookingOWRequest;
use App\Http\Requests\Test\Booking\CreateBookingRTRequest;
use App\Http\Requests\Test\Booking\CreateBookingTwoARequest;

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

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            $timeLimit = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimit"];
            $timeLimitUTC = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimitUTC"];
            
            $bookingId = $bookingReferenceIDList['ID'];
            $bookingReferenceID = $bookingReferenceIDList['referenceID'];
            $user = $request->user();

            BookingRecord::create([
                'peace_id' => $user->peace_id,
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID
            ]);

            $bookingDetails = [
                "bookingReferenceIDList" => $bookingReferenceIDList,
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];      
            

            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "booking_reference_id" => $bookingDetails
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
        $airTravelerListChild = $validated['airTravelerChildList']; 
        $requestPurpose = $request->input('requestPurpose');
        $specialServiceRequestList = $validated['specialServiceRequestList'];
        

        $xml = $this->createBookingBuilder->createBookingTwoA(
            $CreateBookOriginDestinationOptionList,
            $airTravelerList,
            $airTravelerListChild,
            $requestPurpose,
            $specialServiceRequestList
        );

       // dd($xml);

        $function = 'http://impl.soap.ws.crane.hititcs.com/CreateBooking';
        try {

            $response = $this->craneOTASoapService->run($function, $xml);

            $bookingReferenceIDList = $response['AirBookingResponse']['airBookingList']['airReservation']["bookingReferenceIDList"];
            $timeLimit = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimit"];
            $timeLimitUTC = $response["AirBookingResponse"]["airBookingList"]["airReservation"]["ticketTimeLimitUTC"];
            $bookingId = $bookingReferenceIDList['ID'];
            $bookingReferenceID = $bookingReferenceIDList['referenceID'];
            $user = $request->user();

            BookingRecord::create([
                'peace_id' => $user->peace_id,
                'booking_id' => $bookingId,
                'booking_reference_id' => $bookingReferenceID
            ]);
            $bookingDetails = [
                "bookingReferenceIDList" => $bookingReferenceIDList,
                "timeLimit" => $timeLimit,
                "timeLimitUTC" => $timeLimitUTC
            ];


            return response()->json([
                "error" => false,
                "message" => "Flight booked successfully",
                "bookingDetails" => $bookingDetails
            ], 200);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

  
}
