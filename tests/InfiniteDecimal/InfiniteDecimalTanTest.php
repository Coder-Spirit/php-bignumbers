<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cos
 */
class InfiniteDecimalTanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Tangent function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteTan()
    {
        InfiniteDecimal::getPositiveInfinite()->tan();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Tangent function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteTan()
    {
        InfiniteDecimal::getNegativeInfinite()->tan();
    }
}
