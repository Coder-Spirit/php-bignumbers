<?php

namespace Litipk\BigNumbers\Errors;

use DomainException;

/**
 * Class NaNInputError
 */
class NaNInputError extends DomainException implements BigNumbersError
{
    /**
     * NaNInputError constructor.
     * @param string $message
     */
    public function __construct(string $message = 'NaN values are not supported')
    {
        parent::__construct($message, 0, null);
    }
}
