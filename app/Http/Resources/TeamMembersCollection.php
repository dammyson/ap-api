<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Storage;

class TeamMembersCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($admin) {
            return [
                "id" => $admin->id,
                "user_name" => $admin->user_name,
                "email" => $admin->email,
                "password" => $admin->password,
                "image_url" => $admin->image_url,
                "image_url_link" => Storage::url($admin->image_url),
                "role" => $admin->role,
                "phone_number" => $admin->phone_number
            ];
        })->toArray();
    }
}
