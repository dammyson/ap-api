<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\EditProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function getProfile(Request $request) {
        try {
            $user = $request->user();

            return response()->json([
                "error" => "false",
                "user" => $user
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
       
    }

    public function editProfile(EditProfileRequest $request) {
        $user = $request->user;

        try {

            $user->image_url = $request['image_url'] ?? $user->image_url;
            $user->title = $request['title'] ?? $user->title;
            $user->first_name = $request['first_name'] ?? $user->first_name;
            $user->last_name = $request['last_name'] ?? $user->last_name;
            $user->nationality = $request['nationality'] ?? $user->nationality;
            $user->date_of_birth = $request['date_of_birth'] ?? $user->date_of_birth;
            $user->email = $request['email'] ?? $user->email;
            $user->phone_number = $request['phone_number'] ?? $user->phone_number;
            $user->travel_document = $request['travel_document'] ?? $user->travel_document;

            $user->save();

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        return response()->json([
           'error' => false,
            'user_data' => $user
        ]);
    }
}
