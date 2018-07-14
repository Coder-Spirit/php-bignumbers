<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

/**
 * @group arcsin
 */
class DecimalArcsinTest extends TestCase
{
    public function arcsinProvider() {
        // Some values provided by wolframalpha
        return [
            ['0.154', '0.15461530016096', 14],
            ['0.154', '0.15461530016096144676118743571519', null],
            ['1', '1.57079632679489662', 17],
            ['-1', '-1.57079632679489662', 17],
        ];
    }

    /**
     * @dataProvider arcsinProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $arcsinX = $x->arcsin($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($arcsinX),
            "The answer must be " . $answer . ", but was " . $arcsinX
        );
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The arcsin of this number is undefined.
     */
    public function testArcsinGreaterThanOne()
    {
        Decimal::fromString('25.546')->arcsin();
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The arcsin of this number is undefined.
     */
    public function testArcsinFewerThanNegativeOne()
    {
        Decimal::fromString('-304.75')->arcsin();
    }
}
