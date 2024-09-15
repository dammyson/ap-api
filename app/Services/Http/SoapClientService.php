<?php

namespace App\Services\Http;

use nusoap_client;

class SoapClientService
{
    protected $client;

   public function __construct($wsdl)
    {
        $this->client = new nusoap_client($wsdl, 'wsdl');
        $this->client->soap_defencoding = 'UTF-8';
        $this->client->decode_utf8 = false;

        // Check for errors
        $err = $this->client->getError();
        if ($err) {
            throw new \Exception("Constructor error: " . $err);
        }
    }

    public function run($function, $xml)
    {
        ini_set('memory_limit', '2560M');
        $result = $this->client->send($xml, $function);

        // Check for a fault
        if ($this->client->fault) {
            throw new \Exception("Fault: " . print_r($result, true));
        }

        // Check for errors
        $err = $this->client->getError();
        if ($err) {
            throw new \Exception("Error: " . $err);
        }

        return $result;
    }
}
