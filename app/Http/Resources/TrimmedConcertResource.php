<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrimmedConcertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        var_dump($this->recordings()->getResults()->toQuery());

        return [
            'date' => $this->date(),
            'description' => $this->place_description,
            'recordings' => ConcertRecordingResource::collection($this->recordings()->getResults())
        ];
    }
}
