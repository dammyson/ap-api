<?php


namespace App\Services\AutoGenerate;

use App\Models\User;

class GenerateRandom {

    public function generateUniquePeaceId() {
        $peaceId =  $this->generatePeaceId();
        $user = User::where('peace_id', $peaceId)->first();

        if ($user) {
            return $this->generateUniquePeaceId();

        } 

        return $peaceId;
      
    }


    public function generatePeaceId() { 
        
        // Define a set of digits
        $digits = '0123456789';
        
        // Initialize an empty string
        $uniqueId = '';

        // Loop 9 times to generate a 9-digit string
        for ($i = 0; $i < 9; $i++) {
            $uniqueId .= $digits[random_int(0, 9)];  // Use random_int for cryptographically secure integers
        }

      
        return $uniqueId;
    
    }

    public function generateName() {
        $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $uniqueName = 'guest_';
        for ($i = 0; $i < 9; $i++) {
            $uniqueName .= $alphabets[random_int(0, 51)];  // Use random_int for cryptographically secure integers
        }

        return $uniqueName;

    }

    public function generateEmail() {
        $alphabets = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $uniqueEmail = 'guest_';
        for ($i = 0; $i < 9; $i++) {
            $uniqueEmail .= $alphabets[random_int(0, 51)];  // Use random_int for cryptographically secure integers
        }

         $uniqueEmail .= '@gmail.com';
         return $uniqueEmail;

    }

    public function generateUniqueEmail() {
        $email =  $this->generateEmail();
        $user = User::where('email', $email)->first();

        if ($user) {
            return $this->generateUniqueEmail();

        } 
        return $email;      
    }


    public function generateUniquePhoneNo() {
        $phoneNo =  $this->generatePhoneNumber();
        $user = User::where('phone_number', $phoneNo)->first();

        if ($user) {
            return $this->generateUniquePhoneNo();

        } 
        return $phoneNo;      
    }

    public function generatePhoneNumber() { 
        
        // Define a set of digits
        $digits = '0123456789';
        
        // Initialize an empty string
        $uniqueId = 'guest_'; 

        // Loop 9 times to generate a 9-digit string
        for ($i = 0; $i < 11; $i++) {
            $uniqueId .= $digits[random_int(0, 9)];  // Use random_int for cryptographically secure integers
        }

      
        return $uniqueId;
    
    }

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