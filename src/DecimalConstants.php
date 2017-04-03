<?php
declare(strict_types=1);

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\Decimal as Decimal;


/**
 * Class that holds many important numeric constants
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
final class DecimalConstants
{
    /** @var Decimal */
    private static $ZERO = null;
    /** @var Decimal */
    private static $ONE = null;
    /** @var Decimal */
    private static $NEGATIVE_ONE = null;

    /** @var Decimal */
    private static $PI = null;
    /** @var Decimal */
    private static $EulerMascheroni = null;

    /** @var Decimal */
    private static $GoldenRatio = null;
    /** @var Decimal */
    private static $SilverRatio = null;
    /** @var Decimal */
    private static $LightSpeed = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function zero(): Decimal
    {
        if (null === self::$ZERO) {
            self::$ZERO = Decimal::fromInteger(0);
        }
        return self::$ZERO;
    }

    public static function one(): Decimal
    {
        if (null === self::$ONE) {
            self::$ONE = Decimal::fromInteger(1);
        }
        return self::$ONE;
    }

    public static function negativeOne(): Decimal
    {
        if (null === self::$NEGATIVE_ONE) {
            self::$NEGATIVE_ONE = Decimal::fromInteger(-1);
        }
        return self::$NEGATIVE_ONE;
    }

    /**
     * Returns the Pi number.
     * @return Decimal
     */
    public static function pi(): Decimal
    {
        if (null === self::$PI) {
            self::$PI = Decimal::fromString(
                "3.14159265358979323846264338327950"
            );
        }
        return self::$PI;
    }

    /**
     * Returns the Euler's E number.
     * @param  integer $scale
     * @return Decimal
     */
    public static function e(int $scale = 32): Decimal
    {
        if ($scale < 0) {
            throw new \InvalidArgumentException("\$scale must be positive.");
        }

        return self::$ONE->exp($scale);
    }

    /**
     * Returns the Euler-Mascheroni constant.
     * @return Decimal
     */
    public static function eulerMascheroni(): Decimal
    {
        if (null === self::$EulerMascheroni) {
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
    public static function goldenRatio(): Decimal
    {
        if (null === self::$GoldenRatio) {
            self::$GoldenRatio = Decimal::fromString(
                "1.61803398874989484820458683436564"
            );
        }
        return self::$GoldenRatio;
    }

    /**
     * Returns the Silver Ratio.
     * @return Decimal
     */
    public static function silverRatio(): Decimal
    {
        if (null === self::$SilverRatio) {
            self::$SilverRatio = Decimal::fromString(
                "2.41421356237309504880168872420970"
            );
        }
        return self::$SilverRatio;
    }

    /**
     * Returns the Light of Speed measured in meters / second.
     * @return Decimal
     */
    public static function lightSpeed(): Decimal
    {
        if (null === self::$LightSpeed) {
            self::$LightSpeed = Decimal::fromInteger(299792458);
        }
        return self::$LightSpeed;
    }
}
