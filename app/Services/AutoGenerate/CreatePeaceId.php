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
}