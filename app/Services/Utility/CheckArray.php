<?php

namespace App\Services\Utility;

class CheckArray {
    public function isAssociativeArray($array) {
        if (!is_array($array)) {
            return false;
        }

        // Check if the array is associative by looking at the keys
        return array_keys($array) !== range(0, count($array) - 1);
    }
}