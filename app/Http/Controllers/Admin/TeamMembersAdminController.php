<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamMembersAdminController extends Controller
{
    public function teamMembers(Request $request) {
        try {
            
            $admins = Admin::all();
            

            return response()->json([
                'error' => false,
                'admin_data' => $admins
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }

    public function deleteTeamMembers(Request $request, $teamMemberId) {
        
        try {
            
            $admin = $request->user('admin');

            if ($admin->role  != 'Admin') {
                return response()->json([
                    "error" => true,
                    "message" => "You do not have permission to view team members.
                        Please contact your system administrator if you believe this is an error"
                ], 403);
            }
            
            $admin = Admin::find($teamMemberId);
            
            $admin->delete();
            
            return response()->json([
                'error' => false,
                'admin_data' => "admin deleted successfully"
            ], 204);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
