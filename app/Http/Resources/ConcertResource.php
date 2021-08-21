<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ConcertResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'date' => $this->date->format('Y-m-d'),
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'band_name' => $this->band->name,
            'location' => [
                'street' => $this->place_street,
                'number' => $this->place_number,
                'plz' => $this->place_plz,
                'name' => $this->place->name
            ]
        ];
    }
}
