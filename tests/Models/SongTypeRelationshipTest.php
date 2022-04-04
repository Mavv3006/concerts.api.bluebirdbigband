<?php

namespace Models;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class SongTypeRelationshipTest extends TestCase
{
    use DatabaseMigrations;

    public function testSongTypeHasRecording()
    {
        Concert::factory()->create();
        SongType::factory()->create();
        $song_type = SongType::first();
        $recording = ConcertRecording::factory()->create();

        $this->assertEquals($song_type->id, $recording->type);
        $this->assertEquals(1, $song_type->concert_recordings->count());
        $this->assertEquals(1, $song_type->concert_recordings()->count());
        $this->assertTrue($song_type->concert_recordings->contains($recording));
        $this->assertInstanceOf(Collection::class, $song_type->concert_recordings);
    }
}
