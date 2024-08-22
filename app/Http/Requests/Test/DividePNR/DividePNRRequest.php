<?php

namespace App\Http\Requests\Test\DividePNR;

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
            "accompaniedByInfant" => "required|boolean", 
            "dividedTravelerBirthDate" => "required|string", 
            "contactPersonEmail" => "required|string", 
            "contactPersonMarkedForSendingRezInfo" => "required|boolean", 
            "contactPersonPreferred" => "required|boolean",
            "shareMarketInd" => "required|string", 
            "personNameGivenName" => "required|string", 
            "personNameShareMarketInd" => "required|boolean", 
            "personNameSurName" => "required|string", 
            "phoneNumberAreaCode" => "required|string", 
            "phoneNumberCountryCode" => "required|string",
            "phoneNumberMarkedForSendingRezInfo" => "required|boolean", 
            "phoneNumberPreferred" => "required|boolean", 
            "phoneNumberShareMarketInd" => "required|boolean", 
            "phoneNumberSubscriberNumber" => "required|string", 
            "contactPersonShareContactInfo" => "required|boolean",
            "contactPersonShareMarketInd" => "required|boolean", 
            "useForInvoicing" => "required|boolean", 
            "documentInfoListBirthDate" => "required|string", 
            "documentHolderFormattedNameGivenName" => "required|string",
            "documentInfoListShareMarketInd" => "required|boolean",
            "documentInfoListSurname" => "required|string", 
            "documentInfoListGender" => "required|string", 
            "contactNameShareMarketInd" => "required|boolean", 
            "emergencyContactInfoDecline" => "required|boolean", 
            "emergencyContactInfoMarkedForSendingRezInfo" => "required|boolean",
            "emergencyContactInfoPreferred" => "required|boolean", 
            "emergencyContactInfoShareMarketInd" => "required|boolean", 
            "emergencyContactShareContactInfo" => "required|boolean", 
            "emergencyContactInfoGender" => "required|string", 
            "emergencyContactInfoHasStrecher" => "required|boolean",
            "emergencyContactInfoParentSequence" => "required|string", 
            "emergencyContactInfoPassengerTypeCode" => "required|string", 
            "emergencyContactInfoPersonNameGivenName" => "required|string",
            "emergencyContactInfoPersonNameTitle" => "required|string",
            "emergencyContactInfoPersonNameShareMarketInd" => "required|boolean", 
            "emergencyContactInfoPersonNameSurname" => "required|string", 
            "personNameENGivenName" => "required|string",
            "personNameENNameTitle" => "required|string", 
            "personNameENShareMarketInd" => "required|boolean", 
            "personNameENSurname" => "required|string", 
            "requestedSeatCount" => "required|string", 
            "divideTravelerShareMarketInd" => "required|boolean",
            "travelerReferenceID" => "required|string", 
            "unaccompaniedMinor" => "required|boolean"
        ];
    }
}
