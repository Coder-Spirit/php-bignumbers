<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;
use Litipk\BigNumbers\Formatter as Formatter;

class FormatterTest extends PHPUnit_Framework_TestCase
{
    function dataFormat()
    {
        return [
            // Decimal class doesn't accept these as input yet.
            // ['0.234', '.234'),
            // ['-0.234', '-.234'),

            ['0.234', '0.234'],
            ['-0.234', '-0.234'],

            ['-1.234', '-1.234'],
            ['-11.234', '-11.234'],
            ['-101.234', '-101.234'],
            ['-1,001.234', '-1001.234'],
            ['-10,001.234', '-10001.234'],
            ['-100,001.234', '-100001.234'],
            ['-1,000,001.234', '-1000001.234'],

            ['1.234', '1.234'],
            ['11.234', '11.234'],
            ['101.234', '101.234'],
            ['1,001.234', '1001.234'],
            ['10,001.234', '10001.234'],
            ['100,001.234', '100001.234'],
            ['1,000,001.234', '1000001.234'],
        ];
    }

    /** @dataProvider dataFormat */
    public function testFormat($expected, $input)
    {
        $this->assertFormat($expected, $input);
    }

    public function testFormatInvalidConstructorArg()
    {
        $this->setExpectedException('InvalidArgumentException');
        new Formatter(['abcdefg'=>true]);
    }

    public function testFormatBadInput()
    {
        $this->setExpectedException("InvalidArgumentException");
        $this->format("abcdefgh", []);
    }

    public function testFormatScaleRounds()
    {
        $this->assertFormat('1.6', '1.56', ['scale'=>1]);
    }

    public function testZeroPaddedDecimal()
    {
        $this->assertFormat('1.23000', '1.23', ['scale'=>5]);
    }

    public function testNoZeroPaddedDecimal()
    {
        $this->assertFormat('1.23', '1.23', ['scale'=>5, 'padDecimal'=>false]);
    }

    public function testFormatBlankThousandsMark()
    {
        $this->assertFormat('1000', '1000', ['thousandsMark'=>'']);
    }

    public function testFormatBlankDecimalMark()
    {
        $this->setExpectedException("InvalidArgumentException");
        $this->format('1.234', ['decimalMark'=>'']);
    }

    public function testFormatDecimalMark()
    {
        $this->assertFormat('1,234', '1.234', ['decimalMark'=>","]);
    }

    public function testFormatThousandsMark()
    {
        $this->assertFormat("1 '000 '234", '1000234', ['thousandsMark'=>" '"]);
    }

    public function testFormatBlankSign()
    {
        $this->setExpectedException("InvalidArgumentException");
        $this->format('-1.234', ['sign'=>'']);
    }

    public function testFormatSign()
    {
        $this->assertFormat('- 1.234', '-1.234', ['sign'=>'- ']);
    }

    public function testTemplate()
    {
        $options = ['sign'=>' -', 'tpl'=>'${num}{sign} !!!'];
        $this->assertFormat('$1,000,000.25 - !!!', '-1000000.25', $options);
        $this->assertFormat('$1,000,000.25 !!!'  ,  '1000000.25', $options);
    }

    public function testInfiniteDecimal()
    {
        $formatter = new Formatter();

        $inf = InfiniteDecimal::getPositiveInfinite();
        $this->assertEquals('INF', $formatter->format($inf));

        $inf = InfiniteDecimal::getNegativeInfinite();
        $this->assertEquals('-INF', $formatter->format($inf));
    }

    function format($number, $options=[])
    {
        $formatter = new Formatter($options);
        return $formatter->format($number);
    }

    function assertFormat($expected, $input, $options=[])
    {
        $this->assertSame($expected, $this->format($input, $options));
    }
}
