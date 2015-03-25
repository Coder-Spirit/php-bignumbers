<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\InfiniteDecimal as InfiniteDecimal;

use Litipk\Exceptions\NotImplementedException as NotImplementedException;
use Litipk\Exceptions\InvalidArgumentTypeException as InvalidArgumentTypeException;

/**
 * Immutable object that represents a rational number
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
class Decimal
{
    /**
     * Internal numeric value
     * @var string
     */
    protected $value;

    /**
     * Number of digits behind the point
     * @var integer
     */
    private $scale;

    /**
     * Private constructor
     * @param integer $scale
     * @param string $value
     */
    private function __construct($value, $scale)
    {
        $this->value = $value;
        $this->scale = $scale;
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
        return InfiniteDecimal::getPositiveInfinite();
    }

    /**
     * Returns a "Negative Infinite" object
     * @return Decimal
     */
    public static function getNegativeInfinite()
    {
        return InfiniteDecimal::getNegativeInfinite();
    }

    /**
     * Decimal "constructor".
     *
     * @param mixed   $value
     * @param integer $scale
     */
    public static function create($value, $scale = null)
    {
        if (is_int($value)) {
            return self::fromInteger($value, $scale);
        } elseif (is_float($value)) {
            return self::fromFloat($value, $scale);
        } elseif (is_string($value)) {
            return self::fromString($value, $scale);
        } elseif ($value instanceof Decimal) {
            return self::fromDecimal($value, $scale);
        } else {
            throw new InvalidArgumentTypeException(
                array('int', 'float', 'string', 'Decimal'),
                is_object($value) ? get_class($value) : gettype($value),
                'Invalid argument type.'
            );
        }
    }

    /**
     * @param  integer $intValue
     * @param  integer $scale
     * @return Decimal
     */
    public static function fromInteger($intValue, $scale = null)
    {
        self::paramsValidation($intValue, $scale);

        if (!is_int($intValue)) {
            throw new InvalidArgumentTypeException(
                array('int'),
                is_object($intValue) ? get_class($intValue) : gettype($intValue),
                '$intValue must be of type int'
            );
        }

        return new Decimal(
            $scale === null ? (string)$intValue : bcadd((string)$intValue, '0', $scale),
            $scale === null ? 0 : $scale
        );
    }

    /**
     * @param  float   $fltValue
     * @param  integer $scale
     * @return Decimal
     */
    public static function fromFloat($fltValue, $scale = null)
    {
        self::paramsValidation($fltValue, $scale);

        if (!is_float($fltValue)) {
            throw new InvalidArgumentTypeException(
                array('float'),
                is_object($fltValue) ?
                    get_class($fltValue) :
                    gettype($fltValue),
                '$fltValue must be of type float'
            );
        } elseif ($fltValue === INF) {
            return InfiniteDecimal::getPositiveInfinite();
        } elseif ($fltValue === -INF) {
            return InfiniteDecimal::getNegativeInfinite();
        } elseif (is_nan($fltValue)) {
            throw new \DomainException(
                "To ensure consistency, this class doesn't handle NaN objects."
            );
        }

        $dec_scale = $scale === null ?
            8 :
            $scale;

        return new Decimal(
            number_format($fltValue, $dec_scale, '.', ''),
            $dec_scale
        );
    }

    /**
     * @param  string  $strValue
     * @param  integer $scale
     * @return Decimal
     */
    public static function fromString($strValue, $scale = null)
    {
        self::paramsValidation($strValue, $scale);

        if (!is_string($strValue)) {
            throw new InvalidArgumentTypeException(
                array('string'),
                is_object($strValue) ? get_class($strValue) : gettype($strValue),
                '$strVlue must be of type string.'
            );
        } elseif (preg_match('/^([+\-]?)0*(([1-9][0-9]*|[0-9])(\.[0-9]+)?)$/', $strValue, $captures) === 1) {

            // Now it's time to strip leading zeros in order to normalize inner values
            $value     = self::normalizeSign($captures[1]) . $captures[2];

            $min_scale = isset($captures[4]) ?
                max(0, strlen($captures[4])-1) :
                0;

        } elseif (preg_match('/([+\-]?)0*([0-9](\.[0-9]+)?)[eE]([+\-]?)(\d+)/', $strValue, $captures) === 1) {

            $mantissa_scale = max(strlen($captures[3])-1, 0);

            $exp_val  = (int)$captures[5];

            if (self::normalizeSign($captures[4]) === '') {
                $min_scale      = max($mantissa_scale-$exp_val, 0);
                $tmp_multiplier = bcpow(10, $exp_val);
            } else {
                $min_scale      = $mantissa_scale + $exp_val;
                $tmp_multiplier = bcpow(10, -$exp_val, $exp_val);
            }

            $value = self::normalizeSign($captures[1]) . bcmul(
                $captures[2],
                $tmp_multiplier,
                max(
                    $min_scale,
                    $scale !== null ? $scale : 0
                )
            );

        } else {
            throw new \InvalidArgumentException(
                '$strValue must be a string that represents uniquely a float point number.'
            );
        }

        if ($scale!==null) {
            $dec_scale = $scale;
        } else {
            $dec_scale = $min_scale;
        }

        return new Decimal(
            self::innerRound($value, $dec_scale),
            $dec_scale
        );
    }

    /**
     * Constructs a new Decimal object based on a previous one,
     * but changing it's $scale property.
     *
     * @param  Decimal  $decValue
     * @param  integer  $scale
     * @return Decimal
     */
    public static function fromDecimal(Decimal $decValue, $scale = null)
    {
        self::paramsValidation($decValue, $scale);

        // This block protect us from unnecessary additional instances
        if ($scale === null || $scale === $decValue->scale || $decValue->isInfinite()) {
            return $decValue;
        }

        return new Decimal(
            self::innerRound($decValue->value, $scale),
            $scale
        );
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

        if ($b->isInfinite()) {
            return $b;
        }

        return self::fromString(
            bcadd($this->value, $b->value, max($this->scale, $b->scale)),
            $scale
        );
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

        if ($b->isInfinite()) {
            return $b->additiveInverse();
        }

        return self::fromString(
            bcsub($this->value, $b->value, max($this->scale, $b->scale)),
            $scale
        );
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

        if ($b->isInfinite()) {
            return $b->mul($this);
        } elseif ($b->isZero()) {
            return Decimal::fromInteger(0, $scale);
        }

        return self::fromString(
            bcmul($this->value, $b->value, $this->scale + $b->scale),
            $scale
        );
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
        } elseif ($this->isZero()) {
            return self::fromDecimal($this, $scale);
        } elseif ($b->isInfinite()) {
            return Decimal::fromInteger(0, $scale);
        } else {
            if ($scale !== null) {
                $divscale = $scale;
            } else {
                // $divscale is calculated in order to maintain a reasonable precision
                $this_abs = $this->abs();
                $b_abs    = $b->abs();

                $log10_result =
                    self::innerLog10($this_abs->value, $this_abs->scale, 1) -
                    self::innerLog10($b_abs->value, $b_abs->scale, 1);

                $divscale = max(
                    $this->scale + $b->scale,
                    max(
                        self::countSignificativeDigits($this, $this_abs),
                        self::countSignificativeDigits($b, $b_abs)
                    ) - max(ceil($log10_result), 0),
                    ceil(-$log10_result)
                );
            }

            return self::fromString(
                bcdiv($this->value, $b->value, $divscale+1),
                $divscale
            );
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
        } elseif ($this->isZero()) {
            return Decimal::fromDecimal($this, $scale);
        }

        $sqrt_scale = ($scale !== null ? $scale : $this->scale);

        return self::fromString(
            bcsqrt($this->value, $sqrt_scale+1),
            $sqrt_scale
        );
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
        if ($this->isZero()) {
            if ($b->isPositive()) {
                return Decimal::fromDecimal($this, $scale);
            } else {
                throw new \DomainException(
                    "zero can't be powered to zero or negative numbers."
                );
            }
        } elseif ($b->isZero()) {
            return Decimal::fromInteger(1, $scale);
        } elseif ($b->scale == 0) {
            $pow_scale = $scale === null ?
                max($this->scale, $b->scale) : max($this->scale, $b->scale, $scale);

            return self::fromString(
                bcpow($this->value, $b->value, $pow_scale+1),
                $pow_scale
            );
        } else {
            if ($this->isPositive()) {
                $pow_scale = $scale === null ?
                    max($this->scale, $b->scale) : max($this->scale, $b->scale, $scale);

                $truncated_b = bcadd($b->value, '0', 0);
                $remaining_b = bcsub($b->value, $truncated_b, $b->scale);

                $first_pow_approx = bcpow($this->value, $truncated_b, $pow_scale+1);
                $intermediate_root = self::innerPowWithLittleExponent(
                    $this->value,
                    $remaining_b,
                    $b->scale,
                    $pow_scale+1
                );

                return Decimal::fromString(
                    bcmul($first_pow_approx, $intermediate_root, $pow_scale+1),
                    $pow_scale
                );
            } else { // elseif ($this->isNegative())
                throw new NotImplementedException(
                    "Usually negative numbers can't be powered to non integer numbers. " .
                    "The cases where is possible are not implemented."
                );
            }
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
        } elseif ($this->isZero()) {
            return InfiniteDecimal::getNegativeInfinite();
        }

        return self::fromString(
            self::innerLog10($this->value, $this->scale, $scale !== null ? $scale+1 : $this->scale+1),
            $scale
        );
    }

    /**
     * @return boolean
     */
    public function isZero($scale = null)
    {
        $cmp_scale = $scale !== null ? $scale : $this->scale;

        return (bccomp(self::innerRound($this->value, $cmp_scale), '0', $cmp_scale) === 0);
    }

    /**
     * @return boolean
     */
    public function isPositive()
    {
        return ($this->value[0] !== '-' && !$this->isZero());
    }

    /**
     * @return boolean
     */
    public function isNegative()
    {
        return ($this->value[0] === '-');
    }

    /**
     * @return boolean
     */
    public function isInfinite()
    {
        return false;
    }

    /**
     * Equality comparison between this object and $b
     * @param  Decimal $b
     * @param integer $scale
     * @return boolean
     */
    public function equals(Decimal $b, $scale = null)
    {
        self::paramsValidation($b, $scale);

        if ($this === $b) {
            return true;
        } elseif ($b->isInfinite()) {
            return false;
        } else {
            $cmp_scale = $scale !== null ? $scale : max($this->scale, $b->scale);

            return (
                bccomp(
                    self::innerRound($this->value, $cmp_scale),
                    self::innerRound($b->value, $cmp_scale),
                    $cmp_scale
                ) == 0
            );
        }
    }

    /**
     * $this > $b : returns 1 , $this < $b : returns -1 , $this == $b : returns 0
     *
     * @param  Decimal $b
     * @return integer
     */
    public function comp(Decimal $b, $scale = null)
    {
        self::paramsValidation($b, $scale);

        if ($this === $b) {
            return 0;
        } elseif ($b->isInfinite()) {
            return -$b->comp($this);
        }

        return bccomp(
            self::innerRound($this->value, $scale),
            self::innerRound($b->value, $scale),
            $scale
        );
    }

    /**
     * Returns the element's additive inverse.
     * @return Decimal
     */
    public function additiveInverse()
    {
        if ($this->isZero()) {
            return $this;
        } elseif ($this->isNegative()) {
            $value = substr($this->value, 1);
        } else { // if ($this->isPositive()) {
            $value = '-' . $this->value;
        }

        return new Decimal($value, $this->scale);
    }


    /**
     * "Rounds" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function round($scale = 0)
    {
        if ($scale >= $this->scale) {
            return $this;
        }

        return self::fromString(self::innerRound($this->value, $scale));
    }

    /**
     * "Ceils" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function ceil($scale = 0)
    {
        if ($scale >= $this->scale) {
            return $this;
        }

        $rounded = bcadd($this->value, '0', $scale);

        $rlen = strlen($rounded);
        $tlen = strlen($this->value);

        $mustCeil = false;
        for ($i=$tlen-1; $i >= $rlen; $i--) {
            if ((int)$this->value[$i] > 0) {
                $mustCeil = true;
                break;
            }
        }

        if ($mustCeil) {
            $rounded = bcadd($rounded, bcpow('10', -$scale, $scale), $scale);
        }

        return self::fromString($rounded, $scale);
    }

    /**
     * "Floors" the Decimal to have at most $scale digits after the point
     * @param  integer $scale
     * @return Decimal
     */
    public function floor($scale = 0)
    {
        if ($scale >= $this->scale) {
            return $this;
        }

        return self::fromString(bcadd($this->value, '0', $scale));
    }

    /**
     * Returns the absolute value (always a positive number)
     * @return Decimal
     */
    public function abs()
    {
        if ($this->isZero() || $this->isPositive()) {
            return $this;
        }

        return $this->additiveInverse();
    }

    /**
     * Calculate modulo with a decimal
     * @param $d
     * @return $this % $d
     */
    public function mod(Decimal $d, $scale = null)
    {
        // integer division
        $div = $this->div($d, 1)->floor();
        return $this->sub($div->mul($d, $scale));
    }

    /**
     * Calculates the sine of this method with the highest possible accuracy
     * Note that accuracy is limited by the accuracy of predefined PI;
     *
     * @param integer $scale
     * @return Decimal sin($this)
     */
    public function sin($scale = null) {
        // First normalise the number in the [0, 2PI] domain
        $twoPi = NumConstants::PI()->mul(Decimal::fromString("2"));
        $x = $this->mod($twoPi);
        $zero = Decimal::fromString("0");

        // PI has only 32 siginficant numbers
        $significantNumbers = is_null($scale) ? 32 : $scale;

        // Next use Maclaurin's theorem to approximate sin with high enough accuracy
        // note that the accuracy is depended on the accuracy of the given PI constant
        $faculty = Decimal::fromString("1");    // Calculates the faculty under the sign
        $loopCounter = 1;                       // Calculates the iteration we are in
        $xPowerN = Decimal::fromString("1");    // Calculates x^n
        $approx = Decimal::fromString("0");     // keeps track of our approximation for sin(x)

        while (true) {
            // update x^n and n! for this walkthrough
            $xPowerN = $xPowerN->mul($x);
            $faculty = $faculty->mul(Decimal::fromString((string) $loopCounter));

            // only do calculations if n is uneven
            // otherwise result is zero anyways
            if ($loopCounter % 2 === 1) {
                // calculate the absolute change in this iteration.
                $change = $xPowerN->div($faculty);

                // change should be added if x mod 4 == 1 and subtracted if x mod 4 == 3
                if ($loopCounter % 4 === 1) {
                    $approx = $approx->add($change);
                } else {
                    $approx = $approx->sub($change);
                }

                // Terminate the method if our change is sufficiently small
                if ($change->floor($significantNumbers)->equals($zero)) {
                    return $approx->round($significantNumbers);
                }
            }


            $loopCounter++;
        }
    }

    /**
     * Calculates the cosine of this method with the highest possible accuracy
     * Note that accuracy is limited by the accuracy of predefined PI;
     *
     * @param integer $scale
     * @return Decimal cos($this)
     */
    public function cos($scale = null) {
        // First normalise the number in the [0, 2PI] domain
        $twoPi = NumConstants::PI()->mul(Decimal::fromString("2"));
        $x = $this->mod($twoPi);
        $zero = Decimal::fromString("0");

        // PI has only 32 siginficant numbers
        $significantNumbers = is_null($scale) ? 32 : $scale;

        // Next use Maclaurin's theorem to approximate sin with high enough accuracy
        // note that the accuracy is depended on the accuracy of the given PI constant
        $faculty = Decimal::fromString("1");    // Calculates the faculty under the sign
        $loopCounter = 1;                       // Calculates the iteration we are in
        $xPowerN = Decimal::fromString("1");    // Calculates x^n
        $approx = Decimal::fromString("1");     // keeps track of our approximation for sin(x)

        while (true) {
            // update x^n and n! for this walkthrough
            $xPowerN = $xPowerN->mul($x);
            $faculty = $faculty->mul(Decimal::fromString((string) $loopCounter));

            // only do calculations if n is uneven
            // otherwise result is zero anyways
            if ($loopCounter % 2 === 0) {
                // calculate the absolute change in this iteration.
                $change = $xPowerN->div($faculty);

                // change should be added if x mod 4 == 1 and subtracted if x mod 4 == 3
                if ($loopCounter % 4 === 0) {
                    $approx = $approx->add($change);
                } else {
                    $approx = $approx->sub($change);
                }

                // Terminate the method if our change is sufficiently small
                if ($change->floor($significantNumbers )->equals($zero)) {
                    return $approx->round($significantNumbers);
                }
            }


            $loopCounter++;
        }
    }

    /**
     * Calculates the tangent of this method with the highest possible accuracy
     * Note that accuracy is limited by the accuracy of predefined PI;
     *
     * @param integer $scale
     * @return Decimal tan($this)
     */
    public function tan($scale = null) {
        return $this->sin($scale + 2)
            ->div($this->cos($scale + 2))
            ->floor($scale);
    }

    public function hasSameSign(Decimal $b) {
        return $this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative();
    }

    /**
     * Return value as a float
     *
     * @return float
     */
    public function asFloat()
    {
        return floatval($this->value);
    }

    /**
     * Return value as a integer
     *
     * @return float
     */
    public function asInteger()
    {
        return intval($this->value);
    }

    /**
     * Return the inner representation of the class
     * use with caution
     *
     * @return number
     */
    public function _innerValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * "Rounds" the decimal string to have at most $scale digits after the point
     *
     * @param  string  $value
     * @param  integer $scale
     * @return string
     */
    private static function innerRound($value, $scale = 0)
    {
        $rounded = bcadd($value, '0', $scale);

        $diffDigit = bcsub($value, $rounded, $scale+1);
        $diffDigit = (int)$diffDigit[strlen($diffDigit)-1];

        if ($diffDigit >= 5) {
            $rounded = bcadd($rounded, bcpow('10', -$scale, $scale), $scale);
        }

        return $rounded;
    }

    /**
     * Calculates the logarithm (in base 10) of $value
     *
     * @param  string  $value     The number we want to calculate its logarithm (only positive numbers)
     * @param  integer $in_scale  Expected scale used by $value (only positive numbers)
     * @param  integer $out_scale Scale used by the return value (only positive numbers)
     * @return string
     */
    private static function innerLog10($value, $in_scale, $out_scale)
    {
        $value_len = strlen($value);

        $cmp = bccomp($value, '1', $in_scale);

        switch ($cmp) {
            case 1:
                $value_log10_approx = $value_len - ($in_scale > 0 ? ($in_scale+2) : 1);

                return bcadd(
                    $value_log10_approx,
                    log10(bcdiv(
                        $value,
                        bcpow('10', $value_log10_approx),
                        min($value_len, $out_scale)
                    )),
                    $out_scale
                );
            case -1:
                preg_match('/^0*\.(0*)[1-9][0-9]*$/', $value, $captures);
                $value_log10_approx = -strlen($captures[1])-1;

                return bcadd(
                    $value_log10_approx,
                    log10(bcmul(
                        $value,
                        bcpow('10', -$value_log10_approx),
                        $in_scale + $value_log10_approx
                    )),
                    $out_scale
                );
            default: // case 0:
                return '0';
        }
    }

    /**
     * Returns $base^$exponent
     *
     * @param  string $base
     * @param  string $exponent   0 < $exponent < 1
     * @param  integer $exp_scale Number of $exponent's significative digits
     * @param  integer $out_scale Number of significative digits that we want to compute
     * @return string
     */
    private static function innerPowWithLittleExponent($base, $exponent, $exp_scale, $out_scale)
    {
        $inner_scale = ceil($exp_scale*log(10)/log(2))+1;

        $result_a = '1';
        $result_b = '0';

        $actual_index = 0;
        $exponent_remaining = $exponent;

        while (bccomp($result_a, $result_b, $out_scale) !== 0 && bccomp($exponent_remaining, '0', $inner_scale) !== 0) {
            $result_b = $result_a;
            $index_info = self::computeSquareIndex($exponent_remaining, $actual_index, $exp_scale, $inner_scale);
            $exponent_remaining = $index_info[1];
            $result_a = bcmul(
                $result_a,
                self::compute2NRoot($base, $index_info[0], 2*($out_scale+1)),
                2*($out_scale+1)
            );
        }

        return self::innerRound($result_a, $out_scale);
    }

    /**
     * Auxiliar method. It helps us to decompose the exponent into many summands.
     *
     * @param  string  $exponent_remaining
     * @param  integer $actual_index
     * @param  integer $exp_scale           Number of $exponent's significative digits
     * @param  integer $inner_scale         ceil($exp_scale*log(10)/log(2))+1;
     * @return string
     */
    private static function computeSquareIndex($exponent_remaining, $actual_index, $exp_scale, $inner_scale)
    {
        $actual_rt = bcpow('0.5', $actual_index, $exp_scale);
        $r = bcsub($exponent_remaining, $actual_rt, $inner_scale);

        while (bccomp($r, 0, $exp_scale) === -1) {
            ++$actual_index;
            $actual_rt = bcmul('0.5', $actual_rt, $inner_scale);
            $r = bcsub($exponent_remaining, $actual_rt, $inner_scale);
        }

        return array($actual_index, $r);
    }

    /**
     * Auxiliar method. Computes $base^((1/2)^$index)
     *
     * @param  string  $base
     * @param  integer $index
     * @param  integer $out_scale
     * @return string
     */
    private static function compute2NRoot($base, $index, $out_scale)
    {
        $result = $base;

        for ($i=0; $i<$index; $i++) {
            $result = bcsqrt($result, ($out_scale+1)*($index-$i)+1);
        }

        return self::innerRound($result, $out_scale);
    }

    /**
     * Validates basic constructor's arguments
     * @param  mixed    $value
     * @param  integer  $scale
     */
    protected static function paramsValidation($value, $scale)
    {
        if ($value === null) {
            throw new \InvalidArgumentException('$value must be a non null number');
        }

        if ($scale !== null && (!is_int($scale) || $scale < 0)) {
            throw new \InvalidArgumentException('$scale must be a positive integer');
        }
    }

    /**
     * @return string
     */
    private static function normalizeSign($sign)
    {
        if ($sign==='+') {
            return '';
        }

        return $sign;
    }

    /**
     * Counts the number of significative digits of $val
     *
     * @param  Decimal $val
     * @param  Decimal $abs $val->abs()
     * @return integer
     */
    private static function countSignificativeDigits(Decimal $val, Decimal $abs)
    {
        $one = Decimal::fromInteger(1);

        return strlen($val->value) - (
            ($abs->comp($one) === -1) ? 2 : max($val->scale, 1)
        ) - ($val->isNegative() ? 1 : 0);
    }
}
