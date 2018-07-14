<?php

use \Litipk\BigNumbers\Decimal as Decimal;
use \Litipk\BigNumbers\DecimalConstants as DecimalConstants;
use PHPUnit\Framework\TestCase;

/**
 * @group tan
 */
class DecimalTanTest extends TestCase
{
    public function tanProvider() {
        // Some values providede by mathematica
        return [
            ['1', '1.55740772465490', 14],
            ['1', '1.55740772465490223050697480745836', null],
            ['123.123', '0.68543903342472368', 17],
            ['15000000000', '-0.95779983511717825557', 20]
        ];
    }

    /**
     * @dataProvider tanProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $tanX = $x->tan($digits);
        $this->assertTrue(
            Decimal::fromString($answer)->equals($tanX),
            'tan('.$nr.') must be equal to '.$answer.', but was '.$tanX
        );
    }

    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The tangent of this 'angle' is undefined.
     */
    public function testTanPiTwoDiv()
    {
        $piDividedByTwo = DecimalConstants::pi()->div(Decimal::fromInteger(2));
        $piDividedByTwo->tan(30);
    }

}
