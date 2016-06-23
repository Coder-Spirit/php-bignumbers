<?php

use Litipk\BigNumbers\DecimalConstants as DecimalConstants;
use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalConstantsTest extends PHPUnit_Framework_TestCase
{
    public function testFiniteAbs()
    {
        $this->assertTrue(DecimalConstants::pi()->equals(
            Decimal::fromString("3.14159265358979323846264338327950")
        ));

        $this->assertTrue(DecimalConstants::eulerMascheroni()->equals(
            Decimal::fromString("0.57721566490153286060651209008240")
        ));

        $this->assertTrue(DecimalConstants::goldenRatio()->equals(
            Decimal::fromString("1.61803398874989484820458683436564")
        ));

        $this->assertTrue(DecimalConstants::silverRatio()->equals(
            Decimal::fromString("2.41421356237309504880168872420970")
        ));

        $this->assertTrue(DecimalConstants::lightSpeed()->equals(
            Decimal::fromInteger(299792458)
        ));
    }

    public function testE()
    {
        $this->assertTrue(DecimalConstants::e()->equals(
            Decimal::fromString("2.71828182845904523536028747135266")
        ));

        $this->assertTrue(DecimalConstants::e(32)->equals(
            Decimal::fromString("2.71828182845904523536028747135266")
        ));

        $this->assertTrue(DecimalConstants::e(16)->equals(
            Decimal::fromString("2.7182818284590452")
        ));
    }

    /**
     * @expectedException Litipk\Exceptions\InvalidArgumentTypeException
     */
    public function testIncorrectTypedParamsOnE()
    {
        DecimalConstants::e("hello");
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $scale must be positive.
     */
    public function testNegativeParamsOnE()
    {
        DecimalConstants::e(-3);
    }
}
