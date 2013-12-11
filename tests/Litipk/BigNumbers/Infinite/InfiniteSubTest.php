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

	public function testDecimalSub ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$pTen = Decimal::fromInteger(10);
		$nTen = Decimal::fromInteger(-10);

		$this->assertTrue($pInf->sub($pTen)->equals($pInf));
		$this->assertTrue($nInf->sub($pTen)->equals($nInf));

		$this->assertTrue($pInf->sub($nTen)->equals($pInf));
		$this->assertTrue($nInf->sub($nTen)->equals($nInf));

		$this->assertTrue($pTen->sub($pInf)->equals($nInf));
		$this->assertTrue($pTen->sub($nInf)->equals($pInf));

		$this->assertTrue($nTen->sub($pInf)->equals($nInf));
		$this->assertTrue($nTen->sub($nInf)->equals($pInf));
	}
}
