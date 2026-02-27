<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CalculationStoreTest extends TestCase
{
    use RefreshDatabase;

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_stores_a_valid_calculation_and_returns_201(): void
    {
        $response = $this->postJson('/api/calculations', [
            'expression' => '2 + 3',
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['data' => ['id', 'expression', 'result', 'created_at']]);

        $this->assertDatabaseHas('calculations', [
            'expression' => '2 + 3',
            'result' => 5.0,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_the_expression_and_result_in_response(): void
    {
        $response = $this->postJson('/api/calculations', [
            'expression' => '10 - 3',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'expression' => '10 - 3',
                     'result' => 7.0,
                 ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_422_for_empty_expression(): void
    {
        $this->postJson('/api/calculations', ['expression' => ''])
             ->assertStatus(422);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_422_for_invalid_characters_in_expression(): void
    {
        $this->postJson('/api/calculations', ['expression' => '2 + 3; DROP TABLE calculations'])
             ->assertStatus(422);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_400_for_division_by_zero(): void
    {
        $this->postJson('/api/calculations', ['expression' => '10 / 0'])
             ->assertStatus(400)
             ->assertJsonFragment(['message' => 'Division by zero is not allowed.']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_400_for_malformed_expression(): void
    {
        $this->postJson('/api/calculations', ['expression' => '2 +'])
             ->assertStatus(400)
             ->assertJsonFragment(['message' => 'The expression could not be evaluated.']);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_stores_a_calculation_with_sqrt_and_returns_201(): void
    {
        $response = $this->postJson('/api/calculations', [
            'expression' => 'sqrt(16)',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'expression' => 'sqrt(16)',
                     'result' => 4.0,
                 ]);

        $this->assertDatabaseHas('calculations', [
            'expression' => 'sqrt(16)',
            'result' => 4.0,
        ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_stores_a_calculation_with_exponentiation_and_returns_201(): void
    {
        $response = $this->postJson('/api/calculations', [
            'expression' => '2^8',
        ]);

        $response->assertStatus(201)
                 ->assertJsonFragment([
                     'expression' => '2^8',
                     'result' => 256.0,
                 ]);

        $this->assertDatabaseHas('calculations', [
            'expression' => '2^8',
            'result' => 256.0,
        ]);
    }
}
