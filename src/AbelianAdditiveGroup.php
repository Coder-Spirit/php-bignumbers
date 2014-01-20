<?php

namespace Litipk\BigNumbers;

/**
 * Immutable object that represents an element from an abelian additive group
 *
 * @author Andreu Correa Casablanca <castarco@litipk.com>
 */
interface AbelianAdditiveGroup
{
    /**
     * Returns the element's additive inverse.
     *
     * @return AbelianAdditiveGroup
     */
    public function additiveInverse();
}
