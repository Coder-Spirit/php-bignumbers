<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group arctan
 */
class DecimalArctanTest extends PHPUnit_Framework_TestCase
{
    public function arctanProvider() {
        // Some values provided by wolframalpha
        return [
            ['0.154', '0.15279961393666', 14],
            ['0', '0', 17],
            ['-1', '-0.78539816339744831', 17],
        ];
    }

    /**
     * @dataProvider arctanProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $arctanX = $x->arctan($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($arctanX),
            "The answer must be " . $answer . ", but was " . $arctanX
        );
    }

}
