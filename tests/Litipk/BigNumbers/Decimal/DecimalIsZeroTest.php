<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalIsZeroTest extends PHPUnit_Framework_TestCase
{
	public function testBasicBehavior ()
	{
		$this->assertTrue(Decimal::fromInteger(0)->isZero());
		$this->assertTrue(Decimal::fromFloat(0.0)->isZero());
		$this->assertTrue(Decimal::fromString('0')->isZero());

		$this->assertFalse(Decimal::fromInteger(1)->isZero());
		$this->assertFalse(Decimal::fromFloat(1.0)->isZero());
		$this->assertFalse(Decimal::fromFloat(0.1)->isZero());
		$this->assertFalse(Decimal::fromString('1')->isZero());

		$this->assertFalse(Decimal::fromInteger(-1)->isZero());
		$this->assertFalse(Decimal::fromFloat(-1.0)->isZero());
		$this->assertFalse(Decimal::fromFloat(-0.1)->isZero());
		$this->assertFalse(Decimal::fromString('-1')->isZero());
	}
}