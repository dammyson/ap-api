<?php

namespace App\Services\TermsAndConditions;

use App\Models\TermsAndCondition;
use App\Models\UserTermsAcceptance;
use Illuminate\Support\Facades\Hash;

class StoreUserTermsAndConditions 
{


    public function __construct()
    {
      
    }
    
    public function run(array $data)
    {   
        try {
            
            $termsId = $data['terms_id'];

            $terms = TermsAndCondition::findorFail($termsId);

            UserTermsAcceptance::create(
                [
                    'user_id' => $data['user_id'],
                    'terms_and_conditions_id' =>  $termsId,
                    'accepted_at' => now(),
                    'ip_address' => $data['ip_address'],
                    'user_agent' => $data['user_agent'],
                    'content_hash' => Hash::make($terms->content)
                ]
            );
            
            
        }  

         catch (\Throwable $th) {
            throw $th;
           
        }  
    
           
    }



}