<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
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
                "title" => $user->title,
                "user_first_name" => $user->first_name,
                "user_last_name" => $user->last_name,
                "email" => $user->email,
                "nationality" => $user->nationality,
                "peace_id" => $user->peace_id,                
                "image_url" => $user->image_url,
                "image_url_link" => Storage::url($user->image_url),
            ];
        })->toArray();
    }

}
