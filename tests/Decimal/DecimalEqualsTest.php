<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;

class DecimalEqualsTest extends PHPUnit_Framework_TestCase
{
    public function testNotEquals()
    {
        $this->assertTrue(!Decimal::fromInteger(1)->equals(Decimal::fromInteger(2)));

        $this->assertTrue(!Decimal::fromInteger(1)->equals(Infinite::getPositiveInfinite()));
        $this->assertTrue(!Decimal::fromInteger(1)->equals(Infinite::getNegativeInfinite()));

        $this->assertTrue(!Infinite::getPositiveInfinite()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(!Infinite::getNegativeInfinite()->equals(Decimal::fromInteger(1)));
    }
}
