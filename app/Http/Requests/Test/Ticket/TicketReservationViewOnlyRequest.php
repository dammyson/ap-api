<?php

namespace App\Http\Requests\Test\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketReservationViewOnlyRequest extends FormRequest
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
            "companyNameCityCode" => "required|string",
            "companyNameCode" => "required|string",
            "companyNameCodeContext" => "required|string",
            "companyFullName" => "required|string",
            "companyShortName" => "required|string",
            "companyNameCountryCode" => "required|string",
            "ID" => "required|string",
            "referenceID" => "required|string",
            "requestPurpose" => "required|string"
        ];
    }
}
