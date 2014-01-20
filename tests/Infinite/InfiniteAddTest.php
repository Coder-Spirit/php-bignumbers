<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN as NaN;

class InfiniteAddTest extends PHPUnit_Framework_TestCase
{
    public function testNaNAdd()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();
        $nan  = NaN::getNaN();

        $this->assertTrue($pInf->add($nan)->isNaN());
        $this->assertTrue($nInf->add($nan)->isNaN());

        $this->assertTrue($nan->add($pInf)->isNaN());
        $this->assertTrue($nan->add($nInf)->isNaN());
    }

    public function testInfiniteAdd()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $this->assertTrue($pInf->add($pInf)->equals($pInf));
        $this->assertTrue($nInf->add($nInf)->equals($nInf));

        $this->assertTrue($pInf->add($nInf)->isNaN());
        $this->assertTrue($nInf->add($pInf)->isNaN());
    }

    public function testDecimalSub()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

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
}
