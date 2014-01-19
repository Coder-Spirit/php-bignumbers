<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class InfiniteMulTest extends PHPUnit_Framework_TestCase
{
	public function testZeroMul ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();
		$zero = Decimal::fromInteger(0);

		$this->assertTrue($pInf->mul($zero)->isNaN());
		$this->assertTrue($nInf->mul($zero)->isNaN());

		$this->assertTrue($zero->mul($pInf)->isNaN());
		$this->assertTrue($zero->mul($nInf)->isNaN());
	}

	public function testNaNMul ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();
		$nan  = NaN::getNaN();

		$this->assertTrue($pInf->mul($nan)->isNaN());
		$this->assertTrue($nInf->mul($nan)->isNaN());

		$this->assertTrue($nan->mul($pInf)->isNaN());
		$this->assertTrue($nan->mul($nInf)->isNaN());
	}
}
