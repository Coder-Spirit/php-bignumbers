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

    /**
     * @expectedException Litipk\Exceptions\InvalidArgumentTypeException
     * @expectedExceptionMessage $strVlue must be of type string.
     */
    public function testNoString()
    {
        Decimal::fromString(5.1);
    }

    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage $strValue must be a string that represents uniquely a float point number.
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
