<?php

use Litipk\BigNumbers\NaN as NaN;

class NaNTest extends PHPUnit_Framework_TestCase
{
	public function testIsZero ()
	{
		$this->assertTrue(Nan::getNaN()->isZero() === false);
	}

	public function testIsPositive ()
	{
		$this->assertTrue(Nan::getNaN()->isPositive() === false);
	}

	public function testIsNegative ()
	{
		$this->assertTrue(Nan::getNaN()->isNegative() === false);
	}

	public function testIsInfinite ()
	{
		$this->assertTrue(Nan::getNaN()->isInfinite() === false);
	}

	public function testEquals ()
	{
		$this->assertFalse(NaN::getNaN()->equals(NaN::getNaN()));
	}
}
