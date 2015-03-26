<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalEqualsTest extends PHPUnit_Framework_TestCase
{
    public function testEquals()
    {
        $this->assertTrue(InfiniteDecimal::getPositiveInfinite()->equals(InfiniteDecimal::getPositiveInfinite()));
        $this->assertTrue(InfiniteDecimal::getNegativeInfinite()->equals(InfiniteDecimal::getNegativeInfinite()));

        $this->assertFalse(InfiniteDecimal::getPositiveInfinite()->equals(InfiniteDecimal::getNegativeInfinite()));
        $this->assertFalse(InfiniteDecimal::getNegativeInfinite()->equals(InfiniteDecimal::getPositiveInfinite()));
    }
}
