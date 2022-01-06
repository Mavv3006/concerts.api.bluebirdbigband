<?php

use App\Models\Concert;
use Illuminate\Support\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ConcertsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_upcoming_including_today()
    {
        Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => date('H:i:s')
        ]);
        $concert = Concert::first();

        $this->json('GET', 'upcoming')
            ->seeJsonContains([
                'date' => $concert->date(),
            ]);
    }

    public function test_upcoming_past_start_time()
    {
        $time = new DateTime();
        $time->modify('-2 hours');
        $concert = Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => $time->format('H:i:s'),
        ]);

        $count = $this
            ->json('GET', 'upcoming')
            ->count();

        $this->assertEquals(1, $count);
    }
}
