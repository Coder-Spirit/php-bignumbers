<?php

use Litipk\BigNumbers\NumConstants as NumConstants;
use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class NumConstantsTest extends PHPUnit_Framework_TestCase
{
    public function testFiniteAbs()
    {
        $this->assertTrue(NumConstants::PI()->equals(
            Decimal::fromString("3.14159265358979323846264338327950")
        ));

        $this->assertTrue(NumConstants::E()->equals(
            Decimal::fromString("2.71828182845904523536028747135266")
        ));

        $this->assertTrue(NumConstants::EulerMascheroni()->equals(
            Decimal::fromString("0.57721566490153286060651209008240")
        ));

        $this->assertTrue(NumConstants::GoldenRatio()->equals(
            Decimal::fromString("1.61803398874989484820458683436564")
        ));

        $this->assertTrue(NumConstants::LightSpeed()->equals(
            Decimal::fromInteger(299792458)
        ));
    }
}
