<?php

namespace App\Http\Requests\Soap\DividePNR;

use Illuminate\Foundation\Http\FormRequest;

class DividePNRRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "companyNameCitycode" => "required|string", 
            "companyNameCode" => "required|string", 
            "companyNameCodeContext" => "required|string", 
            "companyFullName" => "required|string", 
            "companyShortName" => "required|string", 
            "companyCountryCode" => "required|string", 
            "ID" => "required|string", 
            "referenceID" => "required|string", 
            "accompaniedByInfant" => "required|string", 
            "dividedTravelerBirthDate" => "required|string", 
            "contactPersonEmail" => "required|string", 
            "contactPersonMarkedForSendingRezInfo" => "required|string", 
            "contactPersonPreferred" => "required|string",
            "shareMarketInd" => "required|string", 
            "personNameGivenName" => "required|string", 
            "personNameShareMarketInd" => "required|string", 
            "personNameSurName" => "required|string", 
            "phoneNumberAreaCode" => "required|string", 
            "phoneNumberCountryCode" => "required|string",
            "phoneNumberMarkedForSendingRezInfo" => "required|string", 
            "phoneNumberPreferred" => "required|string", 
            "phoneNumberShareMarketInd" => "required|string", 
            "phoneNumberSubscriberNumber" => "required|string", 
            "contactPersonShareContactInfo" => "required|string",
            "contactPersonShareMarketInd" => "required|string", 
            "useForInvoicing" => "required|string", 
            "documentInfoListBirthDate" => "required|string", 
            "documentHolderFormattedNameGivenName" => "required|string",
            "documentInfoListShareMarketInd" => "required|string",
            "documentInfoListSurname" => "required|string", 
            "documentInfoListGender" => "required|string", 
            "contactNameShareMarketInd" => "required|string", 
            "emergencyContactInfoDecline" => "required|string", 
            "emergencyContactInfoMarkedForSendingRezInfo" => "required|string",
            "emergencyContactInfoPreferred" => "required|string", 
            "emergencyContactInfoShareMarketInd" => "required|string", 
            "emergencyContactShareContactInfo" => "required|string", 
            "emergencyContactInfoGender" => "required|string", 
            "emergencyContactInfoHasStrecher" => "required|string",
            "emergencyContactInfoParentSequence" => "required|string", 
            "emergencyContactInfoPassengerTypeCode" => "required|string", 
            "emergencyContactInfoPersonNameGivenName" => "required|string",
            "emergencyContactInfoPersonNameTitle" => "required|string",
            "emergencyContactInfoPersonNameShareMarketInd" => "required|string", 
            "emergencyContactInfoPersonNameSurname" => "required|string", 
            "personNameENGivenName" => "required|string",
            "personNameENNameTitle" => "required|string", 
            "personNameENShareMarketInd" => "required|string", 
            "personNameENSurname" => "required|string", 
            "requestedSeatCount" => "required|string", 
            "divideTravelerShareMarketInd" => "required|string",
            "travelerReferenceID" => "required|string", 
            "unaccompaniedMinor" => "required|string"
        ];
    }
}
