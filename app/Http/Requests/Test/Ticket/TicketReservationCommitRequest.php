<?php

namespace App\Http\Requests\Test\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketReservationCommitRequest extends FormRequest
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
            "ID" => 'required|string',
            "referenceID" => 'required|string',
            "capturePaymentToolNumber" => 'sometimes|boolean',
            "paymentCode" => 'sometimes|string',
            "threeDomainSecurityEligible" => 'sometimes|boolean',
            "MCONumber" => 'sometimes|string',
            "code" => 'sometimes|string',
            "value" => 'sometimes|string',
            "paymentType" => 'sometimes|string',
            "primaryPayment" => 'sometimes|boolean',
            "requestPurpose" => 'required|string'
        ];
    }
}
