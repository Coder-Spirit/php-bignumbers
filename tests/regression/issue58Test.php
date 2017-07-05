<?php

declare(strict_types=1);

use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class issue58Test extends TestCase
{
    public function test_that_fromString_preserves_the_correct_inner_scale_to_avoid_divisions_by_zero()
    {
        $value = Decimal::create('12.99', 4);
        $divisor = Decimal::create(2, 4);

        $this->assertEquals(6.495, $value->div($divisor)->asFloat());
    }
}