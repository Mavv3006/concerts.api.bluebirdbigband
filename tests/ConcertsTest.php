<?php

use App\Models\Concert;
use Laravel\Lumen\Testing\DatabaseMigrations;

class ConcertsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_get_all()
    {
        $concert = Concert::factory()->create();

        $this->json('GET', 'all')
            ->seeJsonEquals([
                'date' => $concert->date
            ]);
    }
}
