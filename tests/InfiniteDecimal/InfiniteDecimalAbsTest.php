<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalAbsTest extends PHPUnit_Framework_TestCase
{
    public function testAbs()
    {
        $this->assertTrue(
            InfiniteDecimal::getPositiveInfinite()->abs()->equals(InfiniteDecimal::getPositiveInfinite())
        );

        $this->assertTrue(
            InfiniteDecimal::getNegativeInfinite()->abs()->equals(InfiniteDecimal::getPositiveInfinite())
        );
    }
}
