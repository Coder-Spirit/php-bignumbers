<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cos
 */
class InfiniteDecimalSinTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Sinus function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteSin()
    {
        InfiniteDecimal::getPositiveInfinite()->sin();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Sinus function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteSin()
    {
        InfiniteDecimal::getNegativeInfinite()->sin();
    }
}
