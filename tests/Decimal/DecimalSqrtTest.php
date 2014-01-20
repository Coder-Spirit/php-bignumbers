<?php

use Litipk\BigNumbers\Decimal  as Decimal;

class DecimalSqrtTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerSqrt()
    {
        $this->assertTrue(Decimal::fromInteger(0)->sqrt()->equals(Decimal::fromInteger(0)));
        $this->assertTrue(Decimal::fromInteger(1)->sqrt()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromInteger(4)->sqrt()->equals(Decimal::fromInteger(2)));
        $this->assertTrue(Decimal::fromInteger(9)->sqrt()->equals(Decimal::fromInteger(3)));
        $this->assertTrue(Decimal::fromInteger(16)->sqrt()->equals(Decimal::fromInteger(4)));
        $this->assertTrue(Decimal::fromInteger(25)->sqrt()->equals(Decimal::fromInteger(5)));
    }

    public function testNearZeroSqrt()
    {
        $this->assertTrue(Decimal::fromString('0.01')->sqrt()->equals(Decimal::fromString('0.1')));
        $this->assertTrue(Decimal::fromString('0.0001')->sqrt()->equals(Decimal::fromString('0.01')));
    }

    public function testNegativeSqrt()
    {
        $this->assertTrue(Decimal::fromInteger(-1)->sqrt()->isNaN());
    }
}
