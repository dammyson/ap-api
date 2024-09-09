<?php


namespace App\Services\AutoGenerate;


class GeneratePassword {
    public function generateTemporaryPassword() {
        $values = 'ABCDEFGHIJKLMNOPQGRSTUVWXYZ!@#$%&_abcdefghijklmnopqrstuvwxyz1234567890';

        $tempPassword = '';

        for ($i = 0; $i < 11; $i++) {
            $tempPassword .= $values[random_int(0, 62)];
        }

        return $tempPassword;
    }

} 