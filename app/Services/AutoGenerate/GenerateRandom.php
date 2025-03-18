<?php


namespace App\Services\AutoGenerate;


class GenerateRandom {
    public function generateTemporaryPassword() {
       
        $tempPassword = '';

        $capitalLetters = 'ABCDEFGHIJKLMNOPQGRSTUVWXYZ';
        $specialChars = '!@#$%&_';
        $smallLetters = 'abcdefghijklmnopqrstuvwxy';
        $numbers = '1234567890';
        
        // select one capital letter
        $tempPassword .= $capitalLetters[random_int(0, strlen($capitalLetters) - 1 )];

    
        // select one special character
        $tempPassword .= $specialChars[random_int(0, strlen($specialChars) - 1 )];

        // select one small letter
        $tempPassword .= $smallLetters[random_int(0, strlen($smallLetters) - 1 )];

        //select one number
        $tempPassword .= $numbers[random_int(0, strlen($numbers) - 1)];

        // Fill remaining characters (to ensure length is at least 8)
        $allChars = $capitalLetters . $smallLetters . $numbers . $specialChars;
        for ($i = 0; $i < 4; $i++) { // 4 more characters to reach 8
            $tempPassword .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        $tempPassword = str_shuffle($tempPassword);
        return $tempPassword;
    }

    public function generateRandomString() {
        $tempPassword = '';

        $capitalLetters = 'ABCDEFGHIJKLMNOPQGRSTUVWXYZ';
        $smallLetters = 'abcdefghijklmnopqrstuvwxy';
      
        
        // select one capital letter
        $tempPassword .= $capitalLetters[random_int(0, strlen($capitalLetters) - 1 )];


        // select one small letter
        $tempPassword .= $smallLetters[random_int(0, strlen($smallLetters) - 1 )];

    
        // Fill remaining characters (to ensure length is at least 8)
        $allChars = $capitalLetters . $smallLetters;
        for ($i = 0; $i < 4; $i++) { // 4 more characters to reach 8
            $tempPassword .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        $tempPassword = str_shuffle($tempPassword);
        return $tempPassword;
    }

    public function generateRandomNumber() {
        $numbers = '1234567890';
        $randomNumber = '';
      
        for ($i = 0; $i < 53; $i++) { // 4 more characters to reach 8
            $randomNumber .= $numbers[random_int(0, strlen($numbers) - 1)];
        }

        return $randomNumber;
    }

} 