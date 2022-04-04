<?php


use App\Models\Concert;
use App\Models\ConcertRecording;
use App\Models\SongType;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ConcertRecordingFactoryTest extends TestCase
{
    use DatabaseMigrations;

    public function test_create_concert_recording()
    {
        $this->assertEquals(0, ConcertRecording::all()->count());

        Concert::factory()->create();
        SongType::factory()->create();
        ConcertRecording::factory()->create();
        $this->assertEquals(1, ConcertRecording::all()->count());
    }
}
