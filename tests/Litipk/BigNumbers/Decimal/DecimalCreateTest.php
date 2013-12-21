<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\Exceptions\InvalidArgumentTypeException;

// Empty class used for testing
class A {}

class DecimalCreateTest extends PHPUnit_Framework_TestCase
{
	public function testCreateWithInvalidType ()
	{
		$thrown = false;
		try {
			$d = Decimal::create(array(25, 67));
		} catch (InvalidArgumentTypeException $e) {
			$thrown = true;
		}
		$this->assertTrue($thrown);

		$thrown = false;
		try {
			$d = Decimal::create(new A());
		} catch (InvalidArgumentTypeException $e) {
			$thrown = true;
		}
		$this->assertTrue($thrown);
	}

	public function testCreateFromInteger ()
	{
		$this->assertTrue(Decimal::create(-35)->equals(Decimal::fromInteger(-35)));
		$this->assertTrue(Decimal::create(0)->equals(Decimal::fromInteger(0)));
		$this->assertTrue(Decimal::create(35)->equals(Decimal::fromInteger(35)));
	}

	public function testCreateFromFloat ()
	{
		$this->assertTrue(Decimal::create(-35.125)->equals(Decimal::fromFloat(-35.125)));
		$this->assertTrue(Decimal::create(0.0)->equals(Decimal::fromFloat(0.0)));
		$this->assertTrue(Decimal::create(35.125)->equals(Decimal::fromFloat(35.125)));
	}

	public function testCreateFromString ()
	{
		$this->assertTrue(Decimal::create('-35.125')->equals(Decimal::fromString('-35.125')));
		$this->assertTrue(Decimal::create('0.0')->equals(Decimal::fromString('0.0')));
		$this->assertTrue(Decimal::create('35.125')->equals(Decimal::fromString('35.125')));
	}

	public function testCreateFromDecimal ()
	{
		$this->assertTrue(Decimal::create(Decimal::fromString('345.76'), 1)->equals(Decimal::fromString('345.8')));
		$this->assertTrue(Decimal::create(Decimal::fromString('345.76'), 2)->equals(Decimal::fromString('345.76')));
	}
}