<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class InfiniteAddTest extends PHPUnit_Framework_TestCase
{
	public function testNaNAdd ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();
		$nan  = NaN::getNaN();

		$this->assertTrue($pInf->add($nan)->isNaN());
		$this->assertTrue($nInf->add($nan)->isNaN());

		$this->assertTrue($nan->add($pInf)->isNaN());
		$this->assertTrue($nan->add($nInf)->isNaN());
	}

	public function testInfiniteAdd ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$this->assertTrue($pInf->add($pInf)->equals($pInf));
		$this->assertTrue($nInf->add($nInf)->equals($nInf));

		$this->assertTrue($pInf->add($nInf)->isNaN());
		$this->assertTrue($nInf->add($pInf)->isNaN());
	}
}
