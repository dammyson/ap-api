<?php

namespace App\Http\Controllers\Test;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Soap\DividePNRBuilder;
use App\Http\Requests\Test\DividePNR\DividePNRRequest;

class DividePNRController extends Controller
{
    //
    protected $dividePNRBuilder;

    public function __construct(DividePNRBuilder $dividePNRBuilder)
    {
        $this->dividePNRBuilder = $dividePNRBuilder;
    }

    public function dividePNR(DividePNRRequest $request) {
        $companyNameCitycode = $request->input('companyNameCitycode'); 
        $companyNameCode = $request->input('companyNameCode'); 
        $companyNameCodeContext = $request->input('companyNameCodeContext'); 
        $companyFullName = $request->input('companyFullName'); 
        $companyShortName = $request->input('companyShortName'); 
        $companyCountryCode = $request->input('companyCountryCode'); 
        $ID = $request->input('ID'); 
        $referenceID = $request->input('referenceID'); 
        $accompaniedByInfant = $request->input('accompaniedByInfant'); 
        $dividedTravelerBirthDate = $request->input('dividedTravelerBirthDate'); 
        $contactPersonEmail = $request->input('contactPersonEmail'); 
        $contactPersonMarkedForSendingRezInfo = $request->input('contactPersonMarkedForSendingRezInfo'); 
        $contactPersonPreferred = $request->input('contactPersonPreferred');
        $shareMarketInd = $request->input('shareMarketInd'); 
        $personNameGivenName = $request->input('personNameGivenName'); 
        $personNameShareMarketInd = $request->input('personNameShareMarketInd'); 
        $personNameSurName = $request->input('personNameSurName'); 
        $phoneNumberAreaCode = $request->input('phoneNumberAreaCode'); 
        $phoneNumberCountryCode = $request->input('phoneNumberCountryCode');
        $phoneNumberMarkedForSendingRezInfo = $request->input('phoneNumberMarkedForSendingRezInfo'); 
        $phoneNumberPreferred = $request->input('phoneNumberPreferred'); 
        $phoneNumberShareMarketInd = $request->input('phoneNumberShareMarketInd'); 
        $phoneNumberSubscriberNumber = $request->input('phoneNumberSubscriberNumber'); 
        $contactPersonShareContactInfo = $request->input('contactPersonShareContactInfo');
        $contactPersonShareMarketInd = $request->input('contactPersonShareMarketInd'); 
        $useForInvoicing = $request->input('useForInvoicing'); 
        $documentInfoListBirthDate = $request->input('documentInfoListBirthDate'); 
        $documentHolderFormattedNameGivenName = $request->input('documentHolderFormattedNameGivenName');
        $documentInfoListShareMarketInd = $request->input('documentInfoListShareMarketInd');
        $documentInfoListSurname = $request->input('documentInfoListSurname'); 
        $documentInfoListGender = $request->input('documentInfoListGender'); 
        $contactNameShareMarketInd = $request->input('contactNameShareMarketInd'); 
        $emergencyContactInfoDecline = $request->input('emergencyContactInfoDecline'); 
        $emergencyContactInfoMarkedForSendingRezInfo = $request->input('emergencyContactInfoMarkedForSendingRezInfo');
        $emergencyContactInfoPreferred = $request->input('emergencyContactInfoPreferred'); 
        $emergencyContactInfoShareMarketInd = $request->input('emergencyContactInfoShareMarketInd'); 
        $emergencyContactShareContactInfo = $request->input('emergencyContactShareContactInfo'); 
        $emergencyContactInfoGender = $request->input('emergencyContactInfoGender'); 
        $emergencyContactInfoHasStrecher = $request->input('emergencyContactInfoHasStrecher');
        $emergencyContactInfoParentSequence = $request->input('emergencyContactInfoParentSequence'); 
        $emergencyContactInfoPassengerTypeCode = $request->input('emergencyContactInfoPassengerTypeCode'); 
        $emergencyContactInfoPersonNameGivenName = $request->input('emergencyContactInfoPersonNameGivenName');
        $emergencyContactInfoPersonNameTitle = $request->input('emergencyContactInfoPersonNameTitle');
        $emergencyContactInfoPersonNameShareMarketInd = $request->input('emergencyContactInfoPersonNameShareMarketInd'); 
        $emergencyContactInfoPersonNameSurname = $request->input('emergencyContactInfoPersonNameSurname'); 
        $personNameENGivenName = $request->input('personNameENGivenName');
        $personNameENNameTitle = $request->input('personNameENNameTitle'); 
        $personNameENShareMarketInd = $request->input('personNameENShareMarketInd'); 
        $personNameENSurname = $request->input('personNameENSurname'); 
        $requestedSeatCount = $request->input('requestedSeatCount'); 
        $divideTravelerShareMarketInd = $request->input('divideTravelerShareMarketInd'); 
        $travelerReferenceID = $request->input('travelerReferenceID'); 
        $unaccompaniedMinor = $request->input('unaccompaniedMinor');


        $xml = $this->dividePNRBuilder->dividePNR(
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
        );

        try {
            dd($xml);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
}
