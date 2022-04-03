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

    /*
     * TODO: add test to verify response structure
     * TODO: add test for past concerts when there are concerts for in the future in the DB
     * TODO: add test to verify that /concerts/all returns all concerts available in the DB
     * */

    public function test_upcoming_including_today()
    {
        Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => date('H:i:s')
        ]);
        $concert = Concert::first();

        $this->json('GET', 'concerts/upcoming')
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
            ->get('concerts/upcoming')
            ->count();

        $this->assertEquals(1, $count);
    }

    public function test_upcoming_no_concerts()
    {
        $this
            ->get('concerts/upcoming')
            ->seeJsonStructure(['*' => []]);
    }

    public function test_all_no_concerts()
    {
        $this
            ->get('concerts/all')
            ->seeJsonStructure(['*' => []]);
    }

    public function test_past_no_concerts()
    {
        $this
            ->get('concerts/past')
            ->seeJsonStructure(['*' => []]);
    }
}
