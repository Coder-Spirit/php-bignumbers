<?php

namespace Litipk\BigNumbers;

interface IComparableNumber
{
	/**
	 * [comp description]
	 * @param  IComparableNumber $b [description]
	 * @return [type]               [description]
	 */
	public function comp (IComparableNumber $b);
}