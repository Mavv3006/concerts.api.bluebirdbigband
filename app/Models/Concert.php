<?php


namespace App\Models;


use DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concert extends Model
{
    use HasFactory;

    protected $dates = [
        'date'
    ];

    protected $fillable = [
        'start_time',
        'end_time',
        'place_street',
        'place_number',
        'place_description',
        'organizer_description',
        'band_id',
        'date',
        'place_plz'
    ];

    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    public function band(): BelongsTo
    {
        return $this->belongsTo(Band::class, 'band_id', 'id');
    }

    public function place(): BelongsTo
    {
        return $this->belongsTo(Place::class, 'place_plz', 'plz');
    }

    public function date()
    {
        return $this->date->format('Y-m-d');
    }
}
