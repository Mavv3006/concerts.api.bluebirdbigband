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

    public function test_past_concerts_with_concerts_for_in_the_future()
    {
        $this->generate_future_concert();
        $this->get('concerts/past')->seeJsonEquals([]);
    }

    public function test_concerts_all_returns_all_concerts()
    {
        $this->generate_future_concert();
        $this->generate_past_concert();

        $this->assertCount(2, Concert::all());
        $response_count = $this
            ->get('concerts/all')
            ->response
            ->content();

        $this->assertCount(2, json_decode($response_count, true));
        $this->assertCount(2, json_decode($response_count, false));
    }

    public function test_response_structure()
    {
        $json_structure = [
            '*' => [
                'date',
                'start_time',
                'end_time',
                'band_name',
                'location' => [
                    'street',
                    'number',
                    'plz',
                    'name'
                ]
            ]
        ];

        Concert::factory()->create();

        $this
            ->get('concerts/all')
            ->seeStatusCode(200)
            ->seeJsonStructure($json_structure);

        $this
            ->get('concerts/upcoming')
            ->seeStatusCode(200)
            ->seeJsonStructure($json_structure);

        $this
            ->get('concerts/past')
            ->seeStatusCode(200)
            ->seeJsonStructure($json_structure);
    }

    public function test_upcoming_including_today()
    {
        Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => date('H:i:s')
        ]);
        $concert = Concert::first();

        $this->json('GET', 'concerts/upcoming')
            ->seeJsonContains(['date' => $concert->date()]);
    }

    public function test_upcoming_past_start_time()
    {
        $this->generate_past_concert();

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

    /**
     * @return void
     */
    private function generate_future_concert(): void
    {
        $time = new DateTime();
        $time->modify('+2 hours');
        Concert::factory()->create([
            'date' => Carbon::today()->toDateString(),
            'start_time' => $time->format('H:i:s'),
        ]);
    }

    /**
     * @return void
     */
    private function generate_past_concert(): void
    {
        $time = new DateTime();
        $time->modify('-2 hours');
        Concert::factory()->create([
            'date' => Carbon::yesterday()->toDateString(),
            'start_time' => $time->format('H:i:s'),
        ]);
    }
}
