<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalSubTest extends PHPUnit_Framework_TestCase
{
    public function testZeroSub()
    {
        $one  = Decimal::fromInteger(1);
        $zero = Decimal::fromInteger(0);

        $this->assertTrue($one->sub($zero)->equals($one));

        $this->assertTrue($zero->sub($one)->equals($one->additiveInverse()));
        $this->assertTrue($zero->sub($one)->equals(Decimal::fromInteger(-1)));
        $this->assertTrue($zero->sub($one)->isNegative());
    }

    public function testBasicCase()
    {
        $one = Decimal::fromInteger(1);
        $two = Decimal::fromInteger(2);

        $this->assertTrue($one->sub($two)->equals(Decimal::fromInteger(-1)));
        $this->assertTrue($two->sub($one)->equals($one));

        $this->assertTrue($one->sub($one)->isZero());
    }

    public function testFiniteInfiniteSub()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $this->assertTrue($pInf->sub($pTen)->equals($pInf));
        $this->assertTrue($nInf->sub($pTen)->equals($nInf));

        $this->assertTrue($pInf->sub($nTen)->equals($pInf));
        $this->assertTrue($nInf->sub($nTen)->equals($nInf));

        $this->assertTrue($pTen->sub($pInf)->equals($nInf));
        $this->assertTrue($pTen->sub($nInf)->equals($pInf));

        $this->assertTrue($nTen->sub($pInf)->equals($nInf));
        $this->assertTrue($nTen->sub($nInf)->equals($pInf));
    }

    public function testInfiniteInfiniteSub()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $catched = false;
        try {
            $pInf->sub($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->sub($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $this->assertTrue($pInf->sub($nInf)->equals($pInf));
        $this->assertTrue($nInf->sub($pInf)->equals($nInf));
    }
}
