<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cosec
 */
class InfiniteDecimalCosecTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cosecant function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteCosec()
    {
        InfiniteDecimal::getPositiveInfinite()->cosec();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cosecant function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteCosec()
    {
        InfiniteDecimal::getNegativeInfinite()->cosec();
    }
}
