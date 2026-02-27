<?php

namespace Tests\Feature\Api;

use App\Models\Calculation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationClearTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_clears_all_calculations_and_returns_204(): void
    {
        Calculation::create(['expression' => '1 + 1', 'result' => 2.0]);
        Calculation::create(['expression' => '2 + 2', 'result' => 4.0]);

        $this->deleteJson('/api/calculations')
             ->assertStatus(204);

        $this->assertDatabaseCount('calculations', 0);
    }
}
