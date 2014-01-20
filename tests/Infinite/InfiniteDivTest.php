<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN as NaN;

class InfiniteDivTest extends PHPUnit_Framework_TestCase
{
    public function testNaNDiv()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();
        $nan  = NaN::getNaN();

        $this->assertTrue($pInf->div($nan)->isNaN());
        $this->assertTrue($nInf->div($nan)->isNaN());
    }

    public function testZeroDiv()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();
        $zero = Decimal::fromInteger(0);

        $this->assertTrue($pInf->div($zero)->isNaN());
        $this->assertTrue($nInf->div($zero)->isNaN());
    }

    public function testInfiniteDiv()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $this->assertTrue($pInf->div($pInf)->isNaN());
        $this->assertTrue($pInf->div($nInf)->isNaN());

        $this->assertTrue($nInf->div($pInf)->isNaN());
        $this->assertTrue($nInf->div($nInf)->isNaN());
    }

    public function testSimpleNumberDiv()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $this->assertTrue($pInf->div($pTen)->equals($pInf));
        $this->assertTrue($pInf->div($nTen)->equals($nInf));

        $this->assertTrue($nInf->div($pTen)->equals($nInf));
        $this->assertTrue($nInf->div($nTen)->equals($pInf));
    }
}
