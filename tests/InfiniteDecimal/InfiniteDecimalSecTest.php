<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group sec
 */
class InfiniteDecimalSecTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Secant function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteSec()
    {
        InfiniteDecimal::getPositiveInfinite()->sec();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Secant function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteSec()
    {
        InfiniteDecimal::getNegativeInfinite()->sec();
    }
}
