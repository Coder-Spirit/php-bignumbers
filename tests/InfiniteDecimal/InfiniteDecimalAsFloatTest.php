<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalAsFloatTest extends PHPUnit_Framework_TestCase
{
    public function testAsFloat()
    {
        $this->assertEquals(INF, InfiniteDecimal::getPositiveInfinite()->asFloat());
        $this->assertEquals(-INF, InfiniteDecimal::getNegativeInfinite()->asFloat());
    }
}
