<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalAddTest extends PHPUnit_Framework_TestCase
{
	public function testZeroAdd ()
	{
		$z = Decimal::fromInteger(0);
		$n = Decimal::fromInteger(5);

		$this->assertTrue($z->add($n)->equals($n));
		$this->assertTrue($n->add($z)->equals($n));
	}

	public function testNaNAdd ()
	{
		$nan = NaN::getNaN();
		$one = Decimal::fromInteger(1);

		$this->assertTrue($one->add($nan)->isNaN());
		$this->assertTrue($nan->add($one)->isNaN());
	}
}
