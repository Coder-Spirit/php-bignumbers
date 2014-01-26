<?php

use Litipk\BigNumbers\Decimal as Decimal;


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

    public function testNaN()
    {
        $catched = false;
        try {
            $NaN = Decimal::fromFloat(INF - INF);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testNoFloat()
    {
        $catched = false;

        try {
            $n = Decimal::fromFloat(5);
        } catch (Exception $e) {
            $catched = true;
        }

        $this->assertTrue($catched);
    }
}
