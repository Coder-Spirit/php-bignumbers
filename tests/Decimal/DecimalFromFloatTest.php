<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\Exceptions\InvalidArgumentTypeException as InvalidArgumentTypeException;


date_default_timezone_set('UTC');


class DecimalFromFloatTest extends PHPUnit_Framework_TestCase
{
    public function testInfinites()
    {
        $pInf = Decimal::fromFloat(INF);
        $nInf = Decimal::fromFloat(-INF);

        $this->assertTrue($pInf->isInfinite());
        $this->assertTrue($nInf->isInfinite());

        $this->assertTrue($pInf->isPositive());
        $this->assertTrue($nInf->isNegative());
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage To ensure consistency, this class doesn't handle NaN objects.
     */
    public function testNaN()
    {
        Decimal::fromFloat(INF - INF);
    }

    /**
     * @expectedException Litipk\Exceptions\InvalidArgumentTypeException
     * @expectedExceptionMessage $fltValue must be of type float
     */
    public function testNoFloat()
    {
        Decimal::fromFloat(5);
    }
}
