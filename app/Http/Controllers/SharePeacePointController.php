<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\SharePeacePointRequest;

class SharePeacePointController extends Controller
{
    public function sharePeacePoint(SharePeacePointRequest $request) {

        $user = $request->user();
        
        try {
            $recipientPeaceId = $request->input('recipient_peace_id');
            $points = $request->input('points');
            
            $recipient = User::where('peace_id', $recipientPeaceId)->first();


            if ($recipient->id == $user->id) {
                return response()->json([
                    "error" => true,
                    "message" => "cannot share point with yourself"
                ], 404);
            }
            
            if (!$recipient) {
                return response()->json([
                    "error" => true,
                    "message" => "Recipient not found"
                ], 404);
            }

            if ($user->points < $points) {
                return response()->json([
                    "error" => true,
                    "message" => "insufficient point"
                ], 500);
            }
            
            $user->points -= $points;
            $recipient->points += $points;

            $user->save();
            $recipient->save();

            return response()->json([
                "error" => false,
                "message" => "Points shared successfully",
                "user" => $user,
                "recipient" => $recipient
            ], 200);
             
        
        } catch(\Throwable $th) {
            return response()->json([
                "error" => true,
                "message" => $th->getMessage()
            ]);
        }
        
    }

    public function increasePeacePoint(Request $request) {
        $points = $request->input('points');

        $user = $request->user();

        $user->points += $points;
        
        $user->save();

        return response()->json([
            'error' => false,
            'message' => "point allocated successfullly",
            'user_point' => $user
        ]);
    }
}
