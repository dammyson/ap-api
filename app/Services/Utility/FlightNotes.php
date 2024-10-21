<?php

namespace App\Services\Utility;

class FlightNotes {
    public function flightNotesArray ($flightNotes) {
        $flightNotesXml  = '';
                    
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