<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cos
 */
class InfiniteDecimalCosTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cosinus function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteCos()
    {
        InfiniteDecimal::getPositiveInfinite()->cos();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cosinus function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteCos()
    {
        InfiniteDecimal::getNegativeInfinite()->cos();
    }
}
