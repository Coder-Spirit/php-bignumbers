<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Infinite as Infinite;
use Litipk\BigNumbers\NaN as NaN;

class DecimalMulTest extends PHPUnit_Framework_TestCase
{
    public function testZeroMul()
    {
        $z = Decimal::fromInteger(0);
        $n = Decimal::fromInteger(5);

        $r1 = $z->mul($n);
        $r2 = $n->mul($z);

        $this->assertTrue($r1->equals($r2));
        $this->assertTrue($r2->equals($r1));

        $this->assertTrue($r1->isZero());
        $this->assertTrue($r2->isZero());
    }

    public function testSignsMul()
    {
        $n1 = Decimal::fromInteger(1);
        $n2 = Decimal::fromInteger(-1);

        $n11 = $n1->mul($n1);
        $n12 = $n1->mul($n2);
        $n21 = $n2->mul($n1);

        $this->assertTrue($n1->equals($n11));
        $this->assertTrue($n11->equals($n1));

        $this->assertTrue($n11->isPositive());
        $this->assertFalse($n11->isNegative());

        $this->assertTrue($n12->equals($n21));
        $this->assertTrue($n21->equals($n12));

        $this->assertTrue($n12->isNegative());
        $this->assertTrue($n21->isNegative());

        $this->assertFalse($n12->isPositive());
        $this->assertFalse($n21->isPositive());
    }

    public function testNaNMul()
    {
        $nan = NaN::getNaN();
        $one = Decimal::fromInteger(1);

        $this->assertTrue($one->mul($nan)->isNaN());
        $this->assertTrue($nan->mul($one)->isNaN());
    }

    public function testInfiniteMul()
    {
        $pInf = Infinite::getPositiveInfinite();
        $nInf = Infinite::getNegativeInfinite();

        $pOne = Decimal::fromInteger(1);
        $nOne = Decimal::fromInteger(-1);

        $oipp = $pOne->mul($pInf);
        $oipn = $pOne->mul($nInf);
        $oinp = $nOne->mul($pInf);
        $oinn = $nOne->mul($nInf);

        $this->assertTrue($oipp->isPositive());
        $this->assertTrue($oinn->isPositive());

        $this->assertTrue($oinp->isNegative());
        $this->assertTrue($oipn->isNegative());

        $this->assertTrue($oipp->isInfinite());
        $this->assertTrue($oipn->isInfinite());
        $this->assertTrue($oinp->isInfinite());
        $this->assertTrue($oinn->isInfinite());
    }
}
