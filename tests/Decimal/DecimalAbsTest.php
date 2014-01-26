<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalAbsTest extends PHPUnit_Framework_TestCase
{
    public function testFiniteAbs()
    {
        $this->assertTrue(Decimal::fromInteger(0)->abs()->equals(Decimal::fromInteger(0)));
        $this->assertTrue(Decimal::fromInteger(5)->abs()->equals(Decimal::fromInteger(5)));
        $this->assertTrue(Decimal::fromInteger(-5)->abs()->equals(Decimal::fromInteger(5)));
    }

    public function testInfiniteAbs()
    {
    	$this->assertTrue(
    		Decimal::getPositiveInfinite()->abs()->equals(Decimal::getPositiveInfinite())
    	);

    	$this->assertTrue(
    		Decimal::getNegativeInfinite()->abs()->equals(Decimal::getPositiveInfinite())
    	);
    }
}
