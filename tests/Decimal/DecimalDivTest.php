<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN as NaN;

class DecimalDivTest extends PHPUnit_Framework_TestCase
{
    public function testZeroDiv()
    {
        $one  = Decimal::fromInteger(1);
        $zero = Decimal::fromInteger(0);

        $this->assertTrue($one->div($zero)->isNaN());
        $this->assertTrue($zero->div($one)->equals($zero));
    }

    public function testOneDiv()
    {
        $one = Decimal::fromInteger(1);
        $two = Decimal::fromInteger(2);

        $this->assertTrue($two->div($one)->equals($two));
    }

    public function testInfiniteDiv()
    {
        $one  = Decimal::fromInteger(1);
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $this->assertTrue($one->div($pInf)->isZero());
        $this->assertTrue($one->div($nInf)->isZero());
    }

    public function testNaNDiv()
    {
        $one = Decimal::fromInteger(1);
        $nan = NaN::getNaN();

        $this->assertTrue($one->div($nan)->isNaN());
        $this->assertTrue($nan->div($one)->isNaN());
    }

    public function testBasicDiv()
    {
        $one   = Decimal::fromInteger(1);
        $two   = Decimal::fromInteger(2);
        $four  = Decimal::fromInteger(4);
        $eight = Decimal::fromInteger(8);

        // Integer exact division
        $this->assertTrue($eight->div($two)->equals($four));
        $this->assertTrue($eight->div($four)->equals($two));

        // Arbitrary precision division
        $this->assertTrue($one->div($eight, 0)->equals(Decimal::fromString('0')));
        $this->assertTrue($one->div($eight, 1)->equals(Decimal::fromString('0.1')));
        $this->assertTrue($one->div($eight, 2)->equals(Decimal::fromString('0.13')));
        $this->assertTrue($one->div($eight, 3)->equals(Decimal::fromString('0.125')));
    }
}
