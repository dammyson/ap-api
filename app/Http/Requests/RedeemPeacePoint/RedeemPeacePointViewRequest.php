<?php

namespace App\Http\Requests\RedeemPeacePoint;

use Illuminate\Foundation\Http\FormRequest;

class RedeemPeacePointViewRequest extends FormRequest
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
            "routes" => "required|array|min:1",
            "routes.*.route" => "required|string",
            "routes.*.class" => "required|string",
            "routes.*.type" => "required|string",            
            "preferred_currency" => "required|string",
            "passenger_length" => "required|integer|min:1",
            "booking_id" => "required|string",
            "booking_reference_id" => "required|string"
        ];
    }
}
