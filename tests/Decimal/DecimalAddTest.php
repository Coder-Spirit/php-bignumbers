<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalAddTest extends PHPUnit_Framework_TestCase
{
    public function testZeroAdd()
    {
        $z = Decimal::fromInteger(0);
        $n = Decimal::fromInteger(5);

        $this->assertTrue($z->add($n)->equals($n));
        $this->assertTrue($n->add($z)->equals($n));
    }

    public function testFiniteInfiniteAdd()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $pTen = Decimal::fromInteger(10);
        $nTen = Decimal::fromInteger(-10);

        $this->assertTrue($pInf->add($pTen)->equals($pInf));
        $this->assertTrue($nInf->add($pTen)->equals($nInf));

        $this->assertTrue($pInf->add($nTen)->equals($pInf));
        $this->assertTrue($nInf->add($nTen)->equals($nInf));

        $this->assertTrue($pTen->add($pInf)->equals($pInf));
        $this->assertTrue($pTen->add($nInf)->equals($nInf));

        $this->assertTrue($nTen->add($pInf)->equals($pInf));
        $this->assertTrue($nTen->add($nInf)->equals($nInf));
    }

    public function testInfiniteInfiniteAdd()
    {
        $pInf = Decimal::getPositiveInfinite();
        $nInf = Decimal::getNegativeInfinite();

        $this->assertTrue($pInf->add($pInf)->equals($pInf));
        $this->assertTrue($nInf->add($nInf)->equals($nInf));

        $catched = false;
        try {
            $pInf->add($nInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);

        $catched = false;
        try {
            $nInf->add($pInf);
        } catch (\DomainException $e) {
            $catched = true;
        }
        $this->assertTrue($catched);
    }

    public function testPositivePositiveDecimalAdd()
    {
        $n1 = Decimal::fromString('3.45');
        $n2 = Decimal::fromString('7.67');

        $this->assertTrue($n1->add($n2)->equals(Decimal::fromString('11.12')));
        $this->assertTrue($n2->add($n1)->equals(Decimal::fromString('11.12')));
    }
}
