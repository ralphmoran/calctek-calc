<?php

namespace App\Services;

use App\Contracts\ExpressionParserInterface;

class CalculatorService
{
    public function __construct(
        private readonly ExpressionParserInterface $parser
    ) {}

    public function evaluate(string $expression): float
    {
        return $this->parser->parse($expression);
    }
}
