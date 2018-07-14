<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

/**
 * @group sin
 */
class DecimalSinTest extends TestCase
{
    public function sinProvider() {
        // Some values providede by mathematica
        return [
            ['1', '0.84147098480790', 14],
            ['1', '0.84147098480789650665250232163030', null],
            ['123.123', '-0.56537391969733569', 17],
            ['15000000000', '0.69170450164193502844', 20]
        ];
    }

    /**
     * @dataProvider sinProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $sinX = $x->sin($digits);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($sinX),
            "The answer must be " . $answer . ", but was " . $sinX
        );
    }
}
