<?php

use Litipk\BigNumbers\Decimal  as Decimal;

class DecimalPowTest extends PHPUnit_Framework_TestCase
{
	public function testZeroPositive ()
	{
		$zero = Decimal::fromInteger(0);
		$two = Decimal::fromInteger(2);

		$this->assertTrue($zero->pow($two)->isZero());
	}

	public function testZeroNoPositive ()
	{
		$zero = Decimal::fromInteger(0);
		$nTwo = Decimal::fromInteger(-2);

		$this->assertTrue($zero->pow($nTwo)->isNaN());
		$this->assertTrue($zero->pow($zero)->isNaN());
	}

	public function testNoZeroZero ()
	{
		$zero = Decimal::fromInteger(0);
		$one = Decimal::fromInteger(1);

		$nTwo = Decimal::fromInteger(-2);
		$pTwo = Decimal::fromInteger(2);

		$this->assertTrue($nTwo->pow($zero)->equals($one));
		$this->assertTrue($pTwo->pow($zero)->equals($one));
	}

	public function testLittleIntegerInteger ()
	{
		$two = Decimal::fromInteger(2);
		$three = Decimal::fromInteger(3);
		$four = Decimal::fromInteger(4);
		$eight = Decimal::fromInteger(8);
		$nine = Decimal::fromInteger(9);
		$twentyseven = Decimal::fromInteger(27);

		$this->assertTrue($two->pow($two)->equals($four));
		$this->assertTrue($two->pow($three)->equals($eight));

		$this->assertTrue($three->pow($two)->equals($nine));
		$this->assertTrue($three->pow($three)->equals($twentyseven)); 
	}

	public function testLittlePositiveSquareRoot ()
	{
		$half = Decimal::fromString('0.5');
		$two = Decimal::fromInteger(2);
		$three = Decimal::fromInteger(3);
		$four = Decimal::fromInteger(4);
		$nine = Decimal::fromInteger(9);

		$this->assertTrue($four->pow($half)->equals($two));
		$this->assertTrue($nine->pow($half)->equals($three));
	}

	public function testBigPositiveSquareRoot ()
	{
		$half = Decimal::fromString('0.5');
		$bignum1 = Decimal::fromString('922337203685477580700');

		$this->assertTrue($bignum1->pow($half, 6)->equals($bignum1->sqrt(6)));
	}

	public function testNegativeSquareRoot ()
	{
		$half = Decimal::fromString('0.5');
		$nThree = Decimal::fromInteger(-3);

		$this->assertTrue($nThree->pow($half)->isNaN());
	}
}
