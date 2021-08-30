<?php

namespace Suber\Exceptions;

use Exception;
use Throwable;

class NaturalNumberException extends Exception
{
    public function __construct(string $argument, string $message = '', int $code = 0, ?Throwable $previous = null)
    {
        $message = "$argument must be a natural number.";
        parent::__construct($message, $code, $previous);
    }
}


