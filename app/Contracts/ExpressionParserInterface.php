<?php

namespace App\Contracts;

interface ExpressionParserInterface
{
    /**
     * Parse and evaluate a mathematical expression.
     *
     * @throws \App\Exceptions\InvalidExpressionException
     * @throws \App\Exceptions\DivisionByZeroException
     */
    public function parse(string $expression): float;
}
