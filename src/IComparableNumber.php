<?php

namespace Litipk\BigNumbers;

/**
 * Interface to represent objects that allows an "absolute order"
 * 
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
interface IComparableNumber
{
    /**
     * Compares two objects that allows an "absolute order"
     * 
     * @param  IComparableNumber $b
     * @return integer              (-1 -> lesser, 0 -> equals, 1 -> greater)
     */
    public function comp(IComparableNumber $b);
}
