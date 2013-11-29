<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\BigNumber as BigNumber;
use Litipk\BigNumbers\IComparableNumber as IComparableNumber;
use Litipk\BigNumbers\AbelianAdditiveGroup as AbelianAdditiveGroup;

use Litipk\BigNumbers\NaN as NaN;
use Litipk\BigNumbers\Zero as Zero;
use Litipk\BigNumbers\Infinite as Infinite;

/**
 * Immutable object that represents a rational number
 * 
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
final class Decimal implements BigNumber, IComparableNumber, AbelianAdditiveGroup
{
	/**
	 * Internal numeric value
	 * @var string
	 */
	private $value;

	/**
	 * Number of decimals
	 * @var integer
	 */
	private $scale;

	/**
	 * Private constructor
	 */
	private function __construct () {}
	private function __clone () {}

	/**
	 * Decimal "constructor".
	 * 
	 * @param mixed   $value
	 * @param integer $scale
	 */
	public static function create ($value, $scale = null)
	{
		if (is_int(($value))) {
			return self::fromInteger($value, $scale);
		} elseif (is_float($value)) {
			return self::fromFloat($value, $scale);
		} elseif (is_string($value)) {
			return self::fromString($value, $scale);
		} elseif ($value instanceof Decimal) {
			return self::fromDecimal($value, $scale);
		} else {
			throw new InvalidArgumentException('Invalid type');
		}
	}

	/**
	 * @param  integer $intValue
	 * @param  integer $scale
	 * @return Decimal
	 */
	public static function fromInteger ($intValue, $scale = null)
	{
		$this->internalConstructorValidation($decValue, $scale);

		if (!is_int($intValue)) {
			throw new InvalidArgumentException('$intValue must be an int');
		}

		$decimal = new Decimal();

		$decimal->value = (string)$value;
		$decimal->scale = $scale === null ? 0 : $scale;

		return $decimal;
	}

	/**
	 * @param  float   $fltValue
	 * @param  integer $scale
	 * @return Decimal
	 */
	public static function fromFloat ($fltValue, $scale = null)
	{
		$this->internalConstructorValidation($decValue, $scale);

		if (!is_float($fltValue)) {
			throw new InvalidArgumentException('$fltValue must be a float');
		}

		if ($fltValue === INF) {
			return Infinite::getPositiveInfinite();
		} elseif ($fltValue === -INF) {
			return Infinite::getNegativeInfinite();
		} elseif (is_nan($fltValue)) {
			return NaN::getNaN();
		}

		$decimal = new Decimal();

		$decimal->value = number_format($value, $scale === null ? 8 : $scale, '.', '');
		$decimal->scale = $scale === null ? 8 : $scale;

		return $decimal;
	}

	/**
	 * @param  string  $strValue
	 * @param  integer $scale
	 * @return Decimal
	 */
	public static function fromString ($strValue, $scale = null)
	{
		$this->internalConstructorValidation($decValue, $scale);

		if (!is_string($strValue)) {
			throw new InvalidArgumentException('$strValue must be a string');
		}

		if (preg_match('/^([+\-]?)0*(([1-9][0-9]*|[0-9])(\.[0-9]+)?)$/', $strValue, $captures) === 1) {

			// Now it's time to strip leading zeros in order to normalize inner values
			$sign      = ($captures[1]==='') ? '+' : $captures[1];
			$value     =  $captures[2];
			$dec_scale = $scale !== null ? $scale : max(0, strlen($captures[4])-1);

		} elseif (preg_match('/([+\-]?)([0-9](\.[0-9]+)?)[eE]([+\-]?)([1-9][0-9]*)/', $strValue, $captures) === 1) {

			// Now it's time to "unroll" the exponential notation to basic positional notation
			$sign     = ($captures[1]==='') ? '+' : $captures[1];
			$mantissa = $captures[2];

			$mantissa_scale = strlen($captures[3])-1;

			$exp_sign = ($captures[4]==='') ? '+' : $captures[4];
			$exp_val  = (int)$captures[5];

			if ($exp_sign === '+') {
				$min_scale      = ($mantissa_scale-$exp_val > 0) ? $mantissa_scale-$exp_val : 0;
				$tmp_multiplier = bcpow(10, $exp_val);
			} else {
				$min_scale      = $mantissa_scale + $exp_val;
				$tmp_multiplier = bcpow(10, -$exp_val, $exp_val);
			}

			$value     = bcmul($mantissa, $tmp_multiplier, max($min_scale, $scale !== null ? $scale : 0));
			$dec_scale = $scale !== null ? $scale : $min_scale;

		} else {
			throw new InvalidArgumentException('$strValue must be a string that represents uniquely a float point number');
		}

		if ($exp_sign === '-') {
			$value = '-'.$value;
		}

		if ($scale !== null) {
			$value = bcadd($value, '0', $scale);
		}

		$decimal = new Decimal();

		$decimal->value = $value;
		$decimal->scale = $dec_scale;

		return $decimal;
	}

	/**
	 * Constructs a new Decimal object based on a previous one,
	 * but changing it's $scale property.
	 * 
	 * @param  Decimal  $decValue
	 * @param  integer  $scale
	 * @return Decimal
	 */
	public static function fromDecimal (Decimal $decValue, $scale = null)
	{
		$this->internalConstructorValidation($decValue, $scale);

		// This block protect us from unnecessary additional instances
		if (
			$scale === null || $scale === $decValue->$scale ||
			$decValue === self::$NaN  ||
			$decValue === self::$pInf ||
			$decValue === self::$nInf
		) {
			return $decValue;
		}

		$decimal = new Decimal();

		$decimal->value = bcadd($decValue->value, '0', $scale);
		$decimal->scale = $scale;

		return $decimal;
	}

	/**
	 * Adds two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function add (BigNumber $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->isNaN() || $b->isInfinite()) {
			return $b;
		} elseif ($b->isZero()) {
			return $this;
		} elseif ($b instanceof Decimal) {
			if ($this->additiveInverse()->equals($b, $scale)) {
				return Zero::getZero();
			}

			return self::create(bcadd($this->value, $b->value, max($this->scale, $b->scale)), $scale);
		} else {
			try { // Hack to support new unknown classes. We use the commutative property
				return $b->add($this);
			} catch (Exception $e) {
				// @TODO : Throw a "not implemented exception"
			}
		}
	}

	/**
	 * Subtracts two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function sub (BigNumber $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isInfinite() && $b->isPositive()) {
			return Infinite::getNegativeInfinite();
		} elseif ($b->isInfinite() && $b->isNegative()) {
			return Infinite::getPositiveInfinite();
		} elseif ($b instanceof Decimal) {
			if ($this->equals($b, $scale)) {
				return Zero::getZero();
			}

			return self::create(bcsub($this->value, $b->value, max($this->scale, $b->scale)), $scale);
		} else {
			if ($b instanceof AbelianAdditiveGroup) {
				try { // Hack to support new unknown classes.
					return $b->additiveInverse()->add($this);
				} catch (Exception $e) {
					// @TODO : Throw a "not implemented exception"
				}
			}
			// @TODO : Throw a "not implemented exception"
		}
	}

	/**
	 * Multiplies two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function mul (BigNumber $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero()) {
			return $b;
		} elseif ($b->isInfinite()) {
			if ($b->isPositive() && $this->isPositive() || $b->isNegative() && $this->isNegative()) {
				return Infinite::getPositiveInfinite();
			} elseif ($b->isPositive() && $this->isNegative() || $b->isNegative() && $this->isPositive()) {
				return Infinite::getNegativeInfinite();
			}
		} elseif ($b instanceof Decimal) {
			return self::create(bcmul($this->value, $b->value, $this->scale + $b->scale), $scale);
		} else {
			try { // Hack to support new unknown classes. We use the commutative property
				return $b->mul($this);
			} catch (Exception $e) {
				// @TODO : Throw a "not implemented exception"
			}
		}
	}

	/**
	 * Divides the object by $b
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function div (BigNumber $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero()) {
			return NaN::getNaN();
		} elseif ($b->isInfinite()) {
			return Zero::getZero();
		} elseif ($b instanceof Decimal) {
			$maxscale = max($this->scale, $b->scale);

			if ($maxscale === 0) {
				if ($this->value >= $b->value) {
					$divscale = 2;
				} else {
					$divscale = log10($b->value) + 2;
				}
			} else {
				$divscale = $this->scale + $b->scale;
			}

			return self::create(bcdiv($this->value, $b->value, $divscale), $scale);
		} else {
			// @TODO : Throw a "not implemented exception" 
		}
	}

	/**
	 * [pow description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function pow (BigNumber $b) {
		if ($b->isNaN()) {
			return NaN::getNaN();
		} elseif ($b->isZero()) {
			return Decimal::fromInteger(1);
		} elseif ($b instanceof Decimal) {
			// @TODO : Throw a "not implemented exception"
		} else {
			// @TODO : @WARNING : what happens if $this ~= -1 and $b ~= 0.5 ? exception? NaN? Complex?
		}
	}

	/**
	 * [isZero description]
	 * @return boolean [description]
	 */
	public function isZero ($scale = null) {
		$cmp_scale = $scale !== null ? $scale : $this->scale;

		return (bccomp($this->value, '0', $cmp_scale) == 0);
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isPositive ()
	{
		return ($this->value[0] !== '-');
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isNegative ()
	{
		return ($this->value[0] === '-');
	}

	/**
	 * [isInfinite description]
	 * @return boolean [description]
	 */
	public function isInfinite ()
	{
		return false;
	}

	/**
	 * [isNaN description]
	 * @return boolean [description]
	 */
	public function isNaN ();
	{
		return false;
	}

	/**
	 * [equals description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function equals (BigNumber $b, $scale = null);
	{
		if ($this === $b) {
			return true;
		} elseif ($b instanceof Decimal) {
			$cmp_scale = $scale !== null ? $scale : max($this->scale)

			return (bccomp($this->value, $b->value, $cmp_scale) == 0);
		} else {
			// @TODO: Consider other number types...
			return false;
		}
	}

	/**
	 * @return string
	 */
	public function __toString ()
	{
		return $this->value;
	}

	/**
	 * Validates basic constructor's arguments
	 * @param  mixed    $value
	 * @param  integer  $scale
	 */
	private function internalConstructorValidation ($value, $scale)
	{
		if ($value === null) {
			throw new InvalidArgumentException('$value must be a non null number');
		}

		if ($scale !== null && (!is_int($scale) || $scale < 0)) {
			throw new InvalidArgumentException('$scale must be a positive integer');
		}
	}

	/**
	 * Validates basic operator's arguments
	 * @param  Decimal  $b      operand
	 * @param  integer  $scale  bcmath scale param
	 */
	private function internalOperatorValidation (Decimal $b, $scale)
	{
		if ($b === null) {
			throw new InvalidArgumentException('$b must be not null');
		}

		if ($scale !== null && (!is_int($scale) || $scale < 0)) {
			throw new InvalidArgumentException('$scale must be a positive integer');
		}
	}
}
