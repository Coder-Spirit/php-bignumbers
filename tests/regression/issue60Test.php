<?php

declare(strict_types=1);

use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class issue60Test extends TestCase
{
    public function test_that_fromFloat_division_does_not_calculate_invalid_log10_avoiding_div_zero()
    {
        $value = Decimal::fromFloat(1.001);
        $divisor = Decimal::fromFloat(20);

        $this->assertEquals(0.05005, $value->div($divisor)->asFloat());
        $this->assertEquals(0.000434077479319, $value->log10()->asFloat());
    }

    public function test_that_fromFloat_less_than_1_still_correct()
    {
        $value = Decimal::fromFloat(0.175);
        $divisor = Decimal::fromFloat(20);

        $this->assertEquals(0.009, $value->div($divisor)->asFloat());
        $this->assertEquals(-0.7569, $value->log10()->asFloat());
    }
}
