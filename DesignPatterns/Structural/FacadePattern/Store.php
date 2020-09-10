<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Class Store.
 */
class Store implements StoreInterface
{
    /**
     * @param Turnips $turnips
     * @param int          $price
     * 
     * @return int
     */
    public function sell(Turnips $turnips, int $price): int
    {
        return $turnips->getCount() * $price;
    }
}
