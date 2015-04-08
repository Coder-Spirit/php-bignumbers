<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\DecimalConstants as DecimalConstants;
use Litipk\Exceptions\NotImplementedException as NotImplementedException;


date_default_timezone_set('UTC');


class DecimalPowTest extends PHPUnit_Framework_TestCase
{
    public function testZeroPositive()
    {
        $zero = Decimal::fromInteger(0);
        $two = Decimal::fromInteger(2);

        $this->assertTrue($zero->pow($two)->isZero());
    }

    /**
     * TODO : Split tests, change idiom to take exception message into account.
     */
    public function testZeroNoPositive()
    {
        $zero = DecimalConstants::Zero();
        $nTwo = Decimal::fromInteger(-2);

        $catched = false;
        try {
            $zero->pow($nTwo);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $zero->pow($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testNoZeroZero()
    {
        $zero = DecimalConstants::Zero();
        $one = DecimalConstants::One();

        $nTwo = Decimal::fromInteger(-2);
        $pTwo = Decimal::fromInteger(2);

        $this->assertTrue($nTwo->pow($zero)->equals($one));
        $this->assertTrue($pTwo->pow($zero)->equals($one));
    }

    public function testLittleIntegerInteger()
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

    public function testLittlePositiveSquareRoot()
    {
        $half = Decimal::fromString('0.5');
        $two = Decimal::fromInteger(2);
        $three = Decimal::fromInteger(3);
        $four = Decimal::fromInteger(4);
        $nine = Decimal::fromInteger(9);

        $this->assertTrue($four->pow($half)->equals($two));
        $this->assertTrue($nine->pow($half)->equals($three));
    }

    public function testBigPositiveSquareRoot()
    {
        $half = Decimal::fromString('0.5');
        $bignum1 = Decimal::fromString('922337203685477580700');

        $this->assertTrue($bignum1->pow($half, 6)->equals($bignum1->sqrt(6)));
    }

    /**
     * TODO : Incorrect test! (The exception type should be changed, and the "idiom"!)
     */
    public function testNegativeSquareRoot()
    {
        $half = Decimal::fromString('0.5');
        $nThree = Decimal::fromInteger(-3);

        $catched = false;
        try {
            $nThree->pow($half);
        } catch (NotImplementedException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testPositiveWithNegativeExponent()
    {
        $pFive = Decimal::fromInteger(5);

        $this->assertTrue(
            $pFive->pow(Decimal::fromInteger(-1))->equals(Decimal::fromString("0.2")),
            "The answer must be 0.2, but was " . $pFive->pow(Decimal::fromInteger(-1))
        );
        $this->assertTrue(
            $pFive->pow(Decimal::fromInteger(-2))->equals(Decimal::fromString("0.04")),
            "The answer must be 0.04, but was " . $pFive->pow(Decimal::fromInteger(-2))
        );
        $this->assertTrue(
            $pFive->pow(Decimal::fromInteger(-3))->equals(Decimal::fromString("0.008")),
            "The answer must be 0.008, but was " . $pFive->pow(Decimal::fromInteger(-3))
        );
        $this->assertTrue(
            $pFive->pow(Decimal::fromInteger(-4))->equals(Decimal::fromString("0.0016")),
            "The answer must be 0.0016, but was " . $pFive->pow(Decimal::fromInteger(-4))
        );

        $this->assertTrue(
            $pFive->pow(Decimal::fromFloat(-4.5))->equals(Decimal::fromString("0.0007155417527999")),
            "The answer must be 0.0007155417527999, but was " . $pFive->pow(Decimal::fromFloat(-4.5))
        );
    }

    public function testNegativeWithPositiveExponent()
    {
        $nFive = Decimal::fromInteger(-5);

        $this->assertTrue($nFive->pow(DecimalConstants::One())->equals($nFive));
        $this->assertTrue($nFive->pow(Decimal::fromInteger(2))->equals(Decimal::fromInteger(25)));
        $this->assertTrue($nFive->pow(Decimal::fromInteger(3))->equals(Decimal::fromInteger(-125)));
    }

    public function testNegativeWithNegativeExponent()
    {
        $nFive = Decimal::fromInteger(-5);

        $this->assertTrue(
            $nFive->pow(Decimal::fromInteger(-1))->equals(Decimal::fromString("-0.2")),
            "The answer must be -0.2, but was " . $nFive->pow(Decimal::fromInteger(-1))
        );
        $this->assertTrue($nFive->pow(Decimal::fromInteger(-2))->equals(Decimal::fromString("0.04")));
        $this->assertTrue($nFive->pow(Decimal::fromInteger(-3))->equals(Decimal::fromString("-0.008")));
    }
}
