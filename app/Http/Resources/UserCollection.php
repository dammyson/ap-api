<?php

namespace App\Http\Resources;

use App\Models\FlightRecord;
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
                "tier" => "null",
                "status" => "null",
                "last_login" => "null",
                // "total_booked_flight" => $user->total_booked_flight ?? 0,
                "total_booked_flight" => $this->getTotalBookedFlight($user),
                "miles_accumulated" => "null",
                "image_url" => $user->image_url,
                "image_url_link" => Storage::url($user->image_url),
            ];
        })->toArray();
    }

    public function getTotalBookedFlight($user) {

        $totalBookedFlight = FlightRecord::where("peace_id", $user->peace_id)->count();
        return $totalBookedFlight;
    }
}
