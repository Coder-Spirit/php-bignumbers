<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

/**
 * @group arccos
 */
class DecimalArccosTest extends TestCase
{
    public function arccosProvider() {
        // Some values provided by wolframalpha
        return [
            ['0.154', '1.41618102663394', 14],
            ['0.154', '1.41618102663393517247013425592456', null],
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
