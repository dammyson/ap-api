<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class ValidPhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
   

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            // Since we're accepting international numbers,
            // the user should provide the country code.
            $phoneNumber = $phoneUtil->parse($value, null);

            if (!$phoneUtil->isValidNumber($phoneNumber)) {
                $fail('Please provide a valid phone number.');
            }
        } catch (NumberParseException) {
            $fail('Please provide a valid phone number.');
        }
    }
}
