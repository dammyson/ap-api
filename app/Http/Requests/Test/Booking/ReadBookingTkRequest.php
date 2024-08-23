<?php

namespace App\Http\Requests\Test\Booking;

use Illuminate\Foundation\Http\FormRequest;

class ReadBookingTkRequest extends FormRequest
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
            "companyCityCode" => "required|string", 
            "companyCode" => "required|string", 
            "companyNameCodeContext" => "required|string",
            "companyFullName" => "required|string", 
            "companyShortName" => "required|string", 
            "countryCode" => "required|string", 
            "ID" => "required|string", 
            "referenceID" => "required|string"
        ];
    }
}