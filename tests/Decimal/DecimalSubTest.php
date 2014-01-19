<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalSubTest extends PHPUnit_Framework_TestCase
{
	public function testZeroSub ()
	{
		$one  = Decimal::fromInteger(1);
		$zero = Decimal::fromInteger(0);

		$this->assertTrue($one->sub($zero)->equals($one));

		$this->assertTrue($zero->sub($one)->equals($one->additiveInverse()));
		$this->assertTrue($zero->sub($one)->equals(Decimal::fromInteger(-1)));
		$this->assertTrue($zero->sub($one)->isNegative());
	}

	public function testBasicCase ()
	{
		$one = Decimal::fromInteger(1);
		$two = Decimal::fromInteger(2);

		$this->assertTrue($one->sub($two)->equals(Decimal::fromInteger(-1)));
		$this->assertTrue($two->sub($one)->equals($one));

		$this->assertTrue($one->sub($one)->isZero());
	}

	public function testNaNSub ()
	{
		$nan = NaN::getNaN();
		$one = Decimal::fromInteger(1);

		$this->assertTrue($one->sub($nan)->isNaN());
		$this->assertTrue($nan->sub($one)->isNaN());
	}

	public function testInfiniteSub ()
	{
		$one = Decimal::fromInteger(1);
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$this->assertTrue($one->sub($pInf)->equals($nInf));
		$this->assertTrue($one->sub($nInf)->equals($pInf));

		$this->assertTrue($pInf->sub($one)->equals($pInf));
		$this->assertTrue($nInf->sub($one)->equals($nInf));
	}
}
