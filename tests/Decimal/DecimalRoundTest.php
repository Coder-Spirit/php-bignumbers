<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalRoundTest extends PHPUnit_Framework_TestCase
{
    public function testIntegerRound()
    {
        $this->assertTrue(Decimal::fromFloat(0.4)->round()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.4)->round()->equals(Decimal::fromInteger(0)));

        $this->assertFalse(Decimal::fromFloat(0.5)->round()->isZero());
        $this->assertTrue(Decimal::fromFloat(0.5)->round()->equals(Decimal::fromInteger(1)));
    }

    public function testRoundWithDecimals()
    {
        $this->assertTrue(Decimal::fromString('3.45')->round(1)->equals(Decimal::fromString('3.5')));
        $this->assertTrue(Decimal::fromString('3.44')->round(1)->equals(Decimal::fromString('3.4')));
    }

    public function testNoUsefulRound()
    {
        $this->assertTrue(Decimal::fromString('3.45')->round(2)->equals(Decimal::fromString('3.45')));
        $this->assertTrue(Decimal::fromString('3.45')->round(3)->equals(Decimal::fromString('3.45')));
    }
}
