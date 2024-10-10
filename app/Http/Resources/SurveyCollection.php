<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SurveyCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return $this->collection->map(function ($survey) {
            return [
                "id" => $survey->id,
                'title' => $survey->title, 
                'duration_of_survey' => $survey->duration_of_survey, 
                'image_url' => $survey->image_url, 
                'points_awarded' => $survey->points_awarded,
                'is_published' => $survey->is_published,
                'created_at' => $survey->created_at,
                'updated_at' => $survey->updated_at,
                'image_url_link' => Storage::url($survey->image_url),
            ];
        })->toArray();
    }
}
