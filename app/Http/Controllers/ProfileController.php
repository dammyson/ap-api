<?php

namespace App\Http\Controllers;

use Throwable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Services\Point\TierPointService;
use App\Services\Utility\GetPointService;
use App\Http\Requests\ChangePeaceIdRequest;
use App\Http\Requests\User\EditProfileRequest;
use App\Http\Requests\ChangeProfileImageRequest;
use Defuse\Crypto\File;

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
                "error" => false,
                "user" => $user,
                "image_url_link" => $imageUrlLink,
                'travel_document_link' => $travelDocumentLink,
                "tier_details" => $tierDetails
            
            ], 200);
            
        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
       
    }

    // public function changeProfileImage(ChangeProfileImageRequest $request) {
    public function changeProfileImage(ChangeProfileImageRequest $request) {
        $user = $request->user(); 
        
        try {
            // dd(storage_path('app'), storage_path('public'));
        
            if ($request->file('image_url')) {
                // store the user image in a folder;
                if ($user->image_url) {
                    $oldPath = $user->image_url;
                    Storage::delete($oldPath);
                    // dd(" I got here");
                   

                }
                $path = $request->file('image_url')->store('users-images-folder', 'public');
                // $path = "test/"."emeka.".$request->file('image_url')->getClientOriginalExtension();
                
                // Storage::disk("public")->put($path, file_get_contents($request->file('image_url')));
                // store the path to the image in the image_url column
                // dd($path);
                $user->image_url = $path;
                $user->save();

                $imageUrlLink = Storage::url($path);

                // dd($imageUrlLink);

                return response()->json([
                    "error" => false,
                    "message" => "Profile picture updated successfully",
                    "user" => $user,
                    "image_url" => $user->image_url,
                    "image_url_link" => $imageUrlLink
                    
                ], 200);
            }
        

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,  
                "error_message" => $th->getMessage(),          
                "message" => "something went wrong"
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

            $tierDetails = $user->currentTier();        
               // get the image_url  path
            $pathToImage = $user->image_url;
            $pathToTravelDoc = $user->travel_document;
   
               // image url link
            $imageUrlLink = Storage::url($pathToImage);
            $travelDocumentLink = Storage::url($pathToTravelDoc);

            return response()->json([
                'error' => false,
                'user' => $user,
                "travel_document_link" => $travelDocumentLink,
                "image_url_link" => $imageUrlLink,
                "tier_details" => $tierDetails

             ]);

        }  catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
        
    }

    public function allocatePoint(Request $request) {
        $user = $request->user();  

        $user->points += 100000;
        $user->save();
        return response()->json([
            "error" => false,
            "points" => $user->points
        ]);
    }  
    
}
