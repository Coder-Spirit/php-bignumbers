<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalFloorTest extends TestCase
{
    public function testIntegerFloor()
    {
        $this->assertTrue(Decimal::fromFloat(0.00)->floor()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.00)->floor()->equals(Decimal::fromInteger(0)));

        $this->assertTrue(Decimal::fromFloat(0.01)->floor()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.40)->floor()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.50)->floor()->isZero());

        $this->assertTrue(Decimal::fromFloat(0.01)->floor()->equals(Decimal::fromInteger(0)));
        $this->assertTrue(Decimal::fromFloat(0.40)->floor()->equals(Decimal::fromInteger(0)));
        $this->assertTrue(Decimal::fromFloat(0.50)->floor()->equals(Decimal::fromInteger(0)));

        $this->assertTrue(Decimal::fromFloat(1.01)->floor()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromFloat(1.40)->floor()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(Decimal::fromFloat(1.50)->floor()->equals(Decimal::fromInteger(1)));
    }

    public function testFloorWithDecimals()
    {
        $this->assertTrue(Decimal::fromString('3.45')->floor(1)->equals(Decimal::fromString('3.4')));
        $this->assertTrue(Decimal::fromString('3.44')->floor(1)->equals(Decimal::fromString('3.4')));
    }

    public function testNoUsefulFloor()
    {
        $this->assertTrue(Decimal::fromString('3.45')->floor(2)->equals(Decimal::fromString('3.45')));
        $this->assertTrue(Decimal::fromString('3.45')->floor(3)->equals(Decimal::fromString('3.45')));
    }

    public function testNegativeFloor()
    {
        $this->assertTrue(Decimal::fromFloat(-3.4)->floor()->equals(Decimal::fromFloat(-4.0)));
        $this->assertTrue(Decimal::fromFloat(-3.6)->floor()->equals(Decimal::fromFloat(-4.0)));
    }
}
