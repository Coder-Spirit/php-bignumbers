<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalFromStringTest extends PHPUnit_Framework_TestCase
{
	function testNegativeSimpleStringTest ()
	{
		$n1 = Decimal::fromString('-1');
		$n2 = Decimal::fromString('-1.0');

		$this->assertTrue($n1->isNegative());
		$this->assertTrue($n2->isNegative());

		$this->assertFalse($n1->isPositive());
		$this->assertFalse($n2->isPositive());

		$this->assertEquals($n1->__toString(), '-1');
		$this->assertEquals($n2->__toString(), '-1.0');
	}
}
