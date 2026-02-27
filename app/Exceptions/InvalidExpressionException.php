<?php

namespace App\Exceptions;

use RuntimeException;

class InvalidExpressionException extends RuntimeException
{
    public function __construct(string $message = 'The expression could not be evaluated.')
    {
        parent::__construct($message);
    }
}
