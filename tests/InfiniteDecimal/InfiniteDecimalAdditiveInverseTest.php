<?php

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class InfiniteDecimalAdditiveInverseTest extends PHPUnit_Framework_TestCase
{
    public function testAdditiveInverse()
    {
        $this->assertTrue(
            InfiniteDecimal::getNegativeInfinite()->additiveInverse()->equals(InfiniteDecimal::getPositiveInfinite())
        );
        $this->assertTrue(
            InfiniteDecimal::getPositiveInfinite()->additiveInverse()->equals(InfiniteDecimal::getNegativeInfinite())
        );
    }
}
