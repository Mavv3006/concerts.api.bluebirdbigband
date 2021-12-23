<?php

use App\Models\Concert;
use App\Models\ConcertRecording;
use Illuminate\Support\Facades\Schema;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ConcertRecordingRelationshipTest extends TestCase
{
    use DatabaseMigrations;

    public function testAssertCorrectDatabaseColumns()
    {
        $this->assertTrue(
            Schema::hasColumns('concert_recordings', [
                'id',
                'concert_date',
                'file_name',
                'song_name',
                'size'
            ])
        );
        $this->assertTrue(
            Schema::hasColumns('concerts', [
                'date'
            ])
        );
    }

    public function testConcertHasRecording()
    {
        $concert = Concert::factory()->create();
        $recording = ConcertRecording::factory()->create(['concert_date' => $concert->date()]);

        $this->assertEquals($concert->date(), $recording->concert_date);
        $this->assertEquals(1, $concert->recordings->count());
        $this->assertTrue($concert->recordings->contains($recording));
        $this->assertInstanceOf('\Illuminate\Database\Eloquent\Collection', $concert->recordings);
    }

    public function testRecordingHasConcert()
    {
        $concert = Concert::factory()->create();
        $recording = ConcertRecording::factory()->create(['concert_date' => $concert->date()]);

        $this->assertEquals($concert->date(), $recording->concert_date);
        $this->assertInstanceOf(Concert::class, $recording->concert);
        $this->assertEquals(1, $recording->concert->count());
    }
}