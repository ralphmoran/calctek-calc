<?php

namespace App\Exceptions;

use RuntimeException;

class DivisionByZeroException extends RuntimeException
{
    public function __construct(string $message = 'Division by zero is not allowed.')
    {
        parent::__construct($message);
    }
}
