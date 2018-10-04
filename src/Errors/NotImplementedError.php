<?php

namespace Litipk\BigNumbers\Errors;

use LogicException;

/**
 * Class NotImplementedError
 */
class NotImplementedError extends LogicException implements BigNumbersError
{
    /**
     * NotImplementedError constructor.
     * @param string $message
     */
    public function __construct(string $message = 'Not Implemented feature')
    {
        parent::__construct($message, 0, null);
    }
}
