<?php
namespace App\Services\Utility;

use App\Services\BaseServiceInterface;

class GetPointService
{
    protected $DomesticRoutes;
    protected $RegionRoutes;
    protected $InternationalRoutes; // newly added

    public function __construct()
    {       

        $this->DomesticRoutes = [
            'LOS-ABV-LOS', 'LOS-KAN-LOS', 'ABV-KAN-ABV', 'ABV-YOL-ABV',
            'LOS-BNI-LOS', 'ABV-BNI-ABV', 'LOS-AKR-LOS', 'ABV-AKR-ABV',
            'LOS-ABB-LOS', 'ABV-ABB-ABV', 'LOS-PHC-LOS', 'ABV-PHC-ABV',
            'LOS-ENU-LOS', 'ABV-ENU-ABV', 'LOS-QOW-LOS', 'ABV-QOW-ABV',
            'LOS-CBQ-LOS', 'ABV-CBQ-ABV', 'LOS-QRW-LOS', 'ABV-QRW-ABV',
            'LOS-ILR-LOS', 'ABV-ILR-ABV', 'LOS-YOL-LOS', 'LOS-GMO-LOS',
            'LOS-MIU-LOS', 'ABV-GMO-ABV', 'ABV-MIU-ABV', 'LOS-ANA-LOS',
            'ABV-ANA-LOS', 'LOS-QUO-LOS', 'ABV-QUO-ABV', 'LOS-MDI-LOS', 
            'ABV-MDI-ABV'
        ];

        $this->RegionRoutes = [
            'LOS-ACC-LOS',
            'LOS-FNA-LOS',
            'LOS-ROB-LOS',
            'LOS-DLA-LOS',
            'LOS-BJL-LOS',
            'LOS-DSS-LOS',
            'LOS-LFW-LOS',
            'LOS-JNB-LOS',
            'LOS-JED-LOS',
            'KAN-JED-KAN',
        ];

        ////////
        $this->InternationalRoutes = [
            'LOS-LGW-LOS',
            'LOS-JED-LOS',
            'KAN-JED-KAN'
        ];
      
    }

    private function calculatePoints($route, $class, $routeList, $pointsList, $tierPointsList = null)
    {
        $routeReverse = implode('-', array_reverse(explode('-', $route)));
        $routeOptions = [$route, $routeReverse];

        foreach ($routeOptions as $routeOption) {
            foreach ($routeList as $definedRoute) {
                if (strpos($definedRoute, $routeOption) !== false) {
                    foreach ($pointsList as $classes => $points) {
                        $classArray = explode(',', $classes);
                        if (in_array($class, $classArray)) {
                            $tierPoints = $tierPointsList[$classes] ?? 0; 
                            return [
                                'points' => $points,
                                'tierPoints' => $tierPoints
                            ];
                        }
                    }
                }
            }
        }

        return [
            'points' => 0,
            'tierPoints' => 0
        ];
    }

    private function getDomesticPoints()
    {
        return [
            'C' => 1650,
            'J' => 1600,
            'A,F' => 850, 
            'W,Y' => 560,
            'S,B' => 520, 
            'H,K,L' => 480,
            'M,T,V' => 480
        ];
    }

    private function getDomesticTierPoints()
    {
        return [
            'C' => 30,
            'J' => 30,
            'A,F' => 28, 
            'W,Y' => 28,
            'S,B' => 26, 
            'H,K,L' => 24,
            'M,T,V' => 24
        ];
    }

    private function getRegionalPoints()
    {
        return [
            'C' => 4000,
            'D' => 3500,
            'A,F' => 1600, 
            'Y,B' => 1000,
            'H,K,L' => 1000,
            'M,T,V' => 1000
        ];
    }

    private function getRegionalTierPoints()
    {
        return [
            'C' => 52,
            'D' => 52,
            'A,F' => 44, 
            'Y,B' => 44,
            'H,K,L' => 36,
            'M,T,V' => 36
        ];
    }
 
    public function domesticPoints($route, $class, $includeTierPoints = false)
    {
        return $this->calculatePoints(
            $route, 
            $class, 
            $this->DomesticRoutes, 
            $this->getDomesticPoints(), 
            $includeTierPoints ? $this->getDomesticTierPoints() : null
        );
    }

    public function regionalPoints($route, $class, $includeTierPoints = false)
    {
        return $this->calculatePoints(
            $route, 
            $class, 
            $this->RegionRoutes, 
            $this->getRegionalPoints(), 
            $includeTierPoints ? $this->getRegionalTierPoints() : null
        );
    }

    /////////////////////////////////////////
    /////////////////////////////////////////
    /////////////////////////////////////////
    private function redeemDomesticFlight() {
        return [
            "Business" => 27000,
            "Premium" => 18000,
            "Economy" => 14000

        ];        
    }

    private function redeemRegionalFlight() {
        return [
            "Business" => 70000,
            "Premium" => 50000,
            "Economy" => 35000
        ];
    }

    private function redeemInternationalFlight() {
        return [
            "Business" => 130000,
            "Premium" => 110000,
            "Economy" => 90000
        ];
    }

    private function calculateRedemptionFlightPoints($route, $class, $routeList, $pointsList) {
        // get the string as reveresed
        $routeReverse =  implode('-', array_reverse(explode('-', $route)));

        $routeOptions = [$route, $routeReverse];
        foreach ($routeOptions as $routeOption) {
            foreach ($routeList as $defineRoute) {
                if (strpos($routeOption, $defineRoute) !== false) {
                    foreach ($pointsList as $flightClass => $points) {
                        if ($class == $flightClass) {
                            return [
                                "class" => $class,
                                "points" => $points
                            ];
                        }
                    }
                }            
            }
        }
    }

    public function getFlightRedemptionPoints($route, $class, $type) {
        if ($type == "Domestic") {
            return $this->calculateRedemptionFlightPoints($route, $class, $this->DomesticRoutes, $this->redeemDomesticFlight());
            
        } else if ($type == "Regional") {
            return $this->calculateRedemptionFlightPoints($route, $class, $this->RegionRoutes, $this->redeemRegionalFlight());
            
        } else if ($type == "International") {
            return $this->calculateRedemptionFlightPoints($route, $class, $this->InternationalRoutes, $this->redeemInternationalFlight());

        }

    }
}
