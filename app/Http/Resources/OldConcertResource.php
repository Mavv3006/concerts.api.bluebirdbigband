<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

class OldConcertResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'band_name' => $this->band->name,
            'date' => $this->date(),
            'date_time_from' => $this->start_time,
            'date_time_to' => $this->end_time,
            'description_organizer' => $this->organizer_description,
            'description_place' => $this->place_description,
            'place_street' => $this->place_street,
            'place_number' => $this->place_number,
            'place' => $this->place->plz,
            'place_name' => $this->place->name
        ];
    }
}
