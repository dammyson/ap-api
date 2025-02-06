<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\TeamMembersCollection;

class TeamMembersAdminController extends Controller
{
    public function teamMembers(Request $request) {
        try {
            
            $admins = new TeamMembersCollection(Admin::all());

            return response()->json([
                'error' => false,
                'admin_data' => $admins
            ], 200);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }

    public function deleteTeamMembers(Request $request, $teamMemberId) {
        
        try {

            Gate::authorize('is-admin');

           
           
            
            $admin = Admin::find($teamMemberId);
            
            if (!$admin) {
                return response()->json([
                    "error" => true,
                    "message" => "Admin account does not exist"
                ], 400); 

            } 

            $admin->delete();
                
          
            
            return response()->json([
                'error' => false,
                'admin_data' => "admin deleted successfully"
            ], 204);

        } catch (\Throwable $th) {
            
            Log::error($th->getMessage());
    
            return response()->json([
                "error" => true,            
                "message" => "something went wrong"
            ], 500);
        }  
    }
}
