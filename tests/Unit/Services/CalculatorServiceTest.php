<?php

namespace Tests\Unit\Services;

use App\Exceptions\DivisionByZeroException;
use App\Exceptions\InvalidExpressionException;
use App\Parsers\BasicExpressionParser;
use App\Services\CalculatorService;
use PHPUnit\Framework\TestCase;

class CalculatorServiceTest extends TestCase
{
    private CalculatorService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CalculatorService(new BasicExpressionParser());
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_add_two_numbers(): void
    {
        $this->assertEquals(5.0, $this->service->evaluate('2 + 3'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_subtract_two_numbers(): void
    {
        $this->assertEquals(7.0, $this->service->evaluate('10 - 3'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_multiply_two_numbers(): void
    {
        $this->assertEquals(20.0, $this->service->evaluate('4 * 5'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_divide_two_numbers(): void
    {
        $this->assertEquals(5.0, $this->service->evaluate('20 / 4'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_division_by_zero(): void
    {
        $this->expectException(DivisionByZeroException::class);
        $this->service->evaluate('10 / 0');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_invalid_expression(): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->service->evaluate('DROP TABLE calculations');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_throws_on_malformed_expression(): void
    {
        $this->expectException(InvalidExpressionException::class);
        $this->service->evaluate('2 +');
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_respects_operator_precedence(): void
    {
        $this->assertEquals(14.0, $this->service->evaluate('2 + 3 * 4'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_decimal_operands(): void
    {
        $this->assertEquals(0.3, $this->service->evaluate('0.1 + 0.2'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_parentheses(): void
    {
        $this->assertEquals(20.0, $this->service->evaluate('(2 + 3) * 4'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_exponentiation(): void
    {
        $this->assertEquals(256.0, $this->service->evaluate('2^8'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_sqrt(): void
    {
        $this->assertEquals(4.0, $this->service->evaluate('sqrt(16)'));
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_handles_complex_chained_expression(): void
    {
        // Stretch goal: sqrt((((9*9)/12)+(13-4))*2)^2
        $result = $this->service->evaluate('sqrt((((9*9)/12)+(13-4))*2)^2');
        $this->assertIsFloat($result);
        // (81/12 + 9) * 2 = (6.75 + 9) * 2 = 31.5
        // sqrt(31.5) = 5.612...
        // 5.612...^2 = 31.5
        $this->assertEqualsWithDelta(31.5, $result, 0.0001);
    }
}
