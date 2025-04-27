<?php

namespace App\Shared\Exceptions;

use Exception;
use Throwable;

class PDOQueryException extends Exception
{
    // TODO ver que hacer con esto
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}