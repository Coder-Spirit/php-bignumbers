<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\BigNumber as BigNumber;
use Litipk\BigNumbers\IComparableNumber as IComparableNumber;
use Litipk\BigNumbers\NaN as NaN;

/**
 * Immutable object that represents an "infinite number"
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
final class Infinite implements BigNumber, IComparableNumber
{
    /**
     * Single instance of "Positive Infinite"
     * @var Decimal
     */
    private static $pInf = null;

    /**
     * Single instance of "Negative Infinite"
     * @var Decimal
     */
    private static $nInf = null;

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
     * Returns a "Positive Infinite" object
     * @return Decimal
     */
    public static function getPositiveInfinite()
    {
        if (self::$pInf === null) {
            self::$pInf = new Infinite();
        }

        return self::$pInf;
    }

    /**
     * Returns a "Negative Infinite" object
     * @return Decimal
     */
    public static function getNegativeInfinite()
    {
        if (self::$nInf === null) {
            self::$nInf = new Infinite();
        }

        return self::$nInf;
    }

    /**
     * @param  BigNumber $b
     * @return BigNumber
     */
    public function add(BigNumber $b)
    {
        if ($b->isNaN()) {
            return $b;
        } elseif (!$b->isInfinite()) {
            return $this;
        } elseif ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
            return $this;
        } else {
            return NaN::getNaN();
        }
    }

    /**
     * @param  BigNumber $b
     * @return BigNumber
     */
    public function sub(BigNumber $b)
    {
        if ($b->isNaN()) {
            return $b;
        } elseif (!$b->isInfinite()) {
            return $this;
        } elseif ($this->isNegative() && $b->isPositive() || $this->isPositive() && $b->isNegative()) {
            return $this;
        } else {
            return NaN::getNaN();
        }
    }

    /**
     * @param  BigNumber $b
     * @return BigNumber
     */
    public function mul(BigNumber $b)
    {
        if ($b->isNaN()) {
            return $b;
        } elseif ($b->isZero()) {
            return NaN::getNaN();
        } elseif ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
            return self::getPositiveInfinite();
        } else { // elseif ($this->isNegative() && $b->isPositive() || $this->isPositive() && $b->isNegative()) {
            return self::getNegativeInfinite();
        }
    }

    /**
     * @param  BigNumber $b
     * @return BigNumber
     */
    public function div(BigNumber $b)
    {
        if ($b->isNaN()) {
            return $b;
        } elseif ($b->isZero() || $b->isInfinite()) {
            return NaN::getNaN();
        } elseif ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
            return self::getPositiveInfinite();
        } else { // elseif ($this->isNegative() && $b->isPositive() || $this->isPositive() && $b->isNegative()) {
            return self::getNegativeInfinite();
        }
    }

    /**
     * @return boolean
     */
    public function isZero()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return ($this === self::getPositiveInfinite());
    }

    /**
     * @return boolean
     */
    public function isNegative()
    {
        return ($this === self::getNegativeInfinite());
    }

    /**
     * @return boolean
     */
    public function isInfinite()
    {
        return true;
    }

    /**
     * @return boolean
     */
    public function isNaN()
    {
        return false;
    }

    /**
     * @param  BigNumber $b
     * @return boolean
     */
    public function equals(BigNumber $b)
    {
        return $this === $b;
    }

    /**
     * @param  IComparableNumber $b
     * @return integer
     */
    public function comp(IComparableNumber $b)
    {
        if ($this === $b) {
            return 0;
        } elseif ($this === self::getPositiveInfinite()) {
            return 1;
        } else { // elseif ($this === self::getNegativeInfinite())
            return -1;
        }
    }
}
