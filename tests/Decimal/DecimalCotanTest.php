<?php

use \Litipk\BigNumbers\Decimal as Decimal;
use \Litipk\BigNumbers\DecimalConstants as DecimalConstants;

/**
 * @group cotan
 */
class DecimalCotanTest extends PHPUnit_Framework_TestCase
{
    public function cotanProvider() {
        // Some values providede by mathematica
        return array(
            array('1', '0.64209261593433', 14),
            array('123.123', '1.45891895739232371', 17),
            array('15000000000', '-1.04405948230055701685', 20)

        );
    }

    /**
     * @dataProvider cotanProvider
     */
    public function testSimple($nr, $answer, $digits)
    {
        $x = Decimal::fromString($nr);
        $cotanX = $x->cotan($digits);
        $this->assertTrue(
            Decimal::fromString($answer)->equals($cotanX),
            'cotan('.$nr.') must be equal to '.$answer.', but was '.$cotanX
        );
    }
    
    /**
     * @expectedException \DomainException
     * @expectedExceptionMessage The cotangent of this 'angle' is undefined.
     */
    public function testCotanPiDiv()
    {    	
        $PI  = DecimalConstants::PI();
        $PI->cotan();
    }
    
}