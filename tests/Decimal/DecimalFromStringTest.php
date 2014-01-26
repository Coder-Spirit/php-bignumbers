<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalFromStringTest extends PHPUnit_Framework_TestCase
{
    public function testNegativeSimpleString()
    {
        $n1 = Decimal::fromString('-1');
        $n2 = Decimal::fromString('-1.0');

        $this->assertTrue($n1->isNegative());
        $this->assertTrue($n2->isNegative());

        $this->assertFalse($n1->isPositive());
        $this->assertFalse($n2->isPositive());

        $this->assertEquals($n1->__toString(), '-1');
        $this->assertEquals($n2->__toString(), '-1.0');
    }

    public function testExponentialNotationString_With_PositiveExponent_And_PositiveSign()
    {
        $this->assertTrue(
            Decimal::fromString('1e3')->equals(Decimal::fromInteger(1000))
        );

        $this->assertTrue(
            Decimal::fromString('1.5e3')->equals(Decimal::fromInteger(1500))
        );
    }

    public function testExponentialNotationString_With_PositiveExponent_And_NegativeSign()
    {
        $this->assertTrue(
            Decimal::fromString('-1e3')->equals(Decimal::fromInteger(-1000))
        );

        $this->assertTrue(
            Decimal::fromString('-1.5e3')->equals(Decimal::fromInteger(-1500))
        );
    }

    public function testExponentialNotationString_With_NegativeExponent_And_PositiveSign()
    {
        $this->assertTrue(
            Decimal::fromString('1e-3')->equals(Decimal::fromString('0.001'))
        );

        $this->assertTrue(
            Decimal::fromString('1.5e-3')->equals(Decimal::fromString('0.0015'))
        );
    }

    public function testExponentialNotationString_With_NegativeExponent_And_NegativeSign()
    {
        $this->assertTrue(
            Decimal::fromString('-1e-3')->equals(Decimal::fromString('-0.001'))
        );

        $this->assertTrue(
            Decimal::fromString('-1.5e-3')->equals(Decimal::fromString('-0.0015'))
        );
    }

    public function testNoString()
    {
        $catched = false;

        try {
            $n = Decimal::fromString(5.1);
        } catch (Exception $e) {
            $catched = true;
        }

        $this->assertTrue($catched);
    }

    public function testBadString()
    {
        $catched = false;

        try {
            $n = Decimal::fromString('hello world');
        } catch (Exception $e) {
            $catched = true;
        }

        $this->assertTrue($catched);
    }

    public function testWithScale()
    {
        $this->assertTrue(Decimal::fromString('7.426', 2)->equals(Decimal::fromString('7.43')));
    }
}
