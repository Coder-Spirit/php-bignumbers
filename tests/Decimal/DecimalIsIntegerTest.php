<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalIsIntegerTest extends PHPUnit_Framework_TestCase
{
    public function testIntegers()
    {
        $this->assertTrue(Decimal::fromInteger(-200)->isInteger());
        $this->assertTrue(Decimal::fromInteger(-2)->isInteger());
        $this->assertTrue(Decimal::fromInteger(-1)->isInteger());
        $this->assertTrue(Decimal::fromInteger(0)->isInteger());
        $this->assertTrue(Decimal::fromInteger(1)->isInteger());
        $this->assertTrue(Decimal::fromInteger(2)->isInteger());
        $this->assertTrue(Decimal::fromInteger(200)->isInteger());

        $this->assertTrue(Decimal::fromString("-200")->isInteger());
        $this->assertTrue(Decimal::fromString("-2")->isInteger());
        $this->assertTrue(Decimal::fromString("-1")->isInteger());
        $this->assertTrue(Decimal::fromString("0")->isInteger());
        $this->assertTrue(Decimal::fromString("1")->isInteger());
        $this->assertTrue(Decimal::fromString("2")->isInteger());
        $this->assertTrue(Decimal::fromString("200")->isInteger());

        $this->assertTrue(Decimal::fromString("-200.000")->isInteger());
        $this->assertTrue(Decimal::fromString("-2.000")->isInteger());
        $this->assertTrue(Decimal::fromString("-1.000")->isInteger());
        $this->assertTrue(Decimal::fromString("0.000")->isInteger());
        $this->assertTrue(Decimal::fromString("1.000")->isInteger());
        $this->assertTrue(Decimal::fromString("2.000")->isInteger());
        $this->assertTrue(Decimal::fromString("200.000")->isInteger());

        $this->assertTrue(Decimal::fromFloat(-200.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(-2.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(-1.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(0.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(1.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(2.0)->isInteger());
        $this->assertTrue(Decimal::fromFloat(200.0)->isInteger());
    }

    public function testNotIntegers()
    {
        $this->assertFalse(Decimal::fromString("-200.001")->isInteger());
        $this->assertFalse(Decimal::fromString("-2.001")->isInteger());
        $this->assertFalse(Decimal::fromString("-1.001")->isInteger());
        $this->assertFalse(Decimal::fromString("0.001")->isInteger());
        $this->assertFalse(Decimal::fromString("1.001")->isInteger());
        $this->assertFalse(Decimal::fromString("2.001")->isInteger());
        $this->assertFalse(Decimal::fromString("200.001")->isInteger());

        $this->assertFalse(Decimal::fromFloat(-200.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(-2.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(-1.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(0.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(1.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(2.001)->isInteger());
        $this->assertFalse(Decimal::fromFloat(200.001)->isInteger());
    }
}
