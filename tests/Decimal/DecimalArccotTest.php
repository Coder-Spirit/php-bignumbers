<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group arccot
 */
class DecimalArccotTest extends PHPUnit_Framework_TestCase
{
    public function arccotProvider() {
        // Some values provided by wolframalpha
        return [
            ['0.154', '1.41799671285823', 14],
            ['0', '1.57079632679489662', 17],
            ['-1', '-0.78540', 5],
        ];
    }

    /**
     * @dataProvider arccotProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $arccotX = $x->arccot($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($arccotX),
            "The answer must be " . $answer . ", but was " . $arccotX
        );
    }

}
