<?php

namespace App\Http\Requests\Reward;

use Illuminate\Foundation\Http\FormRequest;

class StoreRedeemedRewardRequest extends FormRequest
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
            'reward_id' => 'required|exists:rewards,id',
            'user_id' => 'required|exists:users,id',
            'redeemed_at' => 'required|date',
        ];
    }
}
