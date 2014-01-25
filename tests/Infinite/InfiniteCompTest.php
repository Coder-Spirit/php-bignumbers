<?php

use Litipk\BigNumbers\Decimal as Decimal;

class InfiniteCompTest extends PHPUnit_Framework_TestCase
{
    public function testSelfComp()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->comp($pInf) === 0);
        $this->assertTrue($nInf->comp($nInf) === 0);

        $this->assertTrue($pInf->comp($nInf) === 1);
        $this->assertTrue($nInf->comp($pInf) === -1);
    }
}
