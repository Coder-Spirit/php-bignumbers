<?php

namespace Litipk\BigNumbers;

use Litipk\BigNumbers\BigNumber as BigNumber;

/**
 * 
 */
final class NaN implements BigNumber
{
	/**
	 * Single instance of "NaN"
	 * @var Decimal
	 */
	private static $NaN = null;

	private function __construct () {}
	private function __clone () {}

	/**
	 * Returns a "Not a Number" object
	 * @return Decimal
	 */
	public static function getNaN ()
	{
		if (self::$NaN === null) {
			self::$NaN = new NaN();
		}

		return self::$NaN;
	}

	/**
	 * [add description]
	 * @param BigNumber $b [description]
	 */
	public function add (BigNumber $b)
	{
		return $this;
	}

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function sub (BigNumber $b)
	{
		return $this;
	}

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function mul (BigNumber $b)
	{
		return $this;
	}

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function div (BigNumber $b)
	{
		return $this;
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
		return false;
	}

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isNegative ()
	{
		return false;
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
	public function isNaN ()
	{
		return true;
	}

	/**
	 * [equals description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function equals (BigNumber $b)
	{
		return false;
	}
}
