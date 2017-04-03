<?php

namespace Litipk\BigNumbers\Errors;
use DomainException;

class NaNInputError extends DomainException implements BigNumbersError
{
    public function __construct(string $message = 'NaN values are not supported')
    {
        parent::__construct($message, 0, null);
    }
}
