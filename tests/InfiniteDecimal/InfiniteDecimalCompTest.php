<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class InfiniteDecimalCompTest extends PHPUnit_Framework_TestCase
{
    public function testFiniteInfiniteComp()
    {
        $ten  = Decimal::fromInteger(10);
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($ten->comp($pInf) === -1);
        $this->assertTrue($ten->comp($nInf) === 1);

        $this->assertTrue($pInf->comp($ten) === 1);
        $this->assertTrue($nInf->comp($ten) === -1);
    }

    public function testInfiniteInfiniteComp()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->comp($pInf) === 0);
        $this->assertTrue($nInf->comp($nInf) === 0);

        $this->assertTrue($pInf->comp($nInf) === 1);
        $this->assertTrue($nInf->comp($pInf) === -1);
    }
}
