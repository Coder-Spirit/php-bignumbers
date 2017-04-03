<?php

namespace Litipk\BigNumbers\Errors;
use LogicException;

class NotImplementedError extends LogicException implements BigNumbersError
{
    public function __construct(string $message = 'Not Implemented feature')
    {
        parent::__construct($message, 0, null);
    }
}
