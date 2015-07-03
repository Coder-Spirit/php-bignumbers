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

    public function floatProvider()
    {
        $tests = [
            [1.1, "1.1"],
            [1234567890.0, "1234567890"],
            [1.1234567890, "1.123456789"],
            [-1.1234567890, "-1.123456789"],
            [0.000001, "0.0000010"],
            [0.000001, "0.00", 2],
            [0.000001, "0.000001", null, !!'removeZeroes'],
            [90.05, "90.05"],
        ];

        if (PHP_INT_SIZE) {
            // These tests probably won't work if you're not testing on x86-64.
            // It might also be better to mark the tests skipped. It is certainly
            // useful to cover this functionality off though as it hits the exponent
            // parsing in Decimal::fromFloat()
            $tests[] = [
                 1230123074129038740129734907810923874017283094.1, 
                "1230123074129038665578332283019326242900934656.0000000000000000"
            ];
            $tests[] = [
                 1230123074129038740129734907810923874017283094.1, 
                "1230123074129038665578332283019326242900934656",
                0
            ];
            $tests[] = [
                 0.0000000000000000000000000000000000000000000000123412351234,
                "0.0000000000000000000000000000000000000000000000123412351234",
            ];
            $tests[] = [
                 0.0000000000000000000000000000000000000000000000123412351234,
                "0.00",
                2
            ];
        }
        return $tests;
    }

    /**
     * @dataProvider floatProvider
     */
    public function testFromFloat($in, $str, $scale=null, $removeZeroes=false)
    {
        $v = Decimal::fromFloat($in, $scale, $removeZeroes);
        $this->assertSame($str, $v->innerValue());
    }
}
