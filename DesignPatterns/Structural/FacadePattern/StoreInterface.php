<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Interface StoreInterface.
 */
interface StoreInterface
{
    /**
     * @param Turnips $turnips
     * @param int          $price
     * 
     * @return int
     */
    public function sell(Turnips $turnips, int $price): int;
}
