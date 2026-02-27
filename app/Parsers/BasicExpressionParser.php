<?php

namespace App\Parsers;

use App\Contracts\ExpressionParserInterface;
use App\Exceptions\DivisionByZeroException;
use App\Exceptions\InvalidExpressionException;
use MathParser\Interpreting\Evaluator;
use MathParser\StdMathParser;

class BasicExpressionParser implements ExpressionParserInterface
{
    public function parse(string $expression): float
    {
        try {
            $parser = new StdMathParser();
            $ast = $parser->parse($expression);
            $evaluator = new Evaluator();
            $result = $ast->accept($evaluator);

            return round((float) $result, 6);
        } catch (\MathParser\Exceptions\DivisionByZeroException $e) {
            throw new DivisionByZeroException();
        } catch (\Throwable $e) {
            throw new InvalidExpressionException();
        }
    }
}
