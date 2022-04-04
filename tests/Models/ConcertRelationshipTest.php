<?php

namespace Models;

use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Illuminate\Database\Eloquent\Collection;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ConcertRelationshipTest extends TestCase
{
    use DatabaseMigrations;

    public function testConcertHasRecording()
    {
        Concert::factory()->create();
        SongType::factory()->create();
        $concert = Concert::first();
        $recording = ConcertRecording::factory()->create();

        $this->assertEquals($concert->date(), $recording->concert_date);
        $this->assertEquals(1, $concert->recordings->count());
        $this->assertTrue($concert->recordings->contains($recording));
        $this->assertInstanceOf(Collection::class, $concert->recordings);
    }
}
