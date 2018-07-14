<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

/**
 * @group sec
 */
class DecimalSecTest extends TestCase
{
    public function SecProvider() {
        // Some values provided by Mathematica
        return [
            ['5', '3.52532008581609', 14],
            ['5', '3.52532008581608840670180105996324', null],
            ['456.456', '-1.66172995090378344', 17],
            ['28000000000', '-1.11551381955633891873', 20],
        ];
    }

    /**
     * @dataProvider secProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $secX = $x->sec($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($secX),
            "The answer must be " . $answer . ", but was " . $secX
        );
    }
}
