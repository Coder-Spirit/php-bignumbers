<?php

namespace \Litipk\BigNumbers;

/**
 * Immutable object that represents a rational number
 * 
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
final class Decimal
{
	/**
	 * Single instance of "NaN"
	 * @var Decimal
	 */
	private static $NaN = null;

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
	private function __construct ()
	{

	}

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
			return self::getPositiveInfinite();
		} elseif ($fltValue === -INF) {
			return self::getNegativeInfinite();
		} elseif (is_nan($fltValue)) {
			return self::getNaN();
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
	 * Returns a "Negative Infinite" object
	 * @return Decimal
	 */
	public static function getPositiveInfinite ()
	{
		if (self::$pInf === null) {
			self::$pInf = new Decimal();

			self::$pInf->value = "+INF";
			self::$pInf->scale = 0;
		}

		return self::$pInf;
	}

	/**
	 * Returns a "Positive Infinite" object
	 * @return Decimal
	 */
	public static function getNegativeInfinite ()
	{
		if (self::$nInf === null) {
			self::$nInf = new Decimal();

			self::$nInf->value = "-INF";
			self::$nInf->scale = 0;
		}

		return self::$nInf;
	}

	/**
	 * Returns a "Not a Number" object
	 * @return Decimal
	 */
	public static function getNaN ()
	{
		if (self::$NaN === null) {
			self::$NaN = new Decimal();

			self::$NaN->value = "NaN";
			self::$NaN->scale = 0;
		}

		return self::$NaN;
	}

	/**
	 * Adds two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function add (Decimal $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->value === 'NaN' || $this->value === 'NaN') {
			return self::$NaN;
		}

		return self::create(bcadd($this->value, $b->value, max($this->scale, $b->scale)), $scale);
	}

	/**
	 * Subtracts two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function sub (Decimal $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->value === 'NaN' || $this->value === 'NaN') {
			return self::$NaN;
		}

		return self::create(bcsub($this->value, $b->value, max($this->scale, $b->scale)), $scale);
	}

	/**
	 * Multiplies two Decimal objects
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function mul (Decimal $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->value === 'NaN' || $this->value === 'NaN') {
			return self::$NaN;
		}

		return self::create(bcmul($this->value, $b->value, $this->scale + $b->scale), $scale);
	}

	/**
	 * Divides the object by $b
	 * @param  Decimal $b
	 * @param  integer $scale
	 * @return Decimal
	 */
	public function div (Decimal $b, $scale = null)
	{
		$this->internalOperatorValidation($b, $scale);

		if ($b->value === 'NaN' || $this->value === 'NaN') {
			return self::$NaN;
		}

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
