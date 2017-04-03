<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

date_default_timezone_set('UTC');

class DecimalAddTest extends TestCase
{
    public function testZeroAdd()
    {
        $z = Decimal::fromInteger(0);
        $n = Decimal::fromInteger(5);

        $this->assertTrue($z->add($n)->equals($n));
        $this->assertTrue($n->add($z)->equals($n));
    }

    public function testPositivePositiveDecimalAdd()
    {
        $n1 = Decimal::fromString('3.45');
        $n2 = Decimal::fromString('7.67');

        $this->assertTrue($n1->add($n2)->equals(Decimal::fromString('11.12')));
        $this->assertTrue($n2->add($n1)->equals(Decimal::fromString('11.12')));
    }

    public function testNegativenegativeDecimalAdd()
    {
        $n1 = Decimal::fromString('-3.45');
        $n2 = Decimal::fromString('-7.67');

        $this->assertTrue($n1->add($n2)->equals(Decimal::fromString('-11.12')));
        $this->assertTrue($n2->add($n1)->equals(Decimal::fromString('-11.12')));
    }

    public function testPositiveNegativeDecimalAdd()
    {
        $n1 = Decimal::fromString('3.45');
        $n2 = Decimal::fromString('-7.67');

        $this->assertTrue($n1->add($n2)->equals(Decimal::fromString('-4.22')));
        $this->assertTrue($n2->add($n1)->equals(Decimal::fromString('-4.22')));
    }
}
