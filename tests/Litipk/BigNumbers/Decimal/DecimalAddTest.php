<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalAddTest extends PHPUnit_Framework_TestCase
{
	public function testZeroMul()
	{
		$z = Decimal::fromInteger(0);
		$n = Decimal::fromInteger(5);

		$r1 = $z->mul($n);
		$r2 = $n->mul($z);

		$this->assertTrue($r1->equals($r2));
		$this->assertTrue($r2->equals($r1));

		$this->assertTrue($r1->isZero());
		$this->assertTrue($r2->isZero());
	}
}
