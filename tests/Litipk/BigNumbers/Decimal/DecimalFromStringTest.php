<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalFromStringTest extends PHPUnit_Framework_TestCase
{
	function testNegativeSimpleString ()
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

	function testExponentialNotationString_With_PositiveExponent_And_PositiveSign ()
	{
		$this->assertTrue(
			Decimal::fromString('1e3')->equals(Decimal::fromInteger(1000))
		);

		$this->assertTrue(
			Decimal::fromString('1.5e3')->equals(Decimal::fromInteger(1500))
		);
	}

	function testExponentialNotationString_With_PositiveExponent_And_NegativeSign ()
	{
		$this->assertTrue(
			Decimal::fromString('-1e3')->equals(Decimal::fromInteger(-1000))
		);

		$this->assertTrue(
			Decimal::fromString('-1.5e3')->equals(Decimal::fromInteger(-1500))
		);
	}

	function testExponentialNotationString_With_NegativeExponent_And_PositiveSign ()
	{
		$this->assertTrue(
			Decimal::fromString('1e-3')->equals(Decimal::fromString('0.001'))
		);

		$this->assertTrue(
			Decimal::fromString('1.5e-3')->equals(Decimal::fromString('0.0015'))
		);
	}

	function testExponentialNotationString_With_NegativeExponent_And_NegativeSign ()
	{
		$this->assertTrue(
			Decimal::fromString('-1e-3')->equals(Decimal::fromString('-0.001'))
		);

		$this->assertTrue(
			Decimal::fromString('-1.5e-3')->equals(Decimal::fromString('-0.0015'))
		);
	}
}
