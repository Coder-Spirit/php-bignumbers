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
		if ($value === null) {
			throw new InvalidArgumentException('$value must be a non null number');
		}

		if ($scale !== null && (!is_int($scale) || $scale < 0)) {
			throw new InvalidArgumentException('$scale must be a positive integer');
		}

		if (is_int($value)) {
			$value = (string)$value;
		} elseif (is_float($value)) {

			if ($value === INF) {
				return self::getPositiveInfinite();
			} elseif ($value === -INF) {
				return self::getNegativeInfinite();
			} elseif (is_nan($value)) {
				return self::getNaN();
			}

			$value = number_format($value, ($scale === null) ? 8 : $scale, '.', '');	
		} elseif (is_string($value)) {
			if (preg_match('/^([1-9][0-9]*|0)(\.[0-9]+)?$/', $value) !== 1) {
				throw new InvalidArgumentException('$value passed as string must be something like 456.78 (with no leading zeros)');
			}
		}

		$decimal = new Decimal();

		if ($scale !== null) {
			$decimal->value = bcadd($value, '0', $scale);
			$decimal->scale = $scale;
		} else {
			$decimal->value = (string)$value;

			$point_pos = strpos($value, '.');

			if ($point_pos !== false) {
				$decimal->scale = strlen($value) - $point_pos - 1;
			} else {
				$decimal->scale = 0;
			}
		}

		return $decimal;
	}

	/**
	 * [getPositiveInfinite description]
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
	 * [getNegativeInfinite description]
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

			self::$NaN->value = "nan";
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
		$this->internal_operator_validation($b, $scale);

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
		$this->internal_operator_validation($b, $scale);

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
		$this->internal_operator_validation($b, $scale);

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
		$this->internal_operator_validation($b, $scale);

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
	 * Validates basic operator's arguments
	 * @param  Decimal $b     operand
	 * @param  int     $scale bcmath scale param
	 */
	private function internal_operator_validation (Decimal $b, $scale)
	{
		if ($b === null) {
			throw new InvalidArgumentException('$b must be not null');
		}

		if ($scale !== null && (!is_int($scale) || $scale < 0)) {
			throw new InvalidArgumentException('$scale must be a positive integer');
		}
	}
}
