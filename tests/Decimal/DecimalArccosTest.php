<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group arcsin
 */
class DecimalArccosTest extends PHPUnit_Framework_TestCase
{
    public function arccosProvider() {
        // Some values provided by wolframalpha
        return [
            ['0.154', '1.41618102663394', 14],
            ['1', '0', 17],
            ['-1', '3.14159265358979324', 17],
        ];
    }

    /**
     * @dataProvider arccosProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $arccosX = $x->arccos($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($arccosX),
            "The answer must be " . $answer . ", but was " . $arccosX
        );
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The arccos of this number is undefined.
     */
    public function testArcosGreaterThanOne()
    {
        Decimal::fromString('25.546')->arccos();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The arccos of this number is undefined.
     */
    public function testArccosFewerThanNegativeOne()
    {
        Decimal::fromString('-304.75')->arccos();
    }
}
