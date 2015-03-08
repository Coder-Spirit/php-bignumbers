<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\Decimal as Decimal;


/**
 * Static class that holds many important numeric constants
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
class NumConstants
{
    private static $PI = null;
    private static $E = null;
    private static $EulerMascheroni = null;

    private static $GoldenRatio = null;

    private static $LightSpeed = null;

    /**
     * Private constructor
     */
    private function __construct()
    {

    }

    /**
     * Private clone method
     */
    private function __clone()
    {

    }

    /**
     * Returns the Pi number.
     */
    public static function PI()
    {
        if (static::$PI === null) {
            static::$PI = Decimal::fromString(
                "3.14159265358979323846264338327950"
            );
        }
        return static::$PI;
    }

    /**
     * Returns the Euler's E number.
     */
    public static function E()
    {
        if (static::$E === null) {
            static::$E = Decimal::fromString(
                "2.71828182845904523536028747135266"
            );
        }
        return static::$E;
    }

    /**
     * Returns the Euler-Mascheroni constant.
     */
    public static function EulerMascheroni()
    {
        if (static::$EulerMascheroni === null) {
            static::$EulerMascheroni = Decimal::fromString(
                "0.57721566490153286060651209008240"
            );
        }
        return static::$EulerMascheroni;
    }

    /**
     * Returns the Golden Ration, also named Phi.
     */
    public static function GoldenRatio()
    {
        if (static::$GoldenRatio === null) {
            static::$GoldenRatio = Decimal::fromString(
                "1.61803398874989484820458683436564"
            );
        }
        return static::$GoldenRatio;
    }

    /**
     * Returns the Light of Speed measured in meters / second.
     */
    public static function LightSpeed()
    {
        if (static::$LightSpeed === null) {
            static::$LightSpeed = Decimal::fromInteger(299792458);
        }
        return static::$LightSpeed;
    }
}
