<?php

use Litipk\BigNumbers\Decimal as Decimal;


date_default_timezone_set('UTC');


class DecimalCompTest extends PHPUnit_Framework_TestCase
{
    public function testSelfComp()
    {
        $ten  = Decimal::fromInteger(10);
        $this->assertTrue($ten->comp($ten) === 0);
    }

    public function testBasicCases()
    {
        $one = Decimal::fromInteger(1);
        $ten = Decimal::fromInteger(10);

        $this->assertTrue($one->comp($ten) === -1);
        $this->assertTrue($ten->comp($one) === 1);
    }

    public function testUnscaledComp()
    {
        // Transitivity
        $this->assertEquals(-1, Decimal::fromFloat(1.001)->comp(Decimal::fromFloat(1.01)));
        $this->assertEquals(1, Decimal::fromFloat(1.01)->comp(Decimal::fromFloat(1.004)));
        $this->assertEquals(-1, Decimal::fromFloat(1.001)->comp(Decimal::fromFloat(1.004)));

        // Reflexivity
        $this->assertEquals(0, Decimal::fromFloat(1.00525)->comp(Decimal::fromFloat(1.00525)));

        // Symmetry
        $this->assertEquals(1, Decimal::fromFloat(1.01)->comp(Decimal::fromFloat(1.001)));
        $this->assertEquals(-1, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.01)));
        $this->assertEquals(1, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.001)));

        $this->assertEquals(1, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.000)));

        // Warning, float to Decimal conversion can have unexpected behaviors, like converting
        // 1.005 to Decimal("1.0049999999999999")
        $this->assertEquals(-1, Decimal::fromFloat(1.0050000000001)->comp(Decimal::fromFloat(1.010)));

        $this->assertEquals(-1, Decimal::fromString("1.005")->comp(Decimal::fromString("1.010")));

        # Proper rounding
        $this->assertEquals(-1, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.0050000000001)));
    }

    public function testScaledComp()
    {
        // Transitivity
        $this->assertEquals(0, Decimal::fromFloat(1.001)->comp(Decimal::fromFloat(1.01), 1));
        $this->assertEquals(0, Decimal::fromFloat(1.01)->comp(Decimal::fromFloat(1.004), 1));
        $this->assertEquals(0, Decimal::fromFloat(1.001)->comp(Decimal::fromFloat(1.004), 1));

        // Reflexivity
        $this->assertEquals(0, Decimal::fromFloat(1.00525)->comp(Decimal::fromFloat(1.00525), 2));

        // Symmetry
        $this->assertEquals(0, Decimal::fromFloat(1.01)->comp(Decimal::fromFloat(1.001), 1));
        $this->assertEquals(0, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.01), 1));
        $this->assertEquals(0, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.001), 1));

        // Proper rounding
        $this->assertEquals(0, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.000), 2));

        // Warning, float to Decimal conversion can have unexpected behaviors, like converting
        // 1.005 to Decimal("1.0049999999999999")
        $this->assertEquals(0, Decimal::fromFloat(1.0050000000001)->comp(Decimal::fromFloat(1.010), 2));

        $this->assertEquals(0, Decimal::fromString("1.005")->comp(Decimal::fromString("1.010"), 2));

        # Proper rounding
        $this->assertEquals(-1, Decimal::fromFloat(1.004)->comp(Decimal::fromFloat(1.0050000000001), 2));
    }
}
