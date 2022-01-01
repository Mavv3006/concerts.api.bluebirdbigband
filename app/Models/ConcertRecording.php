<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ConcertRecording extends Model
{
    use HasFactory;

    public function concert(): BelongsTo
    {
        return $this->belongsTo(Concert::class, 'concerts_date', 'date');
    }
}
