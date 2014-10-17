<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalInnerValueTest extends PHPUnit_Framework_TestCase
{
    public function testInnerValue()
    {
        for($i=0;$i<100;$i++)
        {
            $this->assertEquals($i, Decimal::fromInteger($i)->_innerValue());
        }
    }
}
