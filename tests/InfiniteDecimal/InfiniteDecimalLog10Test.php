<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalLog10Test extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Decimal can't handle logarithms of negative numbers (it's only for real numbers).
     */
    public function testNegativeInfiniteLog10()
    {
        InfiniteDecimal::getNegativeInfinite()->log10();
    }

    public function testPInfiniteLog10()
    {
        $pInf = InfiniteDecimal::getPositiveInfinite();

        $this->assertTrue($pInf->log10()->equals($pInf));
    }
}
