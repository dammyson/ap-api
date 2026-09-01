<?php

namespace App\Http\Controllers\Soap;

use App\Exceptions\HititException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Soap\GetAirExtraChargesAndProductBuilder;
use App\Http\Requests\Soap\GetExtraChargesAndProductRequest;
use Illuminate\Support\Facades\Log;

class GetAirExtraChargesAndProductsController extends Controller
{
    protected $getAirExtraChargesAndProductBuilder;
    
    protected $craneOTASoapService;

    public function __construct(GetAirExtraChargesAndProductBuilder $getAirExtraChargesAndProductBuilder)
    {
        $this->getAirExtraChargesAndProductBuilder = $getAirExtraChargesAndProductBuilder;
        
        $this->craneOTASoapService = app('CraneOTASoapService');
    }

    
    public function getAirExtraChargesAndProduct(GetExtraChargesAndProductRequest $request) {
        try {
            $preferredCurrency = $request->input('preferredCurrency');
            $bookFlightSegmentList = $request->input('bookFlightSegmentList');       
            $locationCode = $request->input('locationCode');
            $passengerTypeQuantityList = $request->input('passengerTypeQuantityList'); 
            $tripType = $request->input('tripType');

            $xml = $this->getAirExtraChargesAndProductBuilder->getExtraChargesAndProduct(
                $preferredCurrency,
                $bookFlightSegmentList,       
                $locationCode,
                $passengerTypeQuantityList,
                $tripType
            );

            $function = 'http://impl.soap.ws.crane.hititcs.com/GetAirExtraChargesAndProducts';
        

            $response = $this->craneOTASoapService->run($function, $xml);
            
            return $response;
        } catch (HititException $e) {
            
            Log::error('HITIT ERROR RETRIEVING EXTRA CHARGES AND PRODUCTS', [
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'error' => true,
                'message' => $e->getMessage(),
                'code' => $e->hititCode,
            ], 400);

        } catch (\Throwable $th) {

            Log::error('ERROR RETRIEVING EXTRA CHARGES AND PRODUCTS', [
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'line' => $th->getLine(),
                'trace' => $th->getTraceAsString(),
            ]);

            // Return safe message to user
            return response()->json([
                'error' => true, 
                'message' => 'something went wrong'
            ], 500);
        }
        
    }


   

   

   


    

}
