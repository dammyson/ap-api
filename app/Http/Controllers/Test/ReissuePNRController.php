<?php

namespace App\Http\Controllers\Test;

use Carbon\Carbon;
use App\Models\Flight;
use App\Models\Booking;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Utility\CheckArray;
use App\Services\Soap\ReissuePnrTestBuilder;
use App\Services\Wallet\VerificationService;
use App\Services\Wallet\FlutterVerificationService;
use App\Http\Requests\Reissue\ReissuePnrPreviewRequest;

class ReissuePNRController extends Controller
{
    protected $craneReissuePnrOTAService;
    protected $reissusePNRBuilder;
    protected $checkArray;

    public function __construct(ReissuePnrTestBuilder $reissusePNRBuilder, CheckArray $checkArray) {
        $this->craneReissuePnrOTAService = app('CraneReissuePnrOTAService');
        // app('CraneFareRulesService');
        $this->reissusePNRBuilder = $reissusePNRBuilder;
        $this->checkArray = $checkArray;
    } 

    private function getFlightHours($flightDuration) {
        $hours = 0;
        $minutes = 0;

        if (preg_match('/PT(\d+H)?(\d+M)?/', $flightDuration, $matches)) {
            // Check if hours and minutes are present in the matched groups
            if (!empty($matches[1])) {
                $hours = (int) rtrim($matches[1], 'H');
            }
            if (!empty($matches[2])) {
                $minutes = (int) rtrim($matches[2], 'M');
            }
        }

        // Calculate total duration in hours
        $totalHours = $hours + ($minutes / 60);

        if (is_float($totalHours) && $totalHours != floor($totalHours)) {
            $totalHours = round($totalHours, 2);
        }

        return $totalHours;
    }

