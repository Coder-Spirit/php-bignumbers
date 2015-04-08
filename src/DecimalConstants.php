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
    private static $NEGATIVE_ONE = null;

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

    public static function zero()
    {
        if (self::$ZERO === null) {
            self::$ZERO = Decimal::fromInteger(0);
        }
        return self::$ZERO;
    }

    public static function one()
    {
        if (self::$ONE === null) {
            self::$ONE = Decimal::fromInteger(1);
        }
        return self::$ONE;
    }

    public static function negativeOne()
    {
        if (self::$NEGATIVE_ONE === null) {
            self::$NEGATIVE_ONE = Decimal::fromInteger(-1);
        }
        return self::$NEGATIVE_ONE;
    }

    /**
     * Returns the Pi number.
     * @return Decimal
     */
    public static function pi()
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
    public static function e()
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
    public static function eulerMascheroni()
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
    public static function goldenRatio()
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
    public static function lightSpeed()
    {
        if (self::$LightSpeed === null) {
            self::$LightSpeed = Decimal::fromInteger(299792458);
        }
        return self::$LightSpeed;
    }
}
