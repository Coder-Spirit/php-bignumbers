<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalFromStringTest extends PHPUnit_Framework_TestCase
{
	function testNegativeSimpleStringTest ()
	{
		$n1 = Decimal::fromString('-1');

		$this->assertTrue($n1->isNegative());
		$this->assertFalse($n1->isPositive());

		$this->assertEquals($n1->__toString(), '-1');
	}
}
