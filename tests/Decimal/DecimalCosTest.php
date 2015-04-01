<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group cos
 */
class DecimalCosTest extends PHPUnit_Framework_TestCase
{
    public function cosProvider() {
        // Some values provided by Mathematica
        return array(
            array('1', '0.54030230586814', 14),
            array('123.123', '-0.82483472946164834', 17),
            array('15000000000', '-0.72218064388924347681', 20)
        );
    }

    /**
     * @dataProvider cosProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $cosX = $x->cos((int)$digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($cosX),
            "The answer must be " . $answer . ", but was " . $cosX
        );
    }
}
