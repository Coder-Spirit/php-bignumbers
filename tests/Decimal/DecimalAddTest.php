<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN as NaN;

class DecimalAddTest extends PHPUnit_Framework_TestCase
{
    public function testZeroAdd()
    {
        $z = Decimal::fromInteger(0);
        $n = Decimal::fromInteger(5);

        $this->assertTrue($z->add($n)->equals($n));
        $this->assertTrue($n->add($z)->equals($n));
    }

    public function testNaNAdd()
    {
        $nan = NaN::getNaN();
        $one = Decimal::fromInteger(1);

        $this->assertTrue($one->add($nan)->isNaN());
        $this->assertTrue($nan->add($one)->isNaN());
    }

    public function testInfiniteAdd()
    {
        $one = Decimal::fromInteger(1);
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $this->assertTrue($one->add($pInf)->equals($pInf));
        $this->assertTrue($pInf->add($one)->equals($pInf));

        $this->assertTrue($one->add($nInf)->equals($nInf));
        $this->assertTrue($nInf->add($one)->equals($nInf));
    }

    public function testPositivePositiveDecimalAdd()
    {
        $n1 = Decimal::fromString('3.45');
        $n2 = Decimal::fromString('7.67');

        $this->assertTrue($n1->add($n2)->equals(Decimal::fromString('11.12')));
        $this->assertTrue($n2->add($n1)->equals(Decimal::fromString('11.12')));
    }
}
