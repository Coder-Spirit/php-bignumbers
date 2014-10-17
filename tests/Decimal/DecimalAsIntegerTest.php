<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalAsIntegerTest extends PHPUnit_Framework_TestCase
{
    public function testFloat()
    {
        $this->assertEquals(1, Decimal::fromString('1.0')->asInteger());
        $this->assertTrue(is_int(Decimal::fromString('1.0')->asInteger()));

        $this->assertEquals(1, Decimal::fromInteger(1)->asInteger());
        $this->assertTrue(is_int(Decimal::fromInteger(1)->asInteger()));

        $this->assertEquals(1, Decimal::fromFloat(1.0)->asInteger());
        $this->assertEquals(1, Decimal::fromString('1.123123123')->asInteger());

        $this->assertTrue(is_int(Decimal::fromFloat(1.0)->asInteger()));
        $this->assertTrue(is_int(Decimal::fromString('1.123123123')->asInteger()));
    }
}