    public function reissueTicketPNR(ReissuePnrPreviewRequest $request, $invoiceId = null) {
        try{
            $ID = $request->input('ID');
            $referenceID = $request->input('referenceID');
            $bookingClassCabinOne = $request->input('bookingClassCabinOne');
            $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne');
            $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne');
            $bookignClassResBookDesigStatusCodeOne = $request->input('bookignClassResBookDesigStatusCodeOne');
            $fareInfoCabinOne = $request->input('fareInfoCabinOne');
            $fareInfocabinClassCodeOne = $request->input('fareInfocabinClassCodeOne');
            $fareInfoCabinAllowanceTypeOne = $request->input('fareInfoCabinAllowanceTypeOne');
            $maxAllowedPiecesOne = $request->input('maxAllowedPiecesOne');
            $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne');
            $weightOne = $request->input('weightOne');
            $fareGroupNameOne = $request->input('fareGroupNameOne');
            $fareReferenceCodeOne = $request->input('fareReferenceCodeOne');
            $fareReferenceIDOne = $request->input('fareReferenceIDOne');
            $fareReferenceNameOne = $request->input('fareReferenceNameOne');
            $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
            $portTaxOne = $request->input('portTaxOne');
            $resBookDesigCodeOne = $request->input('resBookDesigCodeOne');
            $airlineCodeOne = $request->input('airlineCodeOne');
            $airlinecompanyFullNameOne = $request->input('airlinecompanyFullNameOne');
            $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne');
            $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne');
            $arrivalAirportLocationNameLanguageOne = $request->input('arrivalAirportLocationNameLanguageOne');
            $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
            $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne');
            $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne');
            $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne');
            $arrivalAirportCodeContextOne = $request->input('arrivalAirportCodeContextOne');
            $arrivalAirportLanguageOne = $request->input('arrivalAirportLanguageOne');
            $arrivalAirportLocationCodeOne = $request->input('arrivalAirportLocationCodeOne');
            $arrivalAirportLocationNameOne = $request->input('arrivalAirportLocationNameOne');
            $arrivalAirportTimeZoneInfoOne = $request->input('arrivalAirportTimeZoneInfoOne');
            $arrivalDateTimeOne = $request->input('arrivalDateTimeOne');
            $arrivalDateTimeUTCOne = $request->input('arrivalDateTimeUTCOne');
            $departureAirportCityLocationCodeOne = $request->input('departureAirportCityLocationCodeOne');
            $departureAirportCityLocationNameOne = $request->input('departureAirportCityLocationNameOne');
            $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
            $departureAirportCountryLocationCodeOne = $request->input('departureAirportCountryLocationCodeOne');
            $departureAirportCountryLocationNameOne = $request->input('departureAirportCountryLocationNameOne');
            $departureAirportCountryLocationNameLanguageOne = $request->input('departureAirportCountryLocationNameLanguageOne');
            $departureAirportCountryCodeOne = $request->input('departureAirportCountryCodeOne');
            $departureAirportCodeContextOne = $request->input('departureAirportCodeContextOne');
            $departureAirportLanguageOne = $request->input('departureAirportLanguageOne');
            $departureAirportLocationCodeOne = $request->input('departureAirportLocationCodeOne');
            $departureAirportLocationNameOne = $request->input('departureAirportLocationNameOne');
            $departureTimeZoneInfoOne = $request->input('departureTimeZoneInfoOne');
            $departureDateTimeOne = $request->input('departureDateTimeOne');
            $departureDateTimeUTCOne = $request->input('departureDateTimeUTCOne');
            $flightNumberOne = $request->input('flightNumberOne');
            $flightSegmentIDOne = $request->input('flightSegmentIDOne');
            $ondControlledOne = $request->input('ondControlledOne');
            $sectorOne = $request->input('sectorOne');
            $codeShareOne = $request->input('codeShareOne');
            $distanceOne = $request->input('distanceOne');
            $equipmentAirEquipTypeOne = $request->input('equipmentAirEquipTypeOne');
            $equipmentChangeOfGaugeOne = $request->input('equipmentChangeOfGaugeOne');
            $flightNotesOne = $request->input('flightNotesOne');
            $flownMileageQtyOne = $request->input('flownMileageQtyOne');
            $iatciFlightOne = $request->input('iatciFlightOne');
            $journeyDurationOne = $request->input('journeyDurationOne');
            $onTimeRateOne = $request->input('onTimeRateOne');
            $remarkOne = $request->input('remarkOne');
            $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne');
            $stopQuantityOne = $request->input('stopQuantityOne');
            $ticketTypeOne = $request->input('ticketTypeOne');
            
            $actionCodeTwo = $request->input('actionCodeTwo');
            $addOnSegmentTwo = $request->input('addOnSegmentTwo');
            $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
            $bookingCabinResBookDesigCodeTwo = $request->input('bookingCabinResBookDesigCodeTwo');
            $bookingCabinResBookDesigQuantityTwo = $request->input('bookingCabinResBookDesigQuantityTwo');
            $fareInfoCabinTwo = $request->input('fareInfoCabinTwo');
            $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo');
            $allowanceTypeTwo = $request->input('allowanceTypeTwo');
            $maxAllowedPiecesTwo = $request->input('maxAllowedPiecesTwo');
            $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo');
            $weightTwo = $request->input('weightTwo');
            $fareGroupNameTwo = $request->input('fareGroupNameTwo');
            $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo');
            $fareReferenceIDTwo = $request->input('fareReferenceIDTwo');
            $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
            $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
            $resBookDesigCodeTwo = $request->input('resBookDesigCodeTwo');
            $airlineCodeTwo = $request->input('airlineCodeTwo');
            $airlineCodeContextTwo = $request->input('airlineCodeContextTwo');
            $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
            $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo');
            $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo');
            $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
            $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo');
            $arrivalAirportLocationNameLanguageTwo = $request->input('arrivalAirportLocationNameLanguageTwo');
            $arrivalAirportCountryCodeTwo = $request->input('arrivalAirportCountryCodeTwo');
            $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo');
            $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
            $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo');
            $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo');
            $arrivalAirportTerminalTwo = $request->input('arrivalAirportTerminalTwo');
            $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
            $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo');
            $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
            $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo');
            $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo');
            $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo');
            $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo');
            $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
            $departureAirportLocationNameLanguageTwo = $request->input('departureAirportLocationNameLanguageTwo');
            $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo');
            $departureAirportCodeContextTwo = $request->input('departureAirportCodeContextTwo');
            $departureAirportLanguageTwo = $request->input('departureAirportLanguageTwo');
            $departureAirportLocationCodeTwo = $request->input('departureAirportLocationCodeTwo');
            $departureAirportLocationNameTwo = $request->input('departureAirportLocationNameTwo');
            $departureAirportTimeZoneInfoTwo = $request->input('departureAirportTimeZoneInfoTwo');
            $departureDateTimeTwo = $request->input('departureDateTimeTwo');
            $departureDateTimeUTCTwo = $request->input('departureDateTimeUTCTwo');
            $flightNumberTwo = $request->input('flightNumberTwo');
            $flightSegmentIDTwo = $request->input('flightSegmentIDTwo');
            $ondControlledTwo = $request->input('ondControlledTwo');
            $sectorTwo = $request->input('sectorTwo');
            $codeShareTwo = $request->input('codeShareTwo');
            $distanceTwo = $request->input('distanceTwo');
            $equipmentAirEquipTypeTwo = $request->input('equipmentAirEquipTypeTwo');
            $equipmentChangeOfGaugeTwo = $request->input('equipmentChangeOfGaugeTwo');
            $flightNotesTwo = $request->input('flightNotesTwo');
            $flownMileageQtyTwo = $request->input('flownMileageQtyTwo');
            $iatciFlightTwo = $request->input('iatciFlightTwo');
            $journeyDurationTwo = $request->input('journeyDurationTwo');
            $onTimeRateTwo = $request->input('onTimeRateTwo');
            $remarkTwo = $request->input('remarkTwo');
            $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo');
            $segmentStatusByFirstLegTwo = $request->input('segmentStatusByFirstLegTwo');
            $stopQuantityTwo = $request->input('stopQuantityTwo');
            $involuntaryPermissionGivenTwo = $request->input('involuntaryPermissionGivenTwo');
            $legStatusTwo = $request->input('legStatusTwo');
            $referenceIDTwo = $request->input('referenceIDTwo');
            $responseCodeTwo = $request->input('responseCodeTwo');
            $sequenceNumberTwo = $request->input('sequenceNumberTwo');
            $statusTwo = $request->input('statusTwo');
            $preferredCurrency = $request->input('preferredCurrency');

            // dd($preferredCurrency);

            $user = $request->user();


            $booking = Booking::where('booking_id', $ID)->Where('peace_id', $user->peace_id)->first();
            
            // dd($booking);

                
            if (!$booking) {
                return response()->json([
                    "error" => true,
                    "message" => "you are not authorised to carry out this action"
                ], 401);
            }
                

            // dd("stopped here");

            $xml = $this->reissusePNRBuilder->reissuePnr(
                $preferredCurrency,
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
            );

            // dd($xml);
            $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrPreview';

            $response = $this->craneReissuePnrOTAService->run($function, $xml);
            $preferredCurrency = $response['ReissuePnrPreviewResponse']['airBookingList']['ticketInfo']['totalAmount']['currency']['code'];
            // check if response is true
            // check if invoice has been previously paid for
            $invoice = Invoice::find($invoiceId);
            if ($invoice->isPaid) {
                // generate a new invoice if previous invoice has been paid for
                $invoice = new Invoice();
                $invoice->booking_id = $ID;
                $invoice->currency = $preferredCurrency;
                $invoice->is_paid = false;

            }

            $amount = $response["ReissuePnrPreviewResponse"]["airBookingList"]["ticketInfo"]["totalAmount"]["value"];

            $invoice->amount = $amount;

            $invoice->save();
            $bookOriginDestinationOptionLists = $response["ReissuePnrPreviewResponse"]["airBookingList"]["airReservation"]["airItinerary"]["bookOriginDestinationOptions"]["bookOriginDestinationOptionList"];
            
            if (!$this->checkArray->isAssociativeArray($bookOriginDestinationOptionLists)) {
                foreach ($bookOriginDestinationOptionLists as $bookOriginDestinationOptionList) {
                    $arrival_time = $bookOriginDestinationOptionList["bookFlightSegmentList"]["flightSegment"]["arrivalDateTime"];
                    $departure_time = $bookOriginDestinationOptionList["bookFlightSegmentList"]["flightSegment"]["departureDateTime"];
                    $newOrigin = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']['arrivalAirport']['locationName'];
                    $newDestination = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']['departureAirport']['locationName'];
                    $newTicketType = $bookOriginDestinationOptionList["bookFlightSegmentList"]["bookingClass"]["cabin"];
                    
                    $newOriginCity = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']['arrivalAirport']['locationCode'];
                    
                    $newDestinationCity = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']['departureAirport']['locationCode'];
                    $newFlightDistance = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']["distance"];
                    $newFlightNumber = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']["flightNumber"];
                    $newFlightDuration = $bookOriginDestinationOptionList["bookFlightSegmentList"]['flightSegment']["journeyDuration"];
                    

                    $newTotalHours = $this->getFlightHours($newFlightDuration);

                    Flight::where('booking_id', $ID)->update([
                        "origin" => $newOrigin,
                        "destination" => $newDestination,
                        'arrival_time' => $arrival_time, 
                        'departure_time'=> $departure_time,
                        "origin_city" => $newOriginCity,
                        "destination_city" => $newDestinationCity,
                        'ticket_type' => $newTicketType,
                        "flight_number" => $newFlightNumber,
                        "flight_distance" => $newFlightDistance,
                        "flight_duration" => $newTotalHours
                    ]);
                }

            } else {
                $arrival_time = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["flightSegment"]["arrivalDateTime"];
                $departure_time = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["flightSegment"]["departureDateTime"];
                $newOrigin = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']['arrivalAirport']['locationName'];
                $newDestination = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']['departureAirport']['locationName'];
                $newTicketType = $bookOriginDestinationOptionLists["bookFlightSegmentList"]["bookingClass"]["cabin"];
                
                $newOriginCity = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']['arrivalAirport']['locationCode'];
                
                $newDestinationCity = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']['departureAirport']['locationCode'];
                $newFlightDistance = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']["distance"];
                $newFlightNumber = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']["flightNumber"];
                $newFlightDuration = $bookOriginDestinationOptionLists["bookFlightSegmentList"]['flightSegment']["journeyDuration"];
                

                $newTotalHours = $this->getFlightHours($newFlightDuration);

                Flight::where('booking_id', $ID)->update([
                    "origin" => $newOrigin,
                    "destination" => $newDestination,
                    'arrival_time' => $arrival_time, 
                    'departure_time'=> $departure_time,
                    "origin_city" => $newOriginCity,
                    "destination_city" => $newDestinationCity,
                    'ticket_type' => $newTicketType,
                    "flight_number" => $newFlightNumber,
                    "flight_distance" => $newFlightDistance,
                    "flight_duration" => $newTotalHours
                ]);
            }           

            $ticketCount = Flight::where('booking_id', $ID)->count();
            // create invoice_items table
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product' => 'Ticket', 
                'quantity' => $ticketCount,
                'price' => $amount
            ]);
            
