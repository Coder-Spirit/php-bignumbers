<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalCompTest extends PHPUnit_Framework_TestCase
{
    public function testSelfComp()
    {
        $ten  = Decimal::fromInteger(10);
        $this->assertTrue($ten->comp($ten) === 0);
    }

    public function testBasicCases()
    {
        $one = Decimal::fromInteger(1);
        $ten = Decimal::fromInteger(10);

        $this->assertTrue($one->comp($ten) === -1);
        $this->assertTrue($ten->comp($one) === 1);
    }
}
