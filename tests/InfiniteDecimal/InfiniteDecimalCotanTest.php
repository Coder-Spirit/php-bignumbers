<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cotan
 */
class InfiniteDecimalCotanTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cotangent function hasn't limit in the positive infinite.
     */
    public function testFinitePositiveInfiniteCotan()
    {
        InfiniteDecimal::getPositiveInfinite()->cotan();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage Cotangent function hasn't limit in the negative infinite.
     */
    public function testFiniteNegativeInfiniteCotan()
    {
        InfiniteDecimal::getNegativeInfinite()->cotan();
    }
}
