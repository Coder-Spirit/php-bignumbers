<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\Decimal as Decimal;
use Litipk\BigNumbers\DecimalConstants as DecimalConstants;
use Litipk\Exceptions\InvalidCastException;
use Litipk\Exceptions\NotImplementedException;

/**
 * Immutable object that represents an infinite number
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
class InfiniteDecimal extends Decimal
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
     * @param string $value
     */
    private function __construct($value)
    {
        $this->value = $value;
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
            self::$pInf = new InfiniteDecimal('INF');
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
            self::$nInf = new InfiniteDecimal('-INF');
        }

        return self::$nInf;
    }

    /**
     * Adds two Decimal objects
     * @param  Decimal $b
     * @param  integer $scale
     * @return Decimal
     */
    public function add(Decimal $b, $scale = null)
    {
    	self::paramsValidation($b, $scale);

    	if (!$b->isInfinite()) {
            return $this;
        } elseif ($this->hasSameSign($b)) {
            return $this;
        } else { // elseif ($this->isPositive() && $b->isNegative || $this->isNegative() && $b->isPositive()) {
            throw new \DomainException("Infinite numbers with opposite signs can't be added.");
        }
    }

    /**
     * Subtracts two BigNumber objects
     * @param  Decimal $b
     * @param  integer $scale
     * @return Decimal
     */
    public function sub(Decimal $b, $scale = null)
    {
    	self::paramsValidation($b, $scale);

    	if (!$b->isInfinite()) {
            return $this;
        } elseif (!$this->hasSameSign($b)) {
            return $this;
        } else { // elseif () {
            throw new \DomainException("Infinite numbers with the same sign can't be subtracted.");
        }
    }

    /**
     * Multiplies two BigNumber objects
     * @param  Decimal $b
     * @param  integer $scale
     * @return Decimal
     */
    public function mul(Decimal $b, $scale = null)
    {
    	self::paramsValidation($b, $scale);

    	if ($b->isZero()) {
            throw new \DomainException("Zero multiplied by infinite is not allowed.");
        }

        if ($this->hasSameSign($b)) {
            return self::getPositiveInfinite();
        } else { // elseif (!$this->hasSameSign($b)) {
            return self::getNegativeInfinite();
        }
    }

    /**
     * Divides the object by $b .
     * Warning: div with $scale == 0 is not the same as
     *          integer division because it rounds the
     *          last digit in order to minimize the error.
     *
     * @param  Decimal $b
     * @param  integer $scale
     * @return Decimal
     */
    public function div(Decimal $b, $scale = null)
    {
    	self::paramsValidation($b, $scale);

    	if ($b->isZero()) {
            throw new \DomainException("Division by zero is not allowed.");
        } elseif ($b->isInfinite()) {
            throw new \DomainException("Infinite divided by Infinite is not allowed.");
        } elseif ($b->isPositive()) {
            return $this;
        } else { //if ($b->isNegative()) {
            return $this->additiveInverse();
        }
    }

    /**
     * Returns the square root of this object
     * @param  integer $scale
     * @return Decimal
     */
    public function sqrt($scale = null)
    {
        if ($this->isNegative()) {
            throw new \DomainException(
                "Decimal can't handle square roots of negative numbers (it's only for real numbers)."
            );
        }

        return $this;
    }

    /**
     * Powers this value to $b
     *
     * @param  Decimal  $b      exponent
     * @param  integer  $scale
     * @return Decimal
     */
    public function pow(Decimal $b, $scale = null)
    {
        if ($b->isPositive()) {
            if ($this->isPositive()) {
                return $this;
            }

            // if ($this->isNegative())
            if ($b->isInfinite()) {
                throw new \DomainException("Negative infinite elevated to infinite is undefined.");
            }

            if ($b->isInteger()) {
                if (preg_match('/^[+\-]?[0-9]*[02468](\.0+)?$/', $b->value, $captures) === 1) {
                    // $b is an even number
                    return self::$pInf;
                } else {
                    // $b is an odd number
                    return $this; // self::$nInf;
                }
            }

            throw new NotImplementedException("See issues #21, #22, #23 and #24 on Github.");

        } else if ($b->isNegative()) {
            return DecimalConstants::Zero();
        } else if ($b->isZero()) {
            throw new \DomainException("Infinite elevated to zero is undefined.");
        }
    }

    /**
     * Returns the object's logarithm in base 10
     * @param  integer $scale
     * @return Decimal
     */
    public function log10($scale = null)
    {
        if ($this->isNegative()) {
            throw new \DomainException(
                "Decimal can't handle logarithms of negative numbers (it's only for real numbers)."
            );
        }

        return $this;
    }

    /**
     * Equality comparison between this object and $b
     * @param  Decimal $b
     * @param integer $scale
     * @return boolean
     */
    public function equals(Decimal $b, $scale = null)
    {
    	return ($this === $b);
    }

    /**
     * $this > $b : returns 1 , $this < $b : returns -1 , $this == $b : returns 0
     *
     * @param  Decimal $b
     * @param  integer $scale
     * @return integer
     */
    public function comp(Decimal $b, $scale = null)
    {
        self::paramsValidation($b, $scale);

        if ($this === $b) {
            return 0;
        } elseif ($this === self::getPositiveInfinite()) {
            return 1;
        } else { // if ($this === self::getNegativeInfinite()) {
            return -1;
        }
    }

    /**
     * Returns the element's additive inverse.
     * @return Decimal
     */
    public function additiveInverse()
    {
        if ($this === self::getPositiveInfinite()) {
            return self::$nInf;
        } else { // if ($this === self::getNegativeInfinite()) {
            return self::$pInf;
        }
    }

    /**
     * "Rounds" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function round($scale = 0)
    {
    	return $this;
    }

    /**
     * "Ceils" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function ceil($scale = 0)
    {
    	return $this;
    }

    /**
     * "Floors" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function floor($scale = 0)
    {
    	return $this;
    }

    public function sin($scale = null)
    {
        throw new \DomainException(($this === self::$pInf) ?
            "Sine function hasn't limit in the positive infinite." :
            "Sine function hasn't limit in the negative infinite."
        );
    }

    public function cos($scale = null)
    {
        throw new \DomainException(($this === self::$pInf) ?
            "Cosine function hasn't limit in the positive infinite." :
            "Cosine function hasn't limit in the negative infinite."
        );
    }

    public function tan($scale = null)
    {
        throw new \DomainException(($this === self::$pInf) ?
            "Tangent function hasn't limit in the positive infinite." :
            "Tangent function hasn't limit in the negative infinite."
        );
    }

    /**
     * @param  integer $scale Has no effect, exists only for compatibility.
     * @return boolean
     */
    public function isZero($scale = null)
    {
    	return false;
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return ($this === self::$pInf);
    }

    /**
     * @return boolean
     */
    public function isNegative()
    {
        return ($this === self::$nInf);
    }

    /**
     * @return boolean
     */
    public function isInteger()
    {
        return false;
    }

    /**
     * @return boolean
     */
    public function isInfinite()
    {
        return true;
    }

    /**
     * Return value as a float
     *
     * @return float
     */
    public function asFloat()
    {
        return ($this === self::$pInf) ? INF : -INF;
    }

    /**
     * Return value as a integer
     *
     * @return float
     */
    public function asInteger()
    {
        throw new InvalidCastException("InfiniteDecimal", "int", "PHP integers can't represent infinite values.");
    }
}
