<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalIsZeroTest extends TestCase
{
    public function testZeros()
    {
        $this->assertTrue(Decimal::fromInteger(0)->isZero());
        $this->assertTrue(Decimal::fromFloat(0.0)->isZero());
        $this->assertTrue(Decimal::fromString('0')->isZero());
    }

    public function testPositiveNumbers()
    {
        $this->assertFalse(Decimal::fromInteger(1)->isZero());
        $this->assertFalse(Decimal::fromFloat(1.0)->isZero());
        $this->assertFalse(Decimal::fromFloat(0.1)->isZero());
        $this->assertFalse(Decimal::fromString('1')->isZero());
    }

    public function testNegativeNumbers()
    {
        $this->assertFalse(Decimal::fromInteger(-1)->isZero());
        $this->assertFalse(Decimal::fromFloat(-1.0)->isZero());
        $this->assertFalse(Decimal::fromFloat(-0.1)->isZero());
        $this->assertFalse(Decimal::fromString('-1')->isZero());
    }
}
