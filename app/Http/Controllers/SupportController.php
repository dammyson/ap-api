<?php

namespace App\Http\Controllers;

use App\Http\Requests\Support\ContactSupportRequest;
use App\Notifications\ContactSupport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SupportController extends Controller
{
    public function contactSupport(ContactSupportRequest $request) {
        try {
            
            $details = $request->validated();
            Notification::route('mail', 'gilbertgenye4@gmail.com')
                            ->notify(new ContactSupport($details));

            return response()->json([
                "error" => false,
                "message" => "Complaint sent to support successfully"
            ], 200);

        } catch(\Throwable $th) {
            return [
                "error" => true,
                "actual_message" => $th->getMessage(),
                "message" => "Something went wrong"
            ];
        }
    }
}
