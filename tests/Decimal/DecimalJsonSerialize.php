<?php

use Litipk\BigNumbers\Decimal as Decimal;
use PHPUnit\Framework\TestCase;

class DecimalJsonSerialize extends TestCase
{
    public function testJsonSerialize()
    {
        $value = '123.456';
        $this->assertEquals($value, Decimal::fromString($value)->jsonSerialize());
    }

    public function testJsonSerializable()
    {
        $value = '123.456';
        $this->assertEquals(json_encode($value), json_encode(Decimal::fromString($value)));
    }
}
