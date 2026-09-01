<?php

namespace App\Services\Http;

use App\Exceptions\HititException;
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
            // throw new \Exception("Fault: " . print_r($result, true));
            throw $this->createHititException($result);
        }

        // Check for errors
        $err = $this->client->getError();
        if ($err) {
            throw new \Exception("Error: " . $err);
        }

          // Hitit can also return an error as a normal response
        if ($this->hasHititError($result)) {
            throw $this->createHititException($result);
        }

        return $result;
    }

    protected function hasHititError($result): bool
    {
        return isset($result['faultstring']) || isset($result['detail']['CraneFault']['message']);
    
    }


    protected function createHititException($result): HititException
    {
        $fault = '';

        if (isset($result['detail']) && isset($result['detail']['CraneFault']) && isset($result['detail']['CraneFault']['message']) && isset($result['detail']['CraneFault']['code'])) {
            $fault =  [
                'message' => $result['detail']['CraneFault']['message'],
                'code' => $result['detail']['CraneFault']['code']
            ];
        }
        else if (isset($result['faultstring'])) {
            $fault = [
                'message' => $result['faultstring'],
                'code' => $result['faultcode'] ?? null,
            ];
        } 
     

        if (!$fault) {
            return new HititException(
                'An error occurred while communicating with Hitit.'
            );
        }

        return new HititException(
            trim($fault['message'] ?? 'Hitit returned an unknown error.'),
            $fault['code'] ?? null
        );
    }
}
