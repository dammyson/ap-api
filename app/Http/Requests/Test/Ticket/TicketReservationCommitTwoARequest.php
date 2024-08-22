<?php

namespace App\Http\Requests\Test\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketReservationCommitTwoARequest extends FormRequest
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
            "companyNameCodeContext"  => "required|string",
            "companyFullName" => "required|string",
            "companyShortName" => "required|string",
            "countryCode" => "required|string",
            "ID" => "required|string",
            "referenceID" => "required|string",
            "capturePaymentToolNumber" => "required|boolean",
            "paymentCode" => "required|string",
            "threeDomainSecurityEligible" => "required|boolean",
            "MCONumber" => "required|string",
            "paymentAmountCurrencyCode" => "required|string",
            "paymentAmountValue" => "required|string",
            "paymentType" => "required|string",
            "primaryPayment" => "required|boolean",
            "requestPurpose" => "required|string"
        ];
    }
}
