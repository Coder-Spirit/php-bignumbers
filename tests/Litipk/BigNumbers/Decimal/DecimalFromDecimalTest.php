<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalFromDecimalTest extends PHPUnit_Framework_TestCase
{
	public function testBasicCase ()
	{
		$n1 = Decimal::fromString('3.45');

		$this->assertTrue(Decimal::fromDecimal($n1)->equals($n1));
		$this->assertTrue(Decimal::fromDecimal($n1, 2)->equals($n1));

		$this->assertTrue(Decimal::fromDecimal($n1, 1)->equals(Decimal::fromString('3.5')));
		$this->assertTrue(Decimal::fromDecimal($n1, 0)->equals(Decimal::fromString('3')));
	}
}