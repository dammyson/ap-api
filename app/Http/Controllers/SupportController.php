<?php

namespace App\Http\Controllers;

use App\Http\Requests\Support\ContactSupportRequest;
use App\Notifications\ContactSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SupportController extends Controller
{
    public function contactSupport(ContactSupportRequest $request) {
        try {
            
            $details = $request->validated();
            $email = config('app.airpeace.email');
            Notification::route('mail', $email)
                            ->notify(new ContactSupport($details));

            return response()->json([
                "error" => false,
                "message" => "Complaint sent to support successfully"
            ], 200);

        } catch (\Throwable $th) {

            Log::error('ERROR CONTACTING SUPPORT', [
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
