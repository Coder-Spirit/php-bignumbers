<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalAddTest extends PHPUnit_Framework_TestCase
{
    public function testFiniteInfiniteAdd()
    {
        $pInf = InfiniteDecimal::getPositiveInfinite();
        $nInf = InfiniteDecimal::getNegativeInfinite();

        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $this->assertTrue($pInf->add($pTen)->equals($pInf));
        $this->assertTrue($nInf->add($pTen)->equals($nInf));

        $this->assertTrue($pInf->add($nTen)->equals($pInf));
        $this->assertTrue($nInf->add($nTen)->equals($nInf));

        $this->assertTrue($pTen->add($pInf)->equals($pInf));
        $this->assertTrue($pTen->add($nInf)->equals($nInf));

        $this->assertTrue($nTen->add($pInf)->equals($pInf));
        $this->assertTrue($nTen->add($nInf)->equals($nInf));
    }

    public function testInfiniteInfiniteAdd()
    {
        $pInf = InfiniteDecimal::getPositiveInfinite();
        $nInf = InfiniteDecimal::getNegativeInfinite();

        $this->assertTrue($pInf->add($pInf)->equals($pInf));
        $this->assertTrue($nInf->add($nInf)->equals($nInf));

        $catched = false;
        try {
            $pInf->add($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->add($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }
}
