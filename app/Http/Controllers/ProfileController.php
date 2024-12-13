<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePeaceIdRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\ChangeProfileImageRequest;
use App\Services\Utility\GetPointService;
use Illuminate\Support\Facades\Auth;
use Throwable;
use App\Services\Point\TierPointService;

class ProfileController extends Controller
{
    public function getProfile(Request $request) {
        try {
            
            $user = $request->user();
           
            // get the image_url  path
            $pathToImage = $user->image_url;
            $pathToTravelDoc = $user->travel_document;

            // image url link
            $imageUrlLink = Storage::url($pathToImage);
            $travelDocumentLink = Storage::url($pathToTravelDoc);
            $tierDetails = $user->currentTier();
            
            return response()->json([
                "error" => "false",
                "user" => $user,
                "image_url_link" => $imageUrlLink,
                'travel_document_link' => $travelDocumentLink,
                "tier_details" => $tierDetails
            
            ], 200);
            
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
       
    }

    public function changeProfileImage(ChangeProfileImageRequest $request) {
        $user = $request->user(); 
        
        // dd("I ran");
        try {
            if ($request->file('image_url')) {
                // store the user image in a folder;
                if ($user->image_url) {
                    $oldPath = $user->image_url;
                    Storage::delete($oldPath);

                }
                $path = $request->file('image_url')->store('users-images-folder', 'public');
                // store the path to the image in the image_url column
                $user->image_url = $path;
                $user->save();

                $imageUrlLink = Storage::url($path);
                return response()->json([
                    "error" => false,
                    "message" => "Profile picture updated successfully",
                    "user" => $user,
                    "image_url" => $user->image_url,
                    "image_url_link" => $imageUrlLink
                    
                ], 200);
            }
        

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }

        
    }



    public function editProfile(EditProfileRequest $request) {
        $user = $request->user();  

        try {

            $user->title = $request['title'] ?? $user->title;
            $user->first_name = $request['first_name'] ?? $user->first_name;
            $user->last_name = $request['last_name'] ?? $user->last_name;
            $user->nationality = $request['nationality'] ?? $user->nationality;
            $user->date_of_birth = $request['date_of_birth'] ?? $user->date_of_birth;
            $user->email = $request['email'] ?? $user->email;
            $user->phone_number = $request['phone_number'] ?? $user->phone_number;
            

            if ($request->file('travel_document')) {
                if ($user->travel_document) {
                    $oldPath = $user->travel_document;
                    Storage::delete($oldPath);

                }
                $path = $request->file('travel_document')->store('users-travel-documents-folder');
                $user->travel_document = $path;
            }

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


    public function getPoint(Request $request) {
        try {
            
            $user = Auth::user(); 

            $result =(new GetPointService())->domesticPoints('LOS-ABV', 'C', false);

            $user = User::find($user->id);
            $user->addPoints(1);

            dd( $user );

           // dd( $result);
              // Act: Add points to the user
            $point = 100;
            $validForDays = 365;

           

            $points = $user->tierPoint->total_points;

            dd($points);
            
        } catch (\Throwable $th) {
            return response()->json([
                "error" => "true",
                "message" => $th->getMessage()
            ]);
        }
       
    }
    
}
