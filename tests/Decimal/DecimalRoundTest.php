<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalRoundTest extends TestCase
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

    public function testNegativeRoundWithDecimals()
    {
        $this->assertTrue(Decimal::fromString('-5.59059956723478932512')->round(3)->equals(Decimal::fromString('-5.591')));
        $this->assertTrue(Decimal::fromString('-5.59059956723478932512')->round(4)->equals(Decimal::fromString('-5.5906')));
        $this->assertTrue(Decimal::fromString('-5.59059956723478932512')->round(5)->equals(Decimal::fromString('-5.59060')));
        $this->assertTrue(Decimal::fromString('-5.59059956723478932512')->round(6)->equals(Decimal::fromString('-5.590600')));
    }

    public function testNoUsefulRound()
    {
        $this->assertTrue(Decimal::fromString('3.45')->round(2)->equals(Decimal::fromString('3.45')));
        $this->assertTrue(Decimal::fromString('3.45')->round(3)->equals(Decimal::fromString('3.45')));
    }
}
