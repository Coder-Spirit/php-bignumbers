<?php

use Litipk\BigNumbers\Infinite as Infinite;

class InfiniteCompTest extends PHPUnit_Framework_TestCase
{
	public function testSelfComp ()
	{
		$pInf = Infinite::getPositiveInfinite();
		$nInf = Infinite::getNegativeInfinite();

		$this->assertTrue($pInf->comp($pInf) === 0);
		$this->assertTrue($nInf->comp($nInf) === 0);

		$this->assertTrue($pInf->comp($nInf) === 1);
		$this->assertTrue($nInf->comp($pInf) === -1);
	}
}
