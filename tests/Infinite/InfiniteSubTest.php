<?php

use Litipk\BigNumbers\Decimal as Decimal;

class InfiniteSubTest extends PHPUnit_Framework_TestCase
{
    public function testInfiniteSub()
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

    public function testDecimalSub()
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
}
