<?php

namespace Models;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ConcertRecordingRelationshipTest extends TestCase
{
    use DatabaseMigrations;

    public function testRecordingHasConcert()
    {
        $recording = $this->getConcertRecording();

        $this->assertEquals(1, Concert::all()->count());
        $this->assertEquals(1, ConcertRecording::all()->count());
        $this->assertEquals(Concert::first()->date(), $recording->concert_date);
        $this->assertEquals(1, $recording->concert()->count());
        $this->assertEquals(1, $recording->concert->count());
        $this->assertInstanceOf(Concert::class, $recording->concert);
    }

    public function testRecordingHasType()
    {
        $recording = $this->getConcertRecording();

        $this->assertEquals(1, SongType::all()->count());
        $this->assertEquals($recording->type, SongType::first()->id);
        $this->assertEquals(1, $recording->song_type()->count());
        $this->assertEquals(1, $recording->song_type->count());
        $this->assertInstanceOf(SongType::class, $recording->song_type);
    }

    private function createDbEntries()
    {
        Concert::factory()->create();
        SongType::factory()->create();
    }

    private function getConcertRecording(): Model|Collection
    {
        $this->createDbEntries();
        return ConcertRecording::factory()->create();
    }

}
