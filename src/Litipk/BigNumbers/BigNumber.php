<?php

namespace Litipk\BigNumbers;

/**
 * 
 */
interface BigNumber
{
	/**
	 * [add description]
	 * @param BigNumber $b [description]
	 */
	public function add (BigNumber $b);

	/**
	 * [sub description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function sub (BigNumber $b);

	/**
	 * [mul description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function mul (BigNumber $b);

	/**
	 * [div description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function div (BigNumber $b);

	/**
	 * [pow description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function pow (BigNumber $b);

	/**
	 * [isZero description]
	 * @return boolean [description]
	 */
	public function isZero ();

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isPositive ();

	/**
	 * [isPositive description]
	 * @return boolean [description]
	 */
	public function isNegative ();

	/**
	 * [isInfinite description]
	 * @return boolean [description]
	 */
	public function isInfinite ();

	/**
	 * [isNaN description]
	 * @return boolean [description]
	 */
	public function isNaN ();

	/**
	 * [equals description]
	 * @param  BigNumber $b [description]
	 * @return [type]       [description]
	 */
	public function equals (BigNumber $b);
}
