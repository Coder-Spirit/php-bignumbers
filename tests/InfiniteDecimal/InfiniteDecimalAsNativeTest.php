<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;
use Litipk\Exceptions\InvalidCastException as InvalidCastException;


date_default_timezone_set('UTC');


class InfiniteDecimalAsFloatTest extends PHPUnit_Framework_TestCase
{
    public function testAsFloat()
    {
        $this->assertEquals(INF, InfiniteDecimal::getPositiveInfinite()->asFloat());
        $this->assertEquals(-INF, InfiniteDecimal::getNegativeInfinite()->asFloat());
    }

    public function testAsInteger()
    {
        $catched = false;
        try {
            InfiniteDecimal::getPositiveInfinite()->asInteger();
        } catch (InvalidCastException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            InfiniteDecimal::getNegativeInfinite()->asInteger();
        } catch (InvalidCastException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }
}
