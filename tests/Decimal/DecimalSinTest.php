<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group sin
 */
class DecimalSinTest extends PHPUnit_Framework_TestCase
{
    public function sinProvider() {
        // Some values providede by mathematica
        return array(
            array('1', '0.84147098480790', 14),
            array('123.123', '-0.56537391969733569', 17),
            array('15000000000', '0.69170450164193502844', 20)
        );
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
