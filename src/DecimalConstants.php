<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\Decimal as Decimal;


/**
 * git statu class that holds many important numeric constants
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
final class DecimalConstants
{
    private static $ZERO = null;
    private static $ONE = null;

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

    public static function Zero()
    {
        if (self::$ZERO === null) {
            self::$ZERO = Decimal::fromString("0");
        }
        return self::$ZERO;
    }

    public static function One()
    {
        if (self::$ONE === null) {
            self::$ONE = Decimal::fromString("1");
        }
        return self::$ONE;
    }

    /**
     * Returns the Pi number.
     * @return Decimal
     */
    public static function PI()
    {
        if (self::$PI === null) {
            self::$PI = Decimal::fromString(
                "3.14159265358979323846264338327950"
            );
        }
        return self::$PI;
    }

    /**
     * Returns the Euler's E number.
     * @return Decimal
     */
    public static function E()
    {
        if (self::$E === null) {
            self::$E = Decimal::fromString(
                "2.71828182845904523536028747135266"
            );
        }
        return self::$E;
    }

    /**
     * Returns the Euler-Mascheroni constant.
     * @return Decimal
     */
    public static function EulerMascheroni()
    {
        if (self::$EulerMascheroni === null) {
            self::$EulerMascheroni = Decimal::fromString(
                "0.57721566490153286060651209008240"
            );
        }
        return self::$EulerMascheroni;
    }

    /**
     * Returns the Golden Ration, also named Phi.
     * @return Decimal
     */
    public static function GoldenRatio()
    {
        if (self::$GoldenRatio === null) {
            self::$GoldenRatio = Decimal::fromString(
                "1.61803398874989484820458683436564"
            );
        }
        return self::$GoldenRatio;
    }

    /**
     * Returns the Light of Speed measured in meters / second.
     * @return Decimal
     */
    public static function LightSpeed()
    {
        if (self::$LightSpeed === null) {
            self::$LightSpeed = Decimal::fromInteger(299792458);
        }
        return self::$LightSpeed;
    }
}
