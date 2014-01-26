<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalDivTest extends PHPUnit_Framework_TestCase
{
    public function testZeroFiniteDiv()
    {
        $one  = Decimal::fromInteger(1);
        $zero = Decimal::fromInteger(0);

        $catched = false;
        try {
            $one->div($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $this->assertTrue($zero->div($one)->equals($zero));
    }

    public function testZeroInfiniteDiv()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();
        $zero = Decimal::fromInteger(0);

        $catched = false;
        try {
            $pInf->div($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->div($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testOneDiv()
    {
        $one = Decimal::fromInteger(1);
        $two = Decimal::fromInteger(2);

        $this->assertTrue($two->div($one)->equals($two));
    }

    public function testFiniteInfiniteDiv()
    {
        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->div($pTen)->equals($pInf));
        $this->assertTrue($pInf->div($nTen)->equals($nInf));

        $this->assertTrue($nInf->div($pTen)->equals($nInf));
        $this->assertTrue($nInf->div($nTen)->equals($pInf));

        $this->assertTrue($pTen->div($pInf)->isZero());
        $this->assertTrue($nTen->div($pInf)->isZero());

        $this->assertTrue($pTen->div($nInf)->isZero());
        $this->assertTrue($nTen->div($nInf)->isZero());
    }

    public function testInfiniteInfiniteDiv()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $catched = false;
        try {
            $pInf->div($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $pInf->div($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->div($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->div($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testBasicDiv()
    {
        $one   = Decimal::fromInteger(1);
        $two   = Decimal::fromInteger(2);
        $four  = Decimal::fromInteger(4);
        $eight = Decimal::fromInteger(8);

        // Integer exact division
        $this->assertTrue($eight->div($two)->equals($four));
        $this->assertTrue($eight->div($four)->equals($two));

        // Arbitrary precision division
        $this->assertTrue($one->div($eight, 0)->equals(Decimal::fromString('0')));
        $this->assertTrue($one->div($eight, 1)->equals(Decimal::fromString('0.1')));
        $this->assertTrue($one->div($eight, 2)->equals(Decimal::fromString('0.13')));
        $this->assertTrue($one->div($eight, 3)->equals(Decimal::fromString('0.125')));
    }
}
