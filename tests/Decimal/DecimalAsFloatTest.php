<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalAsFloatTest extends PHPUnit_Framework_TestCase
{
    public function testAsFloat()
    {
        $this->assertEquals(1.0, Decimal::fromString('1.0')->asFloat());
        $this->assertTrue(is_float(Decimal::fromString('1.0')->asFloat()));

        $this->assertEquals(1.0, Decimal::fromInteger(1)->asFloat());
        $this->assertTrue(is_float(Decimal::fromInteger(1)->asFloat()));

        $this->assertEquals(1.0, Decimal::fromFloat(1.0)->asFloat());
        $this->assertEquals(1.123123123, Decimal::fromString('1.123123123')->asFloat());

        $this->assertTrue(is_float(Decimal::fromFloat(1.0)->asFloat()));
        $this->assertTrue(is_float(Decimal::fromString('1.123123123')->asFloat()));
    }
}
