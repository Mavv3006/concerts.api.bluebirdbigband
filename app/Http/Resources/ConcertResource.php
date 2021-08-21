<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConcertResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'date' => $this->date(),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'band_name' => $this->band->name,
            'location' => [
                'street' => $this->place_street,
                'number' => $this->place_number,
                'plz' => $this->place_plz,
                'name' => $this->place->name
            ],
            'descriptions' => [
                'place' => $this->place_description,
                'organizer' => $this->organizer_description
            ]
        ];
    }
}
