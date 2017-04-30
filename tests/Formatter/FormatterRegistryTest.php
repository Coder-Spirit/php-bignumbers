<?php

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\Formatter as Formatter;

class FormatterRegistryTest extends PHPUnit_Framework_TestCase
{
    function setUp()
    {
        Formatter::unregister();
    }

    public function testRegistry()
    {
        Formatter::register('pants', ['thousandsMark'=>'!', 'decimalMark'=>'%%%']);
        $this->assertSame('1!234!567%%%890', Formatter::formatAs('pants', '1234567.890'));
    }

    public function testRegistryInvalid()
    {
        $this->setExpectedException('InvalidArgumentException');
        Formatter::formatAs('pants', '1234567.890');
    }

    public function testRegistryUnregister()
    {
        Formatter::register('pants', ['thousandsMark'=>'!', 'decimalMark'=>'%%%']);
        Formatter::unregister('pants');
        $this->setExpectedException('InvalidArgumentException');
        Formatter::formatAs('pants', '1234567.890');
    }
}
