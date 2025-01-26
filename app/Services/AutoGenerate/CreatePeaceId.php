<?php


namespace App\Services\AutoGenerate;

use App\Models\User;

class CreatePeaceId {

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
}