<?php

namespace Tests\Feature\Api;

use App\Models\Calculation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationIndexTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_lists_all_calculations_ordered_by_newest_first(): void
    {
        $older = Calculation::create(['expression' => '1 + 1', 'result' => 2.0]);
        $newer = Calculation::create(['expression' => '2 + 2', 'result' => 4.0]);

        $response = $this->getJson('/api/calculations');

        $response->assertStatus(200)
                 ->assertJsonCount(2, 'data');

        $data = $response->json('data');
        $this->assertEquals($newer->id, $data[0]['id']);
        $this->assertEquals($older->id, $data[1]['id']);
    }
}
