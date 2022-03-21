<?php

namespace Http\Controllers;

use App\Models\Concert;
use DateTime;
use Illuminate\Support\Carbon;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class ConcertsControllerTest extends TestCase
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
        Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => $time->format('H:i:s'),
        ]);

        $count = $this
            ->json('GET', 'upcoming')
            ->count();

        $this->assertEquals(1, $count);
    }

    public function test_no_concerts()
    {
        $this
            ->get('upcoming')
            ->seeJsonStructure(['*' => []]);
    }
}
