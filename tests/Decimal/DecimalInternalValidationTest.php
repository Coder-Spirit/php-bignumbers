<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalInternalValidationTest extends TestCase
{
    /**
     * @expectedException \TypeError
     */
    public function testConstructorNullValueValidation()
    {
        Decimal::fromInteger(null);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $scale must be a positive integer
     */
    public function testConstructorNegativeScaleValidation()
    {
        Decimal::fromString("25", -15);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $scale must be a positive integer
     */
    public function testOperatorNegativeScaleValidation()
    {
        $one = Decimal::fromInteger(1);

        $one->mul($one, -1);
    }
}
