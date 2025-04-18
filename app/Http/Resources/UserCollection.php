<?php

namespace App\Http\Resources;

use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {  
        return $this->collection->map(function ($user) {
            return [
                "id" => $user->id,
                "user_first_name" => $user->first_name,
                "user_last_name" => $user->last_name,
                "email" => $user->email,
                // "peace_id" => $user->peace_id,
                "tier" => $user->tiers->where('pivot.is_current', true)->first()?->name,
                "status" => $user->status,
                "last_login" => $user->last_login,
                "total_booked_flight" => $user->total_booked_flight ?? 0,
                // "total_booked_flight" => $this->getTotalBookedFlight($user->peace_id),
                "date_registered" => $user->created_at,
                "miles_accumulated" => $user->miles_accumulated,
                "image_url" => $user->image_url,
                "image_url_link" => Storage::url($user->image_url),
            ];
        })->toArray();
    }

    // public function getTotalBookedFlight($peaceId) {

    //     $totalBookedFlight = Flight::where("peace_id", $peaceId)->count();
    //     // $totalBookedFlight = count($totalBookedFlight);
    //     return $totalBookedFlight;
    // }
}
