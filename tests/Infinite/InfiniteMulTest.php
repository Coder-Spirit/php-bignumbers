<?php

use Litipk\BigNumbers\Decimal as Decimal;

class InfiniteMulTest extends PHPUnit_Framework_TestCase
{
    public function testZeroMul()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();
        $zero = Decimal::fromInteger(0);

        $catched = false;
        try {
            $pInf->mul($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->mul($zero);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $zero->mul($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $zero->mul($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

    }
}
