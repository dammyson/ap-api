<?php

namespace App\Services\Utility;

class OrganiseChart {
    public function organiseWeek($transactionArray) {
        // Define an array for all days of the week with default total_amount as 0
        $daysOfWeek = [
            "Monday" => ["name" => "Monday", "total_amount" => 0],
            "Tuesday" => ["name" => "Tuesday", "total_amount" => 0],
            "Wednesday" => ["name" => "Wednesday", "total_amount" => 0],
            "Thursday" => ["name" => "Thursday", "total_amount" => 0],
            "Friday" => ["name" => "Friday", "total_amount" => 0],
            "Saturday" => ["name" => "Saturday", "total_amount" => 0],
            "Sunday" => ["name" => "Sunday", "total_amount" => 0],
        ];

         // Populate ticket data with query results
        foreach ($transactionArray as $transaction) {
            $dayName = $transaction->day_name;
            $daysOfWeek[$dayName]['total_amount'] = (int) $transaction->total_amount;
        }

        // Convert the daysOfWeek array to a non-associative array for JSON response
        return array_values($daysOfWeek);
        
    } 

    public function organiseYear($transactionArray) {
        // Define an array for all days of the week with default total_amount as 0
        $daysOfWeek = [
            "January" => ["name" => "January", "total_amount" => 0],
            "Febuary" => ["name" => "Febuary", "total_amount" => 0],
            "March" => ["name" => "March", "total_amount" => 0],
            "April" => ["name" => "April", "total_amount" => 0],
            "May" => ["name" => "May", "total_amount" => 0],
            "June" => ["name" => "June", "total_amount" => 0],
            "July" => ["name" => "July", "total_amount" => 0],
            "August" => ["name" => "August", "total_amount" => 0],
            "September" => ["name" => "September", "total_amount" => 0],
            "October" => ["name" => "October", "total_amount" => 0],
            "November" => ["name" => "November", "total_amount" => 0],
            "December" => ["name" => "December", "total_amount" => 0]
        ];

         // Populate ticket data with query results
        foreach ($transactionArray as $transaction) {
            $monthName = $transaction->month_name;
            $daysOfWeek[$monthName]['total_amount'] = (int) $transaction->total_amount;
        }

        // Convert the daysOfWeek array to a non-associative array for JSON response
        return array_values($daysOfWeek);
        
    }

}