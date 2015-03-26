<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;
use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class InfiniteDecimalDivTest extends PHPUnit_Framework_TestCase
{
    public function testZeroInfiniteDiv()
    {
        $pInf = InfiniteDecimal::getPositiveInfinite();
        $nInf = InfiniteDecimal::getNegativeInfinite();
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

    public function testFiniteInfiniteDiv()
    {
        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $pInf = InfiniteDecimal::getPositiveInfinite();
        $nInf = InfiniteDecimal::getNegativeInfinite();

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
        $pInf = InfiniteDecimal::getPositiveInfinite();
        $nInf = InfiniteDecimal::getNegativeInfinite();

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
}
