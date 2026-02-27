<?php

namespace Tests\Feature\Api;

use App\Models\Calculation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationDeleteTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_deletes_a_single_calculation_and_returns_204(): void
    {
        $calculation = Calculation::create(['expression' => '1 + 1', 'result' => 2.0]);

        $this->deleteJson("/api/calculations/{$calculation->id}")
             ->assertStatus(204);

        $this->assertDatabaseMissing('calculations', ['id' => $calculation->id]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_404_when_deleting_nonexistent_calculation(): void
    {
        $this->deleteJson('/api/calculations/99999')
             ->assertStatus(404);
    }
}
