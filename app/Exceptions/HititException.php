<?php

namespace App\Exceptions;

use Exception;

class HititException extends Exception
{
    public function __construct(
        string $message,
        public readonly ?string $hititCode = null,
    ) {
        parent::__construct($message);
    }
}