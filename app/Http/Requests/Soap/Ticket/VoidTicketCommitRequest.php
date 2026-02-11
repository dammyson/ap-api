<?php

namespace App\Http\Requests\Soap\Ticket;

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
            "booking_id" => "required|string", 
            "booking_reference_id" => "required|string", 
            "parent_booking_id" => "required|string",
            "parent_booking_reference_id" => "required|string",
        ];


      
    }
}
