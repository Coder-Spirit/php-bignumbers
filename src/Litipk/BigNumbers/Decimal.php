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
	 * Internal numeric value
	 * @var string
	 */
	private $value;

	/**
	 * Number of decimals
	 * @var int
	 */
	private $scale;

	/**
	 * Decimal constructor.
	 * 
	 * @param mixed   $value
	 * @param integer $scale
	 */
	public function __construct ($value, $scale = null)
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
			$value = number_format($value, ($scale === null) ? 8 : $scale, '.', '');	
		} elseif (is_string($value)) {
			if (preg_match('/^([1-9][0-9]*|0)(\.[0-9]+)?$/', $value) !== 1) {
				throw new InvalidArgumentException('$value passed as string must be something like 456.78 (with no leading zeros)');
			}
		}

		if ($scale !== null) {
			$this->value = bcadd($value, '0', $scale);
			$this->scale = $scale;
		} else {
			$this->value = (string)$value;
			$this->scale = strlen($value) - strpos($value, '.') - 1;
		}
	}

	/**
	 * [add description]
	 * @param Decimal $b     [description]
	 * @param [type]  $scale [description]
	 */
	public function add (Decimal $b, $scale = null)
	{
		$this->internal_operator_validation($b, $scale);

		return new Decimal(bcadd($this->value, $b->value, max($this->scale, $b->scale)), $scale);
	}

	/**
	 * [sub description]
	 * @param  Decimal $b     [description]
	 * @param  [type]  $scale [description]
	 * @return [type]         [description]
	 */
	public function sub (Decimal $b, $scale = null)
	{
		$this->internal_operator_validation($b, $scale);

		return new Decimal(bcsub($this->value, $b->value, max($this->scale, $b->scale)), $scale);
	}

	/**
	 * [mul description]
	 * @param  Decimal $b     [description]
	 * @param  [type]  $scale [description]
	 * @return [type]         [description]
	 */
	public function mul (Decimal $b, $scale = null)
	{
		$this->internal_operator_validation($b, $scale);

		return new Decimal(bcmul($this->value, $b->value, $this->scale + $b->scale), $scale);
	}

	/**
	 * [div description]
	 * @param  Decimal $b     [description]
	 * @param  [type]  $scale [description]
	 * @return [type]         [description]
	 */
	public function div (Decimal $b, $scale = null)
	{
		$this->internal_operator_validation($b, $scale);

		return new Decimal(bcdiv($this->value, $b->value, $this->scale + $b->scale), $scale);
	}

	/**
	 * [__toString description]
	 * @return string [description]
	 */
	public function __toString ()
	{
		return $this->value;
	}

	/**
	 * [internal_operator_validation description]
	 * @param  Decimal $b     [description]
	 * @param  [type]  $scale [description]
	 * @return [type]         [description]
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
