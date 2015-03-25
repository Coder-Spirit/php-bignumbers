<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;


date_default_timezone_set('UTC');


class DecimalGetInfiniteTest extends PHPUnit_Framework_TestCase
{
    public function testGetInfinite()
    {
        $this->assertTrue(Decimal::getPositiveInfinite()->equals(InfiniteDecimal::getPositiveInfinite()));
        $this->assertTrue(Decimal::getNegativeInfinite()->equals(InfiniteDecimal::getNegativeInfinite()));
    }
}
