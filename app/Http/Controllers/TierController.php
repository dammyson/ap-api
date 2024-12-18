<?php


namespace App\Http\Controllers;

use App\Models\Tier;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Models\InvoiceRecord;
use Illuminate\Support\Facades\Auth;
use App\Services\Wallet\VerificationService;

class TierController extends Controller
{
    /**
     * Upgrade the user's tier.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upgradeTier(Request $request )
    {
        // Validate the request to ensure a valid tier_id is provided
        $request->validate([
            'amount' => 'required|string',
            'tier_id' => 'required|exists:tiers,id',
            'ref_id' => 'required|string'
        ]);

        //validate verifiedRequest;
        $new_top_request = new VerificationService($request->ref_id);
        $verified_request = $new_top_request->run();
        
        $paidAmount = $verified_request["data"]["amount"];
        // create invoice table   // add booking_id
        $invoice = InvoiceRecord::create([
            'amount' => $paidAmount,
            'booking_id' => "not applicable",
            'is_paid' => true
        ]);            

        // create invoice_items table
        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'product' => 'tier', 
            'quantity' => '1',
            'price' => $paidAmount
        ]);

        if ($paidAmount == 3000) {
            $tier = Tier::where('name', 'Bronze')->first();
        } else if($paidAmount == 5000) {
            $tier = Tier::where('name', 'Silver')->first();

        } else if ($paidAmount == 7000) {
            $tier = Tier::where('name', 'Gold')->first();

        } else if($paidAmount == 9000) {
            $tier = Tier::where('name', 'Platinum')->first();

        }

        

        // Get the authenticated user
        // $user = Auth::user();

        $user = $request->user();
        
        // Find the new tier
        $tier = Tier::find($request->input('tier_id'));

        // if ($tier) {
        //     // Associate the new tier with the user
        //     $user->tiers()->attach($tier);
        //     $user->save();

        //     // Optionally, you can notify the user or perform additional actions
        //     return response()->json([
        //         'message' => 'Tier upgraded successfully!',
        //         "user" => $user
        //     ]);
        // }

        if ($tier) {
            $currentTier = $user->currentTier(); 

            if ($currentTier) {
                if ($currentTier->rank > $tier->rank) {
                    return response()->json([
                        "error" => true,
                        "message" => "user already in a higher tier"
                    ], 400);
                } else if ($currentTier->rank == $tier->rank) {
                    return response()->json([
                        "error" => true,
                        "message" => "cannot upgrade same tier"
                    ], 500);
                }
                
                $user->tiers()->updateExistingPivot($currentTier?->id, ['is_current' => false]);
            } 
            
            $user->tiers()->attach($tier->id, [
                'is_current' => true,
                'expires_at' => null, // Reset expiration for calculated tiers
                'source' => 'calculated',
            ]);
            
            $user->tier_id = $tier->id;
            $user->save();
            // $user->load('tiers');

            return response()->json([
                'message' => 'Tier upgraded successfully!',
                "user" => $user
            ]);

        }

        return response()->json(['message' => 'Tier upgrade failed.'], 500);
    }
}
