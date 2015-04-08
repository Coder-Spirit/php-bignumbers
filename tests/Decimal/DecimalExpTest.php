<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group cos
 */
class DecimalExpTest extends PHPUnit_Framework_TestCase
{
    public function expProvider() {
        // Some values provided by Mathematica
        return array(
            array('0', '1', 0),
            array('0', '1', 1),
            array('0', '1', 2),

            array('1', '3', 0),
            array('1', '2.7', 1),
            array('1', '2.72', 2),
            array('1', '2.718', 3),

            array('-1', '0', 0),
            array('-1', '0.4', 1),
            array('-1', '0.37', 2)
        );
    }

    /**
     * @dataProvider expProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $expX = $x->exp((int)$digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($expX),
            "The answer must be " . $answer . ", but was " . $expX
        );
    }
}
