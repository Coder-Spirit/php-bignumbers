<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalFormatTest extends PHPUnit_Framework_TestCase
{
    public function testFormat()
    {
        $this->assertSame('1,234,567.89' , Decimal::create('1234567.89')->format());
        $this->assertSame('1,234,567.890', Decimal::create('1234567.89')->format(['scale'=>3]));
    }
}
