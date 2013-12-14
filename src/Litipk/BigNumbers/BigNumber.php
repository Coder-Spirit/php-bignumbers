<?php

namespace Litipk\BigNumbers;

/**
 * BigNumber Interface
 * 
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
interface BigNumber
{
	/**
	 * Adds two big numbers
	 * 
	 * @param BigNumber $b
	 */
	public function add (BigNumber $b);

	/**
	 * Substracts $b from $this
	 * 
	 * @param  BigNumber $b
	 * @return BigNumber
	 */
	public function sub (BigNumber $b);

	/**
	 * Multiplies two big numbers
	 * 
	 * @param  BigNumber $b
	 * @return BigNumber
	 */
	public function mul (BigNumber $b);

	/**
	 * Divides $this by $b
	 * 
	 * @param  BigNumber $b
	 * @return BigNumber
	 */
	public function div (BigNumber $b);

	/**
	 * @return boolean
	 */
	public function isZero ();

	/**
	 * @return boolean
	 */
	public function isPositive ();

	/**
	 * @return boolean
	 */
	public function isNegative ();

	/**
	 * @return boolean
	 */
	public function isInfinite ();

	/**
	 * Says if this object is a "Not a Number"
	 * 
	 * @return boolean
	 */
	public function isNaN ();

	/**
	 * Equality comparison between this object and $b
	 * 
	 * @param  BigNumber $b
	 * @return boolean
	 */
	public function equals (BigNumber $b);
}
