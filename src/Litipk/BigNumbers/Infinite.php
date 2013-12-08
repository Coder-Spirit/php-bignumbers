<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\BigNumber as BigNumber;
use Litipk\BigNumbers\IComparableNumber as IComparableNumber;

use Litipk\BigNumbers\NaN as NaN;

/**
 * 
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

	
	private function __construct () {}
	private function __clone () {}

	/**
	 * Returns a "Positive Infinite" object
	 * @return Decimal
	 */
	public static function getPositiveInfinite ()
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
	public static function getNegativeInfinite ()
	{
		if (self::$nInf === null) {
			self::$nInf = new Infinite();
		}

		return self::$nInf;
	}

	/**
	 * [add description]
	 * @param BigNumber $b [description]
	 */
	public function add (BigNumber $b)
	{
		if ($b->isNaN()) {
			return $b;
		} elseif (!$b->isInfinite()) {
			return $this;
		} else if ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
			return $this;
		} else {
			return NaN::getNaN();
		}
	}

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function sub (BigNumber $b)
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
	 * [mul description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function mul (BigNumber $b) {
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero()) {
			return NaN::getNaN();
		} elseif ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
			return self::getPositiveInfinite();
		} elseif ($this->isNegative() && $b->isPositive() || $this->isPositive() && $b->isNegative()) {
			return self::getNegativeInfinite();
		}
	}

	/**
	 * [div description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function div (BigNumber $b) {
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero() || $b->isInfinite()) {
			return NaN::getNaN();
		} elseif ($this->isPositive() && $b->isPositive() || $this->isNegative() && $b->isNegative()) {
			return self::getPositiveInfinite();
		} elseif ($this->isNegative() && $b->isPositive() || $this->isPositive() && $b->isNegative()) {
			return self::getNegativeInfinite();
		}
	}

	/**
	 * [pow description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function pow (BigNumber $b) {
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero()) {
			return NaN::getNaN();
		} elseif ($b->isNegative()) {
			return Zero::getZero();
		} elseif ($this->isPositive()) {
			return $this;
		} elseif ($this->isNegative()) {
			// @TODO: That's a "hard" case.
		}
	}

	/**
	 * [isZero description]
	 * @return boolean [description]
	 */
	public function isZero ()
	{
		return false;
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isPositive ()
	{
		return ($this === self::getPositiveInfinite());
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isNegative ()
	{
		return ($this === self::getNegativeInfinite());
	}

	/**
	 * [isInfinite description]
	 * @return boolean [description]
	 */
	public function isInfinite ()
	{
		return true;
	}

	/**
	 * [isNaN description]
	 * @return boolean [description]
	 */
	public function isNaN ()
	{
		return false;
	}

	/**
	 * [equals description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function equals (BigNumber $b)
	{
		return $this === $b;
	}

	/**
	 * [comp description]
	 * @param  IComparableNumber $b [description]
	 * @return [type]               [description]
	 */
	public function comp (IComparableNumber $b)
	{
		if ($this === $b) {
			return 0;
		} elseif ($this === self::getPositiveInfinite()) {
			return 1;
		} elseif ($this === self::getNegativeInfinite()) {
			return -1;
		}
	}
}
