<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class InfiniteDecimalRoundingTest extends PHPUnit_Framework_TestCase
{
    public function testInfiniteCeil()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->ceil()->equals($pInf));
        $this->assertTrue($nInf->ceil()->equals($nInf));
    }

    public function testInfiniteFloor()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->floor()->equals($pInf));
        $this->assertTrue($nInf->floor()->equals($nInf));
    }

    public function testInfiniteRound()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->round()->equals($pInf));
        $this->assertTrue($nInf->round()->equals($nInf));
    }
}
