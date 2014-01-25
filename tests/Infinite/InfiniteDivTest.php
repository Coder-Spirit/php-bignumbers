<?php

use Litipk\BigNumbers\Decimal as Decimal;

class InfiniteDivTest extends PHPUnit_Framework_TestCase
{
    public function testZeroDiv()
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

    public function testInfiniteDiv()
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

    public function testSimpleNumberDiv()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $this->assertTrue($pInf->div($pTen)->equals($pInf));
        $this->assertTrue($pInf->div($nTen)->equals($nInf));

        $this->assertTrue($nInf->div($pTen)->equals($nInf));
        $this->assertTrue($nInf->div($nTen)->equals($pInf));
    }
}
