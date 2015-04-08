<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

/**
 * @group cos
 */
class InfiniteDecimalExpTest extends PHPUnit_Framework_TestCase
{
    public function testPositiveInfinite()
    {
        $this->assertTrue(InfiniteDecimal::getPositiveInfinite()->exp()->equals(InfiniteDecimal::getPositiveInfinite()));
    }

    public function testNegativeInfinite()
    {
        $this->assertTrue(InfiniteDecimal::getNegativeInfinite()->exp()->isZero());
    }
}
