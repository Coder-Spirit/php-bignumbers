<?php

use Litipk\BigNumbers\Decimal  as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN      as NaN;

class DecimalFromFloatTest extends PHPUnit_Framework_TestCase
{
	public function testInfinites ()
	{
		$pInf = Decimal::fromFloat(INF);
		$nInf = Decimal::fromFloat(-INF);

		$this->assertTrue($pInf->isInfinite());
		$this->assertTrue($nInf->isInfinite());

		$this->assertTrue($pInf->isPositive());
		$this->assertTrue($nInf->isNegative());
	}
}
