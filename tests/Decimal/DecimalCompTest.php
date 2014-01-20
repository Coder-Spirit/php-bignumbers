<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;

class DecimalCompTest extends PHPUnit_Framework_TestCase
{
    public function testSelfComp()
    {
        $ten  = Decimal::fromInteger(10);
        $this->assertTrue($ten->comp($ten) === 0);
    }

    public function testBasicCases()
    {
        $one = Decimal::fromInteger(1);
        $ten = Decimal::fromInteger(10);

        $this->assertTrue($one->comp($ten) === -1);
        $this->assertTrue($ten->comp($one) === 1);
    }

    public function testInfiniteComp()
    {
        $ten  = Decimal::fromInteger(10);
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $this->assertTrue($ten->comp($pInf) === -1);
        $this->assertTrue($ten->comp($nInf) === 1);

        $this->assertTrue($pInf->comp($ten) === 1);
        $this->assertTrue($nInf->comp($ten) === -1);
    }
}