            return response()->json([
                "error" => false,
                "invoice_id" => $invoice->id,
                "invoice" => $invoice,
                "response" => $response
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong",
                "actual_error" => $th->getMessage()
            ], 500);
        }  
    }

    public function reissueTicketCommit (ReissuePnrPreviewRequest $request) {
        try {
            $ID = $request->input('ID');
            $referenceID = $request->input('referenceID');
            $bookingClassCabinOne = $request->input('bookingClassCabinOne');
            $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne');
            $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne');
            $bookignClassResBookDesigStatusCodeOne = $request->input('bookignClassResBookDesigStatusCodeOne');
            $fareInfoCabinOne = $request->input('fareInfoCabinOne');
            $fareInfocabinClassCodeOne = $request->input('fareInfocabinClassCodeOne');
            $fareInfoCabinAllowanceTypeOne = $request->input('fareInfoCabinAllowanceTypeOne');
            $maxAllowedPiecesOne = $request->input('maxAllowedPiecesOne');
            $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne');
            $weightOne = $request->input('weightOne');
            $fareGroupNameOne = $request->input('fareGroupNameOne');
            $fareReferenceCodeOne = $request->input('fareReferenceCodeOne');
            $fareReferenceIDOne = $request->input('fareReferenceIDOne');
            $fareReferenceNameOne = $request->input('fareReferenceNameOne');
            $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
            $portTaxOne = $request->input('portTaxOne');
            $resBookDesigCodeOne = $request->input('resBookDesigCodeOne');
            $airlineCodeOne = $request->input('airlineCodeOne');
            $airlinecompanyFullNameOne = $request->input('airlinecompanyFullNameOne');
            $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne');
            $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne');
            $arrivalAirportLocationNameLanguageOne = $request->input('arrivalAirportLocationNameLanguageOne');
            $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
            $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne');
            $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne');
            $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne');
            $arrivalAirportCodeContextOne = $request->input('arrivalAirportCodeContextOne');
            $arrivalAirportLanguageOne = $request->input('arrivalAirportLanguageOne');
            $arrivalAirportLocationCodeOne = $request->input('arrivalAirportLocationCodeOne');
            $arrivalAirportLocationNameOne = $request->input('arrivalAirportLocationNameOne');
            $arrivalAirportTimeZoneInfoOne = $request->input('arrivalAirportTimeZoneInfoOne');
            $arrivalDateTimeOne = $request->input('arrivalDateTimeOne');
            $arrivalDateTimeUTCOne = $request->input('arrivalDateTimeUTCOne');
            $departureAirportCityLocationCodeOne = $request->input('departureAirportCityLocationCodeOne');
            $departureAirportCityLocationNameOne = $request->input('departureAirportCityLocationNameOne');
            $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
            $departureAirportCountryLocationCodeOne = $request->input('departureAirportCountryLocationCodeOne');
            $departureAirportCountryLocationNameOne = $request->input('departureAirportCountryLocationNameOne');
            $departureAirportCountryLocationNameLanguageOne = $request->input('departureAirportCountryLocationNameLanguageOne');
            $departureAirportCountryCodeOne = $request->input('departureAirportCountryCodeOne');
            $departureAirportCodeContextOne = $request->input('departureAirportCodeContextOne');
            $departureAirportLanguageOne = $request->input('departureAirportLanguageOne');
            $departureAirportLocationCodeOne = $request->input('departureAirportLocationCodeOne');
            $departureAirportLocationNameOne = $request->input('departureAirportLocationNameOne');
            $departureTimeZoneInfoOne = $request->input('departureTimeZoneInfoOne');
            $departureDateTimeOne = $request->input('departureDateTimeOne');
            $departureDateTimeUTCOne = $request->input('departureDateTimeUTCOne');
            $flightNumberOne = $request->input('flightNumberOne');
            $flightSegmentIDOne = $request->input('flightSegmentIDOne');
            $ondControlledOne = $request->input('ondControlledOne');
            $sectorOne = $request->input('sectorOne');
            $codeShareOne = $request->input('codeShareOne');
            $distanceOne = $request->input('distanceOne');
            $equipmentAirEquipTypeOne = $request->input('equipmentAirEquipTypeOne');
            $equipmentChangeOfGaugeOne = $request->input('equipmentChangeOfGaugeOne');
            $flightNotesOne = $request->input('flightNotesOne');
            $flownMileageQtyOne = $request->input('flownMileageQtyOne');
            $iatciFlightOne = $request->input('iatciFlightOne');
            $journeyDurationOne = $request->input('journeyDurationOne');
            $onTimeRateOne = $request->input('onTimeRateOne');
            $remarkOne = $request->input('remarkOne');
            $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne');
            $stopQuantityOne = $request->input('stopQuantityOne');
            $ticketTypeOne = $request->input('ticketTypeOne');
            
            $actionCodeTwo = $request->input('actionCodeTwo');
            $addOnSegmentTwo = $request->input('addOnSegmentTwo');
            $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
            $bookingCabinResBookDesigCodeTwo = $request->input('bookingCabinResBookDesigCodeTwo');
            $bookingCabinResBookDesigQuantityTwo = $request->input('bookingCabinResBookDesigQuantityTwo');
            $fareInfoCabinTwo = $request->input('fareInfoCabinTwo');
            $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo');
            $allowanceTypeTwo = $request->input('allowanceTypeTwo');
            $maxAllowedPiecesTwo = $request->input('maxAllowedPiecesTwo');
            $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo');
            $weightTwo = $request->input('weightTwo');
            $fareGroupNameTwo = $request->input('fareGroupNameTwo');
            $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo');
            $fareReferenceIDTwo = $request->input('fareReferenceIDTwo');
            $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
            $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
            $resBookDesigCodeTwo = $request->input('resBookDesigCodeTwo');
            $airlineCodeTwo = $request->input('airlineCodeTwo');
            $airlineCodeContextTwo = $request->input('airlineCodeContextTwo');
            $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
            $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo');
            $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo');
            $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
            $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo');
            $arrivalAirportLocationNameLanguageTwo = $request->input('arrivalAirportLocationNameLanguageTwo');
            $arrivalAirportCountryCodeTwo = $request->input('arrivalAirportCountryCodeTwo');
            $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo');
            $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
            $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo');
            $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo');
            $arrivalAirportTerminalTwo = $request->input('arrivalAirportTerminalTwo');
            $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
            $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo');
            $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
            $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo');
            $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo');
            $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo');
            $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo');
            $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
            $departureAirportLocationNameLanguageTwo = $request->input('departureAirportLocationNameLanguageTwo');
            $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo');
            $departureAirportCodeContextTwo = $request->input('departureAirportCodeContextTwo');
            $departureAirportLanguageTwo = $request->input('departureAirportLanguageTwo');
            $departureAirportLocationCodeTwo = $request->input('departureAirportLocationCodeTwo');
            $departureAirportLocationNameTwo = $request->input('departureAirportLocationNameTwo');
            $departureAirportTimeZoneInfoTwo = $request->input('departureAirportTimeZoneInfoTwo');
            $departureDateTimeTwo = $request->input('departureDateTimeTwo');
            $departureDateTimeUTCTwo = $request->input('departureDateTimeUTCTwo');
            $flightNumberTwo = $request->input('flightNumberTwo');
            $flightSegmentIDTwo = $request->input('flightSegmentIDTwo');
            $ondControlledTwo = $request->input('ondControlledTwo');
            $sectorTwo = $request->input('sectorTwo');
            $codeShareTwo = $request->input('codeShareTwo');
            $distanceTwo = $request->input('distanceTwo');
            $equipmentAirEquipTypeTwo = $request->input('equipmentAirEquipTypeTwo');
            $equipmentChangeOfGaugeTwo = $request->input('equipmentChangeOfGaugeTwo');
            $flightNotesTwo = $request->input('flightNotesTwo');
            $flownMileageQtyTwo = $request->input('flownMileageQtyTwo');
            $iatciFlightTwo = $request->input('iatciFlightTwo');
            $journeyDurationTwo = $request->input('journeyDurationTwo');
            $onTimeRateTwo = $request->input('onTimeRateTwo');
            $remarkTwo = $request->input('remarkTwo');
            $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo');
            $segmentStatusByFirstLegTwo = $request->input('segmentStatusByFirstLegTwo');
            $stopQuantityTwo = $request->input('stopQuantityTwo');
            $involuntaryPermissionGivenTwo = $request->input('involuntaryPermissionGivenTwo');
            $legStatusTwo = $request->input('legStatusTwo');
            $referenceIDTwo = $request->input('referenceIDTwo');
            $responseCodeTwo = $request->input('responseCodeTwo');
            $sequenceNumberTwo = $request->input('sequenceNumberTwo');
            $transactionDescription = $request->input("transactionDescription");
            $statusTwo = $request->input('statusTwo');
            $paymentMethod = $request->input('payment_method');
            $paymentChannel = $request->input('payment_channel');
            // $preferredCurrency = $request->input('preferredCurrency');
            
            
            // dd(" I ran ");

            $user = $request->user();

            // $booking = $user ? Booking::where('booking_id', $ID)->where('peace_id', $user->peace_id)->first()
            // : Booking::where('booking_id', $ID)->where('last_name', $request->input('last_name'))->first();

            // if (!$booking) {
            //     return response()->json([
            //         "error" => true,
            //         "message" => "you are not authorized to carry out this action"
            //     ], 401);
            // }

            $paymentRef = $request->input('payment_ref');
            $invoiceId = $request->input('invoiceId');

            $invoice = Invoice::find($invoiceId);   
            // dd($invoiceId);     
            
            //validate verifiedRequest;
            if ($paymentChannel == "paystack") {
                $new_top_request = new VerificationService($paymentRef);

            } else if ($paymentChannel == "flutterwave") {
                $new_top_request = new FlutterVerificationService($paymentRef);
            }
            $verified_request = $new_top_request->run();

            // dd($verified_request);

            $paidAmount = $paymentChannel == "paystack" ? $verified_request["data"]["amount"] / 100 : $verified_request["data"]["amount"];
            // dd($paidAmount);
            if (!$paidAmount) {
                return response()->json([
                    "error" => "true",
                    "message" => "payment verification failed"
                ], 400);
            }
            $preferredCurrency = $verified_request['data']['currency'];
           
        
            $invoiceAmount = $invoice->amount + 0;

            // dd($invoiceAmount);

            if ($paidAmount < $invoiceAmount) {
                return response()->json([
                    "error" => true,
                    "message" => "paid amount {$paidAmount} is less than expected amount {$invoiceAmount}"

                ], 400);
            }

            // dd($invoice->amount);
            

            $xml = $this->reissusePNRBuilder->reissuePnrCommit(
                $preferredCurrency,
                $invoiceAmount,
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
            );        
            $user = $request->user();

            // if there is no authenticated user, get the guest device_type
            $deviceType = $user ? $user->device_type : $request->input('device_type');
        
            // dd($xml);
            $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrCommit';

            $response = $this->craneReissuePnrOTAService->run($function, $xml);
            // dd($response);
            $ticketItemList = $response["ReissuePnrCommitResponse"]["airBookingList"]["ticketInfo"]["ticketItemList"];
            // $preferredCurrency = $response['ReissuePnrCommitResponse']['airBookingList']['ticketInfo']['totalAmount']['currency']['code'];


            $id = $response["ReissuePnrCommitResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["ID"];
            $referenceId = $response["ReissuePnrCommitResponse"]["airBookingList"]["airReservation"]["bookingReferenceIDList"]["referenceID"];
            $data = [];
            $data["id"] = $id;
            $data["reference_id"] = $referenceId;

            if(!$this->checkArray->isAssociativeArray($ticketItemList)) {
                foreach($ticketItemList as $ticketItem) {
                    $soap_expected_amount = $ticketItem["paymentDetails"]["paymentDetailList"]["paymentAmount"]["value"];
                    $data["amount"][] = $soap_expected_amount; 

                    $transactionType = $response["ReissuePnrCommitResponse"]["airBookingList"]["ticketInfo"]['pricingType'];
                    $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                    $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
            
                    Transaction::firstOrCreate([
                        "invoice_number" => $invoice_number,                        
                        'amount' => $amount,
                    ], [
                        'transaction_type' => $transactionDescription,
                        'ticket_type' => 'ticket',
                        'user_id' => $user->id,
                        'invoice_id' => $invoice->id,
                        // 'device_type' => $userDevice->device_type,
                        'device_type' => $deviceType,
                        'currency' => $preferredCurrency,
                        "payment_method" => $paymentMethod,
                        "payment_channel" => $paymentChannel,
                        'is_flight' => true
                    ]);
                }
            } else {
                $soap_expected_amount = $ticketItemList["paymentDetails"]["paymentDetailList"]["paymentAmount"]["value"];
                $data["amount"][] = $soap_expected_amount; 

                $transactionType = $response["ReissuePnrCommitResponse"]["airBookingList"]["ticketInfo"]['pricingType'];
                $invoice_number = $ticketItemList['paymentDetails']['paymentDetailList']['invType']['invNumber'];
                $amount = $ticketItemList['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                
                Transaction::firstOrCreate([
                    "invoice_number" => $invoice_number,                        
                    'amount' => $amount,
                ], [
                    'transaction_type' => $transactionDescription,
                    'ticket_type' => 'ticket',
                    'user_id' =>  $user->id,
                    'invoice_id' => $invoice->id,
                    'device_type' => $deviceType,
                    'currency' => $preferredCurrency,
                    "payment_method" => $paymentMethod,
                    "payment_channel" => $paymentChannel,
                    'is_flight' => true
                    
                ]);
            }
            
            // else if ($this->checkArray->isAssociativeArray($ticketItemList)) {
            //     foreach($ticketItemList as $ticketItem) {
            //         $soap_expected_amount = $ticketItem["paymentDetails"]["paymentDetailList"]["paymentAmount"]["value"];
            //         $data["amount"][] = $soap_expected_amount; 

            //         $transactionType = $response["ReissuePnrCommitResponse"]["airBookingList"]["ticketInfo"]['pricingType'];
            //         $invoice_number = $ticketItem['paymentDetails']['paymentDetailList']['invType']['invNumber'];
            //         $amount = $ticketItem['paymentDetails']['paymentDetailList']['paymentAmount']['value']; // amount paid for this transaction
                    
            //         $data = [];
            
            //         Transaction::firstOrCreate([
            //             "invoice_number" => $invoice_number,                        
            //             'amount' => $amount,
            //         ], [
            //             'transaction_type' => $transactionType,
            //             'ticket_type' => 'ticket',
            //             'user_id' =>  $user ? $user->id : null,
            //             'invoice_id' => $invoice->id,
            //             // 'device_type' => $userDevice->device_type,
            //             'device_type' => $deviceType,
            //             'is_flight' => true
                        
            //         ]);
            //     }

            // }
            // $soap_amount = $response["ReissuePnrCommitResponse"]["airBookingList"]["ticketInfo"]["ticketItemList"][0]["pricingOverview"]["totalAmount"]["value"];
            
            return response()->json([
                "error" => false,
                "booking_id" => $id,
                "booking_reference" => $referenceId,
                "data" => $data,
                // "response" => $response
            ], 200);
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function reissuePnrAddFlightPreview(Request $request) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $bookingClassCabinOne = $request->input('bookingClassCabinOne');
        $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne');
        $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne');
        $bookignClassResBookDesigStatusCodeOne = $request->input('bookignClassResBookDesigStatusCodeOne');
        $fareInfoCabinOne = $request->input('fareInfoCabinOne');
        $fareInfocabinClassCodeOne = $request->input('fareInfocabinClassCodeOne');
        $fareInfoCabinAllowanceTypeOne = $request->input('fareInfoCabinAllowanceTypeOne');
        $maxAllowedPiecesOne = $request->input('maxAllowedPiecesOne');
        $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne');
        $weightOne = $request->input('weightOne');
        $fareGroupNameOne = $request->input('fareGroupNameOne');
        $fareReferenceCodeOne = $request->input('fareReferenceCodeOne');
        $fareReferenceIDOne = $request->input('fareReferenceIDOne');
        $fareReferenceNameOne = $request->input('fareReferenceNameOne');
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
        $portTaxOne = $request->input('portTaxOne');
        $resBookDesigCodeOne = $request->input('resBookDesigCodeOne');
        $airlineCodeOne = $request->input('airlineCodeOne');
        $airlinecompanyFullNameOne = $request->input('airlinecompanyFullNameOne');
        $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne');
        $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne');
        $arrivalAirportLocationNameLanguageOne = $request->input('arrivalAirportLocationNameLanguageOne');
        $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
        $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne');
        $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne');
        $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne');
        $arrivalAirportCodeContextOne = $request->input('arrivalAirportCodeContextOne');
        $arrivalAirportLanguageOne = $request->input('arrivalAirportLanguageOne');
        $arrivalAirportLocationCodeOne = $request->input('arrivalAirportLocationCodeOne');
        $arrivalAirportLocationNameOne = $request->input('arrivalAirportLocationNameOne');
        $arrivalAirportTimeZoneInfoOne = $request->input('arrivalAirportTimeZoneInfoOne');
        $arrivalDateTimeOne = $request->input('arrivalDateTimeOne');
        $arrivalDateTimeUTCOne = $request->input('arrivalDateTimeUTCOne');
        $departureAirportCityLocationCodeOne = $request->input('departureAirportCityLocationCodeOne');
        $departureAirportCityLocationNameOne = $request->input('departureAirportCityLocationNameOne');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCodeOne = $request->input('departureAirportCountryLocationCodeOne');
        $departureAirportCountryLocationNameOne = $request->input('departureAirportCountryLocationNameOne');
        $departureAirportCountryLocationNameLanguageOne = $request->input('departureAirportCountryLocationNameLanguageOne');
        $departureAirportCountryCodeOne = $request->input('departureAirportCountryCodeOne');
        $departureAirportCodeContextOne = $request->input('departureAirportCodeContextOne');
        $departureAirportLanguageOne = $request->input('departureAirportLanguageOne');
        $departureAirportLocationCodeOne = $request->input('departureAirportLocationCodeOne');
        $departureAirportLocationNameOne = $request->input('departureAirportLocationNameOne');
        $departureTimeZoneInfoOne = $request->input('departureTimeZoneInfoOne');
        $departureDateTimeOne = $request->input('departureDateTimeOne');
        $departureDateTimeUTCOne = $request->input('departureDateTimeUTCOne');
        $flightNumberOne = $request->input('flightNumberOne');
        $flightSegmentIDOne = $request->input('flightSegmentIDOne');
        $ondControlledOne = $request->input('ondControlledOne');
        $sectorOne = $request->input('sectorOne');
        $codeShareOne = $request->input('codeShareOne');
        $distanceOne = $request->input('distanceOne');
        $equipmentAirEquipTypeOne = $request->input('equipmentAirEquipTypeOne');
        $equipmentChangeOfGaugeOne = $request->input('equipmentChangeOfGaugeOne');
        $flightNotesOne = $request->input('flightNotesOne');
        $flownMileageQtyOne = $request->input('flownMileageQtyOne');
        $iatciFlightOne = $request->input('iatciFlightOne');
        $journeyDurationOne = $request->input('journeyDurationOne');
        $onTimeRateOne = $request->input('onTimeRateOne');
        $remarkOne = $request->input('remarkOne');
        $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne');
        $stopQuantityOne = $request->input('stopQuantityOne');
        $ticketTypeOne = $request->input('ticketTypeOne');


        $xml = $this->reissusePNRBuilder->reissuePnrAddFlightPreview(
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
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrPreview';

        $response = $this->craneReissuePnrOTAService->run($function, $xml);
        dd($response);
    }

    public function reissuePnrAddFlightCommit(Request $request) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $bookingClassCabinOne = $request->input('bookingClassCabinOne');
        $bookingClassResBookDesigCodeOne = $request->input('bookingClassResBookDesigCodeOne');
        $bookingClassResBookDesigQuantityOne = $request->input('bookingClassResBookDesigQuantityOne');
        $bookignClassResBookDesigStatusCodeOne = $request->input('bookignClassResBookDesigStatusCodeOne');
        $fareInfoCabinOne = $request->input('fareInfoCabinOne');
        $fareInfocabinClassCodeOne = $request->input('fareInfocabinClassCodeOne');
        $fareInfoCabinAllowanceTypeOne = $request->input('fareInfoCabinAllowanceTypeOne');
        $maxAllowedPiecesOne = $request->input('maxAllowedPiecesOne');
        $unitOfMeasureCodeOne = $request->input('unitOfMeasureCodeOne');
        $weightOne = $request->input('weightOne');
        $fareGroupNameOne = $request->input('fareGroupNameOne');
        $fareReferenceCodeOne = $request->input('fareReferenceCodeOne');
        $fareReferenceIDOne = $request->input('fareReferenceIDOne');
        $fareReferenceNameOne = $request->input('fareReferenceNameOne');
        $flightSegmentSequenceOne = $request->input('flightSegmentSequenceOne');
        $portTaxOne = $request->input('portTaxOne');
        $resBookDesigCodeOne = $request->input('resBookDesigCodeOne');
        $airlineCodeOne = $request->input('airlineCodeOne');
        $airlinecompanyFullNameOne = $request->input('airlinecompanyFullNameOne');
        $arrivalAirportCityLocationCodeOne = $request->input('arrivalAirportCityLocationCodeOne');
        $arrivalAirportCityLocationNameOne = $request->input('arrivalAirportCityLocationNameOne');
        $arrivalAirportLocationNameLanguageOne = $request->input('arrivalAirportLocationNameLanguageOne');
        $arrivalAirportCountryLocationCodeOne = $request->input('arrivalAirportCountryLocationCodeOne');
        $arrivalAirportCountryLocationNameOne = $request->input('arrivalAirportCountryLocationNameOne');
        $arrivalAirportCountryLocationNameLanguageOne = $request->input('arrivalAirportCountryLocationNameLanguageOne');
        $arrivalAirportCountryCurrencyCodeOne = $request->input('arrivalAirportCountryCurrencyCodeOne');
        $arrivalAirportCodeContextOne = $request->input('arrivalAirportCodeContextOne');
        $arrivalAirportLanguageOne = $request->input('arrivalAirportLanguageOne');
        $arrivalAirportLocationCodeOne = $request->input('arrivalAirportLocationCodeOne');
        $arrivalAirportLocationNameOne = $request->input('arrivalAirportLocationNameOne');
        $arrivalAirportTimeZoneInfoOne = $request->input('arrivalAirportTimeZoneInfoOne');
        $arrivalDateTimeOne = $request->input('arrivalDateTimeOne');
        $arrivalDateTimeUTCOne = $request->input('arrivalDateTimeUTCOne');
        $departureAirportCityLocationCodeOne = $request->input('departureAirportCityLocationCodeOne');
        $departureAirportCityLocationNameOne = $request->input('departureAirportCityLocationNameOne');
        $departureAirportCityLocationNameLanguage = $request->input('departureAirportCityLocationNameLanguage');
        $departureAirportCountryLocationCodeOne = $request->input('departureAirportCountryLocationCodeOne');
        $departureAirportCountryLocationNameOne = $request->input('departureAirportCountryLocationNameOne');
        $departureAirportCountryLocationNameLanguageOne = $request->input('departureAirportCountryLocationNameLanguageOne');
        $departureAirportCountryCodeOne = $request->input('departureAirportCountryCodeOne');
        $departureAirportCodeContextOne = $request->input('departureAirportCodeContextOne');
        $departureAirportLanguageOne = $request->input('departureAirportLanguageOne');
        $departureAirportLocationCodeOne = $request->input('departureAirportLocationCodeOne');
        $departureAirportLocationNameOne = $request->input('departureAirportLocationNameOne');
        $departureTimeZoneInfoOne = $request->input('departureTimeZoneInfoOne');
        $departureDateTimeOne = $request->input('departureDateTimeOne');
        $departureDateTimeUTCOne = $request->input('departureDateTimeUTCOne');
        $flightNumberOne = $request->input('flightNumberOne');
        $flightSegmentIDOne = $request->input('flightSegmentIDOne');
        $ondControlledOne = $request->input('ondControlledOne');
        $sectorOne = $request->input('sectorOne');
        $codeShareOne = $request->input('codeShareOne');
        $distanceOne = $request->input('distanceOne');
        $equipmentAirEquipTypeOne = $request->input('equipmentAirEquipTypeOne');
        $equipmentChangeOfGaugeOne = $request->input('equipmentChangeOfGaugeOne');
        $flightNotesOne = $request->input('flightNotesOne');
        $flownMileageQtyOne = $request->input('flownMileageQtyOne');
        $iatciFlightOne = $request->input('iatciFlightOne');
        $journeyDurationOne = $request->input('journeyDurationOne');
        $onTimeRateOne = $request->input('onTimeRateOne');
        $remarkOne = $request->input('remarkOne');
        $secureFlightDataRequiredOne = $request->input('secureFlightDataRequiredOne');
        $stopQuantityOne = $request->input('stopQuantityOne');
        $ticketTypeOne = $request->input('ticketTypeOne');


        $xml = $this->reissusePNRBuilder->reissuePnrAddFlightCommit(
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
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrPreview';

        $response = $this->craneReissuePnrOTAService->run($function, $xml);
        dd($response);
    }

    public function reissuePnrCancelFlightPreview(Request $request ) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $actionCodeTwo = $request->input('actionCodeTwo');
        $addOnSegmentTwo = $request->input('addOnSegmentTwo');
        $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
        $bookingCabinResBookDesigCodeTwo = $request->input('bookingCabinResBookDesigCodeTwo');
        $bookingCabinResBookDesigQuantityTwo = $request->input('bookingCabinResBookDesigQuantityTwo');
        $fareInfoCabinTwo = $request->input('fareInfoCabinTwo');
        $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo');
        $allowanceTypeTwo = $request->input('allowanceTypeTwo');
        $maxAllowedPiecesTwo = $request->input('maxAllowedPiecesTwo');
        $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo');
        $weightTwo = $request->input('weightTwo');
        $fareGroupNameTwo = $request->input('fareGroupNameTwo');
        $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo');
        $fareReferenceIDTwo = $request->input('fareReferenceIDTwo');
        $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $resBookDesigCodeTwo = $request->input('resBookDesigCodeTwo');
        $airlineCodeTwo = $request->input('airlineCodeTwo');
        $airlineCodeContextTwo = $request->input('airlineCodeContextTwo');
        $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
        $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo');
        $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo');
        $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
        $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo');
        $arrivalAirportLocationNameLanguageTwo = $request->input('arrivalAirportLocationNameLanguageTwo');
        $arrivalAirportCountryCodeTwo = $request->input('arrivalAirportCountryCodeTwo');
        $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo');
        $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
        $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo');
        $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo');
        $arrivalAirportTerminalTwo = $request->input('arrivalAirportTerminalTwo');
        $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
        $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo');
        $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
        $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo');
        $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo');
        $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo');
        $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo');
        $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
        $departureAirportLocationNameLanguageTwo = $request->input('departureAirportLocationNameLanguageTwo');
        $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo');
        $departureAirportCodeContextTwo = $request->input('departureAirportCodeContextTwo');
        $departureAirportLanguageTwo = $request->input('departureAirportLanguageTwo');
        $departureAirportLocationCodeTwo = $request->input('departureAirportLocationCodeTwo');
        $departureAirportLocationNameTwo = $request->input('departureAirportLocationNameTwo');
        $departureAirportTimeZoneInfoTwo = $request->input('departureAirportTimeZoneInfoTwo');
        $departureDateTimeTwo = $request->input('departureDateTimeTwo');
        $departureDateTimeUTCTwo = $request->input('departureDateTimeUTCTwo');
        $flightNumberTwo = $request->input('flightNumberTwo');
        $flightSegmentIDTwo = $request->input('flightSegmentIDTwo');
        $ondControlledTwo = $request->input('ondControlledTwo');
        $sectorTwo = $request->input('sectorTwo');
        $codeShareTwo = $request->input('codeShareTwo');
        $distanceTwo = $request->input('distanceTwo');
        $equipmentAirEquipTypeTwo = $request->input('equipmentAirEquipTypeTwo');
        $equipmentChangeOfGaugeTwo = $request->input('equipmentChangeOfGaugeTwo');
        $flightNotesTwo = $request->input('flightNotesTwo');
        $flownMileageQtyTwo = $request->input('flownMileageQtyTwo');
        $iatciFlightTwo = $request->input('iatciFlightTwo');
        $journeyDurationTwo = $request->input('journeyDurationTwo');
        $onTimeRateTwo = $request->input('onTimeRateTwo');
        $remarkTwo = $request->input('remarkTwo');
        $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo');
        $segmentStatusByFirstLegTwo = $request->input('segmentStatusByFirstLegTwo');
        $stopQuantityTwo = $request->input('stopQuantityTwo');
        $involuntaryPermissionGivenTwo = $request->input('involuntaryPermissionGivenTwo');
        $legStatusTwo = $request->input('legStatusTwo');
        $referenceIDTwo = $request->input('referenceIDTwo');
        $responseCodeTwo = $request->input('responseCodeTwo');
        $sequenceNumberTwo = $request->input('sequenceNumberTwo');
        $statusTwo = $request->input('statusTwo');

        $xml = $this->reissusePNRBuilder->reissuePnrCancelFlightPreview(
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
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrPreview';

        $response = $this->craneReissuePnrOTAService->run($function, $xml);
        dd($response);


        
    }


    public function reissuePnrCancelFlightCommit(Request $request ) {
        $ID = $request->input('ID');
        $referenceID = $request->input('referenceID');
        $actionCodeTwo = $request->input('actionCodeTwo');
        $addOnSegmentTwo = $request->input('addOnSegmentTwo');
        $bookingClassCabinTwo = $request->input('bookingClassCabinTwo');
        $bookingCabinResBookDesigCodeTwo = $request->input('bookingCabinResBookDesigCodeTwo');
        $bookingCabinResBookDesigQuantityTwo = $request->input('bookingCabinResBookDesigQuantityTwo');
        $fareInfoCabinTwo = $request->input('fareInfoCabinTwo');
        $fareInfoCabinClassCodeTwo = $request->input('fareInfoCabinClassCodeTwo');
        $allowanceTypeTwo = $request->input('allowanceTypeTwo');
        $maxAllowedPiecesTwo = $request->input('maxAllowedPiecesTwo');
        $unitOfMeasureCodeTwo = $request->input('unitOfMeasureCodeTwo');
        $weightTwo = $request->input('weightTwo');
        $fareGroupNameTwo = $request->input('fareGroupNameTwo');
        $fareReferenceCodeTwo = $request->input('fareReferenceCodeTwo');
        $fareReferenceIDTwo = $request->input('fareReferenceIDTwo');
        $fareReferenceNameTwo = $request->input('fareReferenceNameTwo');
        $flightSegmentSequenceTwo = $request->input('flightSegmentSequenceTwo');
        $resBookDesigCodeTwo = $request->input('resBookDesigCodeTwo');
        $airlineCodeTwo = $request->input('airlineCodeTwo');
        $airlineCodeContextTwo = $request->input('airlineCodeContextTwo');
        $arrivalAirportCityLocationCodeTwo = $request->input('arrivalAirportCityLocationCodeTwo');
        $arrivalAirportCityLocationNameTwo = $request->input('arrivalAirportCityLocationNameTwo');
        $arrivalAirportCityLocationNameLanguageTwo = $request->input('arrivalAirportCityLocationNameLanguageTwo');
        $arrivalAirportCountryLocationCodeTwo = $request->input('arrivalAirportCountryLocationCodeTwo');
        $arrivalAirportCountryLocationNameTwo = $request->input('arrivalAirportCountryLocationNameTwo');
        $arrivalAirportLocationNameLanguageTwo = $request->input('arrivalAirportLocationNameLanguageTwo');
        $arrivalAirportCountryCodeTwo = $request->input('arrivalAirportCountryCodeTwo');
        $arrivalAirportCodeContextTwo = $request->input('arrivalAirportCodeContextTwo');
        $arrivalAirportLanguageTwo = $request->input('arrivalAirportLanguageTwo');
        $arrivalAirportLocationCodeTwo = $request->input('arrivalAirportLocationCodeTwo');
        $arrivalAirportLocationNameTwo = $request->input('arrivalAirportLocationNameTwo');
        $arrivalAirportTerminalTwo = $request->input('arrivalAirportTerminalTwo');
        $arrivalAirportTimeZoneInfoTwo = $request->input('arrivalAirportTimeZoneInfoTwo');
        $arrivalDateTimeTwo = $request->input('arrivalDateTimeTwo');
        $arrivalDateTimeUTCTwo = $request->input('arrivalDateTimeUTCTwo');
        $departureAirportCityLocationCodeTwo = $request->input('departureAirportCityLocationCodeTwo');
        $departureAirportCityLocationNameTwo = $request->input('departureAirportCityLocationNameTwo');
        $departureAirportCityLocationNameLanguageTwo = $request->input('departureAirportCityLocationNameLanguageTwo');
        $departureAirportCountryLocationCodeTwo = $request->input('departureAirportCountryLocationCodeTwo');
        $departureAirportCountryLocationNameTwo = $request->input('departureAirportCountryLocationNameTwo');
        $departureAirportLocationNameLanguageTwo = $request->input('departureAirportLocationNameLanguageTwo');
        $departureAirportCountryCurrencyCodeTwo = $request->input('departureAirportCountryCurrencyCodeTwo');
        $departureAirportCodeContextTwo = $request->input('departureAirportCodeContextTwo');
        $departureAirportLanguageTwo = $request->input('departureAirportLanguageTwo');
        $departureAirportLocationCodeTwo = $request->input('departureAirportLocationCodeTwo');
        $departureAirportLocationNameTwo = $request->input('departureAirportLocationNameTwo');
        $departureAirportTimeZoneInfoTwo = $request->input('departureAirportTimeZoneInfoTwo');
        $departureDateTimeTwo = $request->input('departureDateTimeTwo');
        $departureDateTimeUTCTwo = $request->input('departureDateTimeUTCTwo');
        $flightNumberTwo = $request->input('flightNumberTwo');
        $flightSegmentIDTwo = $request->input('flightSegmentIDTwo');
        $ondControlledTwo = $request->input('ondControlledTwo');
        $sectorTwo = $request->input('sectorTwo');
        $codeShareTwo = $request->input('codeShareTwo');
        $distanceTwo = $request->input('distanceTwo');
        $equipmentAirEquipTypeTwo = $request->input('equipmentAirEquipTypeTwo');
        $equipmentChangeOfGaugeTwo = $request->input('equipmentChangeOfGaugeTwo');
        $flightNotesTwo = $request->input('flightNotesTwo');
        $flownMileageQtyTwo = $request->input('flownMileageQtyTwo');
        $iatciFlightTwo = $request->input('iatciFlightTwo');
        $journeyDurationTwo = $request->input('journeyDurationTwo');
        $onTimeRateTwo = $request->input('onTimeRateTwo');
        $remarkTwo = $request->input('remarkTwo');
        $secureFlightDataRequiredTwo = $request->input('secureFlightDataRequiredTwo');
        $segmentStatusByFirstLegTwo = $request->input('segmentStatusByFirstLegTwo');
        $stopQuantityTwo = $request->input('stopQuantityTwo');
        $involuntaryPermissionGivenTwo = $request->input('involuntaryPermissionGivenTwo');
        $legStatusTwo = $request->input('legStatusTwo');
        $referenceIDTwo = $request->input('referenceIDTwo');
        $responseCodeTwo = $request->input('responseCodeTwo');
        $sequenceNumberTwo = $request->input('sequenceNumberTwo');
        $statusTwo = $request->input('statusTwo');

        $xml = $this->reissusePNRBuilder->reissuePnrCancelFlightPreview(
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
        );

        $function = 'http://impl.soap.ws.crane.hititcs.com/ReissuePnrCommit';

        $response = $this->craneReissuePnrOTAService->run($function, $xml);
        dd($response);


        
    }
}
