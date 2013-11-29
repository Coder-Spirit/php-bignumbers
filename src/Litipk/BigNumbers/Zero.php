<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\BigNumber as BigNumber;
use Litipk\BigNumbers\IComparableNumber as IComparableNumber;
use Litipk\BigNumbers\AbelianAdditiveGroup as AbelianAdditiveGroup;

use Litipk\BigNumbers\NaN as NaN;

final class Zero implements BigNumber, IComparableNumber, AbelianAdditiveGroup
{
	/**
	 * Single instance of "Zero"
	 * @var Zero
	 */
	private static $zero = null;

	private function __construct () {}
	private function __clone () {}

	/**
	 * @return Zero
	 */
	public static function getZero ()
	{
		if (self::$zero === null) {
			self::$zero = new Zero();
		}

		return self::$zero;
	}

	/**
	 * [add description]
	 * @param BigNumber $b [description]
	 */
	public function add (BigNumber $b)
	{
		return $b;
	}

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function sub (BigNumber $b);
	{

	}

	/**
	 * [mul description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function mul (BigNumber $b);
	{
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isInfinite()) {
			return NaN::getNaN();
		} else {
			return $this;
		}
	}

	/**
	 * [div description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function div (BigNumber $b)
	{
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isZero()) {
			return NaN::getNaN();
		} else {
			return $this;
		}
	}

	/**
	 * [pow description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function pow (BigNumber $b)
	{
		if ($b->isNaN()) {
			return $b;
		} elseif ($b->isNegative()) {
			return NaN::getNaN();
		} else {
			return $this;
		}
	}

	/**
	 * [isZero description]
	 * @return boolean [description]
	 */
	public function isZero ()
	{
		return true;
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isPositive ()
	{
		return false;
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isNegative ();
	{
		return false;
	}

	/**
	 * [isInfinite description]
	 * @return boolean [description]
	 */
	public function isInfinite ();
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
	public function equals (BigNumber $b);
	{
		// @TODO: Analyze the possibility of variadic arguments
		//        for other types, such as Decimal...
		return $b === $this;
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
		} elseif ($b->isPositive()) {
			return -1;
		} elseif ($b->isNegative()) {
			return 1;
		}
	}

	/**
	 * [additiveInverse description]
	 * @return [type] [description]
	 */
	public function additiveInverse ()
	{
		return $this;
	}
}
