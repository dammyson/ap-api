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
            "ID" => "required|string",
            "referenceID" => "required|string",
            "preferred_currency" => "required|string"
        ];
    }
}
