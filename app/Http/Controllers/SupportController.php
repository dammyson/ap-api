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

        } catch(\Throwable $th) {
            Log::error($th);
            return [
                "error" => true,
                "message" => "Something went wrong"
            ];
        }
    }
}
