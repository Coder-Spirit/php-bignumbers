<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalPropertiesTest extends PHPUnit_Framework_TestCase
{
    public function testIsZero()
    {
        $this->assertFalse(InfiniteDecimal::getPositiveInfinite()->isZero());
        $this->assertFalse(InfiniteDecimal::getNegativeInfinite()->isZero());
    }

    public function testIsPositive()
    {
        $this->assertTrue(InfiniteDecimal::getPositiveInfinite()->isPositive());
        $this->assertFalse(InfiniteDecimal::getNegativeInfinite()->isPositive());
    }

    public function testIsNegative()
    {
        $this->assertFalse(InfiniteDecimal::getPositiveInfinite()->isNegative());
        $this->assertTrue(InfiniteDecimal::getNegativeInfinite()->isNegative());
    }
}
