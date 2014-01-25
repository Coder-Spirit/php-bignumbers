<?php

use Litipk\BigNumbers\Decimal as Decimal;

class DecimalEqualsTest extends PHPUnit_Framework_TestCase
{
    public function testNotEquals()
    {
        $this->assertTrue(!Decimal::fromInteger(1)->equals(Decimal::fromInteger(2)));

        $this->assertTrue(!Decimal::fromInteger(1)->equals(Decimal::getPositiveInfinite()));
        $this->assertTrue(!Decimal::fromInteger(1)->equals(Decimal::getNegativeInfinite()));

        $this->assertTrue(!Decimal::getPositiveInfinite()->equals(Decimal::fromInteger(1)));
        $this->assertTrue(!Decimal::getNegativeInfinite()->equals(Decimal::fromInteger(1)));
    }
}
