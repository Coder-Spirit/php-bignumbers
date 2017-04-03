<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalFromStringTest extends TestCase
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

    public function testExponentialNotationString_With_PositiveExponent_And_Positive()
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

    public function testExponentialNotationString_With_NegativeExponent_And_Positive()
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

    public function testSimpleNotation_With_PositiveSign()
    {
        $this->assertTrue(
            Decimal::fromString('+34')->equals(Decimal::fromString('34'))
        );

        $this->assertTrue(
            Decimal::fromString('+00034')->equals(Decimal::fromString('34'))
        );
    }

    public function testExponentialNotation_With_PositiveSign()
    {
        $this->assertTrue(
            Decimal::fromString('+1e3')->equals(Decimal::fromString('1e3'))
        );

        $this->assertTrue(
            Decimal::fromString('+0001e3')->equals(Decimal::fromString('1e3'))
        );
    }

    public function testExponentialNotation_With_LeadingZero_in_ExponentPart()
    {
        $this->assertTrue(
            Decimal::fromString('1.048576E+06')->equals(Decimal::fromString('1.048576e6'))
        );
    }

    public function testExponentialNotation_With_ZeroExponent()
    {
        $this->assertTrue(
            Decimal::fromString('3.14E+00')->equals(Decimal::fromString('3.14'))
        );
    }

    /**
     * @expectedException \Litipk\BigNumbers\Errors\NaNInputError
     * @expectedExceptionMessage strValue must be a number
     */
    public function testBadString()
    {
        Decimal::fromString('hello world');
    }

    public function testWithScale()
    {
        $this->assertTrue(Decimal::fromString('7.426', 2)->equals(Decimal::fromString('7.43')));
    }
}
