<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalCeilTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerCeil()
    {
        $this->assertTrue(Decimal::fromFloat(0.00)->ceil()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.00)->ceil()->equals(Decimal::fromInteger(0)));

        $this->assertFalse(Decimal::fromFloat(0.01)->ceil()->isZero());
        $this->assertFalse(Decimal::fromFloat(0.40)->ceil()->isZero());
        $this->assertFalse(Decimal::fromFloat(0.50)->ceil()->isZero());

        $this->assertTrue(Decimal::fromFloat(0.01)->ceil()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromFloat(0.40)->ceil()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromFloat(0.50)->ceil()->equals(Decimal::fromInteger(1)));
    }

    public function testCeilWithDecimals()
    {
        $this->assertTrue(Decimal::fromString('3.45')->ceil(1)->equals(Decimal::fromString('3.5')));
        $this->assertTrue(Decimal::fromString('3.44')->ceil(1)->equals(Decimal::fromString('3.5')));
    }

    public function testNoUsefulCeil()
    {
        $this->assertTrue(Decimal::fromString('3.45')->ceil(2)->equals(Decimal::fromString('3.45')));
        $this->assertTrue(Decimal::fromString('3.45')->ceil(3)->equals(Decimal::fromString('3.45')));
    }

    public function testNegativeCeil()
    {
        $this->assertTrue(Decimal::fromFloat(-3.4)->ceil()->equals(Decimal::fromFloat(-3.0)));
        $this->assertTrue(Decimal::fromFloat(-3.6)->ceil()->equals(Decimal::fromFloat(-3.0)));
    }
}
