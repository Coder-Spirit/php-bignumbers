<?php

namespace Litipk\BigNumbers\Errors;

use DomainException;

/**
 * Class InfiniteInputError
 */
class InfiniteInputError extends DomainException implements BigNumbersError
{
    /**
     * InfiniteInputError constructor.
     * @param string $message
     */
    public function __construct(string $message = 'Infinite values are not supported')
    {
        parent::__construct($message, 0, null);
    }
}
