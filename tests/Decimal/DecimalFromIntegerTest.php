<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalFromIntegerTest extends PHPUnit_Framework_TestCase
{
    public function testNoInteger()
    {
        $catched = false;

        try {
            $n = Decimal::fromInteger(5.1);
        } catch (Exception $e) {
            $catched = true;
        }

        $this->assertTrue($catched);
    }
}
