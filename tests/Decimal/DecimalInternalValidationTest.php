<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalInternalValidationTest extends PHPUnit_Framework_TestCase
{
    public function testInternalConstructorValidation()
    {
        $thrown = false;
        try {
            $d = Decimal::fromInteger(null);
        } catch (InvalidArgumentException $e) {
            $thrown = true;
        }
        $this->assertTrue($thrown);

        $thrown = false;
        try {
            $d = Decimal::fromInteger(25, -15);
        } catch (InvalidArgumentException $e) {
            $thrown = true;
        }
        $this->assertTrue($thrown);

        $thrown = false;
        try {
            $d = Decimal::fromInteger(25, "hola mundo");
        } catch (InvalidArgumentException $e) {
            $thrown = true;
        }
        $this->assertTrue($thrown);
    }

    public function testInternalOperatorValidation()
    {
        $one = Decimal::fromInteger(1);

        $thrown = false;
        try {
            $d = $one->mul($one, -1);
        } catch (InvalidArgumentException $e) {
            $thrown = true;
        }
        $this->assertTrue($thrown);
    }
}
