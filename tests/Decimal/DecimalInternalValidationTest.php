<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalInternalValidationTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $value must be a non null number
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
    public function testConstructorNotIntegerScaleValidation()
    {
        Decimal::fromString("25", "hola mundo");
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
