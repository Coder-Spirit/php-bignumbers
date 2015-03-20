<?php

use Litipk\BigNumbers\Decimal as Decimal;

/**
 * @group mod
 */
class DecimalModTest extends PHPUnit_Framework_TestCase
{
    public function modProvider() {
        return array(
            array('10', '3', '1'),
            array('34', '3.4', '0'),
            array('15.1615', '3.156156', '2.536876'),
            array('15.1615', '3.156156', '2.5365', 3),
        );
    }
    /**
     * @dataProvider modProvider
     */
    public function testMod($number, $mod, $answer, $scale = null) {
        $numberDec = Decimal::fromString($number);
        $modDec = Decimal::fromString($mod);
        $decimalAnswer = $numberDec->mod($modDec, $scale);

        $this->assertTrue(
            Decimal::fromString($answer)->equals($decimalAnswer),
            $decimalAnswer . ' must be equal to ' . $answer
        );
    }
}
