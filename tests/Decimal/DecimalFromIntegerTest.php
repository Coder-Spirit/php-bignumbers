<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalFromIntegerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException Litipk\Exceptions\InvalidArgumentTypeException
     * @expectedExceptionMessage $intValue must be of type int
     */
    public function testNoInteger()
    {
        Decimal::fromInteger(5.1);
    }
}
