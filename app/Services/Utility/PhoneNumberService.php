<?php

namespace App\Services\Utility;

use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNumberService
{
    public function normalize(string $phone): string
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        $phoneNumber = $phoneUtil->parse($phone, null);

        if (!$phoneUtil->isValidNumber($phoneNumber)) {
            throw new \InvalidArgumentException('Invalid phone number.');
        }

        return $phoneUtil->format(
            $phoneNumber,
            PhoneNumberFormat::E164
        );
    }
}