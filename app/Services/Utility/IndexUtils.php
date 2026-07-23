<?php

namespace App\Services\Utility;

class IndexUtils {

    public function checkCurrency($preferredCurrency) {
        if ($preferredCurrency == "NGN") {
        return '4010027268';
        }
        else if ($preferredCurrency == "USD") {
        return '4010027271';
        }
        else if ($preferredCurrency == "GBP") {
        return '4010027270';
        }
    }
    
    public function flightNotesArray ($flightNotes) {
        $flightNotesXml  = '';
        if (!$flightNotes || !is_array($flightNotes)) {
            return ;
        }
                    
        foreach($flightNotes as $flightNote) {
           $flightNotesXml .=  '
            <flightNotes>
                <deiCode>' . htmlspecialchars($flightNote['deiCode'], ENT_XML1, 'UTF-8') . '</deiCode>
                <explanation>' . htmlspecialchars($flightNote['explanation'], ENT_XML1, 'UTF-8') . '</explanation>
                <note>' . htmlspecialchars($flightNote['note'], ENT_XML1, 'UTF-8') . '</note>
            </flightNotes>';
        }

        return $flightNotesXml;
    }

    
}