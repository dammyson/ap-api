<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class VoidTicketCommitRequest extends FormRequest
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
            "companyNameCityCodeOne" => "required|string", 
            "companyNameCodeOne" => "required|string", 
            "codeContextOne" => "required|string", 
            "companyFullNameOne" => "required|string", 
            "companyShortNameOne" => "required|string", 
            "companyCountryCodeOne" => "required|string", 
            "IDOne" => "required|string", 
            "referenceIDOne" => "required|string", 
            "companyNameCityCodeTwo" => "required|string",
            "companyCodeTwo" => "required|string",
            "companyCodeContextTwo" => "required|string",
            "companyFullNameTwo" => "required|string",
            "companyShortNameTwo" => "required|string",
            "companyCountryCodeTwo" => "required|string",
            "IDTwo" => "required|string",
            "referenceIDTwo" => "required|string",
            "operationType" => "required|string"
        ];


      
    }
}
