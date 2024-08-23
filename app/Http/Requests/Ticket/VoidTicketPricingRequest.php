<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class VoidTicketPricingRequest extends FormRequest
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
            'bookingReferenceCompanyCityCode' => 'required|string', 
            'bookingReferenceCompanyCode' => 'required|string', 
            'bookingReferenceCompanyCodeContext' => 'required|string', 
            'bookingReferenceCompanyFullName' => 'required|string', 
            'bookingReferenceCompanyShortName' => 'required|string', 
            'bookingReferenceCompanyCountryCode' => 'required|string', 
            'ID' => 'required|string', 
            'referenceID' => 'required|integer', 
            'parentBookingCompanyCityCode' => 'required|string', 
            'parentBookingCompanyCode' => 'required|string', 
            'parentBookingCodeContext' => 'required|string', 
            'parentBookingCompanyFullName' => 'required|string', 
            'parentBookingCompanyShortName' => 'required|string', 
            'parentBookingCountryCode' => 'required|string', 
            'parentBookingID' => 'required|string', 
            'parentBookingReferenceID' => 'required|string', 
            'operationType' => 'required|string'
        ];
    }
}
