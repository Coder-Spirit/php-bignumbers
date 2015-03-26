<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalInnerValueTest extends PHPUnit_Framework_TestCase
{
    public function testInnerValue()
    {
        # We cannot make assumptions on the inner value!
        Decimal::fromInteger(3)->_innerValue();
    }
}
