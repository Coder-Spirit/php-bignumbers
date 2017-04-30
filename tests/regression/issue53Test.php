<?php

declare(strict_types=1);

use Litipk\BigNumbers\Decimal;
use PHPUnit\Framework\TestCase;

class issue53Test extends TestCase
{
    public function test_that_no_division_by_zero_is_performed_without_explicit_scale()
    {
        $d1 = Decimal::create(192078120.5);
        $d2 = Decimal::create(31449600);

        $d1->div($d2);

        // We are asserting that no exception is thrown
        $this->assertTrue(true);
    }

    public function test_that_no_division_by_zero_is_performed_with_explicit_scale()
    {
        $d1 = Decimal::create(192078120.5, 28);
        $d2 = Decimal::create(31449600, 28);

        $d1->div($d2);

        // We are asserting that no exception is thrown
        $this->assertTrue(true);
    }
}
