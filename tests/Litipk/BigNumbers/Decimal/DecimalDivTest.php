<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalDivTest extends PHPUnit_Framework_TestCase
{
	public function testZeroDiv ()
	{
		$one  = Decimal::fromInteger(1);
		$zero = Decimal::fromInteger(0);

		$this->assertTrue($one->div($zero)->isNaN());
		$this->assertTrue($zero->div($one)->equals($zero));
	}

	public function testOneDiv ()
	{
		$one = Decimal::fromInteger(1);
		$two = Decimal::fromInteger(2);

		$this->assertTrue($two->div($one)->equals($two));
	}

	public function testInfiniteDiv ()
	{
		$one  = Decimal::fromInteger(1);
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$this->assertTrue($one->div($pInf)->isZero());
		$this->assertTrue($one->div($nInf)->isZero());
	}

	public function testNaNDiv ()
	{
		$one = Decimal::fromInteger(1);
		$nan = NaN::getNaN();

		$this->assertTrue($one->div($nan)->isNaN());
		$this->assertTrue($nan->div($one)->isNaN());
	}

	public function testBasicDiv ()
	{
		$one   = Decimal::fromInteger(1);
		$eight = Decimal::fromInteger(8);

		$this->assertTrue($one->div($eight)->equals(Decimal::fromFloat(0.125)));
	}
}
