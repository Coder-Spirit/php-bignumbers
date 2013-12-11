<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class InfiniteSubTest extends PHPUnit_Framework_TestCase
{
	public function testInfiniteSub ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$this->assertTrue($pInf->sub($pInf)->isNaN());
		$this->assertTrue($nInf->sub($nInf)->isNaN());

		$this->assertTrue($pInf->sub($nInf)->equals($pInf));
		$this->assertTrue($nInf->sub($pInf)->equals($nInf));		
	}

	public function testNaNSub ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();
		$nan  = NaN::getNaN();

		$this->assertTrue($pInf->sub($nan)->isNaN());
		$this->assertTrue($nInf->sub($nan)->isNaN());

		$this->assertTrue($nan->sub($pInf)->isNaN());
		$this->assertTrue($nan->sub($nInf)->isNaN());
	}
}
