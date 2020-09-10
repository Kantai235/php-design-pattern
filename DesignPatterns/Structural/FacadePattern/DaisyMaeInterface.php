<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Interface DaisyMaeInterface.
 */
interface DaisyMaeInterface
{
    /** 
     * @param int $price
     * @param int $count
     * 
     * @return Turnips
     */
    public function buy(int $price, int $count): Turnips;
}
