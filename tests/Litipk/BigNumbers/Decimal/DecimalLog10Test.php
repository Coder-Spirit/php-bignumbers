<?php

use Litipk\BigNumbers\Decimal  as Decimal;

class DecimalLog10Test extends PHPUnit_Framework_TestCase
{
	public function testZero ()
	{
		$zero = Decimal::fromInteger(0);

		$zero_log = $zero->log10();

		$this->assertTrue($zero_log->isNegative());
		$this->assertTrue($zero_log->isInfinite());
	}

	public function testNegative ()
	{
		$none = Decimal::fromInteger(-1);

		$this->assertTrue($none->log10()->isNaN());
	}

	public function testBigNumbers ()
	{
		$bignumber = Decimal::fromString(bcpow('10', '2417'));
		$pow = Decimal::fromInteger(2417);

		$this->assertTrue($bignumber->log10()->equals($pow));
	}

	public function testLittleNumbers ()
	{
		$littlenumber = Decimal::fromString(bcpow('10', '-2417', 2417));
		$pow = Decimal::fromInteger(-2417);

		$this->assertTrue($littlenumber->log10()->equals($pow));		
	}

	public function testMediumNumbers ()
	{
		$seventyfive = Decimal::fromInteger(75);
		$fortynine = Decimal::fromInteger(49);

		$this->assertTrue($seventyfive->log10(5)->equals(Decimal::fromString('1.87506')));
		$this->assertTrue($fortynine->log10(7)->equals(Decimal::fromString('1.6901961')));
	}
}
