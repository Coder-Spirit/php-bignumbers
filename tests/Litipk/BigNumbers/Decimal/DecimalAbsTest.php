<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalAbsTest extends PHPUnit_Framework_TestCase
{
	public function testBaseCase ()
	{
		$this->assertTrue(Decimal::fromInteger(0)->abs()->equals(Decimal::fromInteger(0)));
		$this->assertTrue(Decimal::fromInteger(5)->abs()->equals(Decimal::fromInteger(5)));
		$this->assertTrue(Decimal::fromInteger(-5)->abs()->equals(Decimal::fromInteger(5)));
	}
}
