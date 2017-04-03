<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalSqrtTest extends TestCase
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

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Decimal can't handle square roots of negative numbers (it's only for real numbers).
     */
    public function testFiniteNegativeSqrt()
    {
        Decimal::fromInteger(-1)->sqrt();
    }
}
