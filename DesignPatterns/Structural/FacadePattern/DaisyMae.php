<?php

namespace DesignPatterns\Structural\FacadePattern;

/**
 * Class DaisyMae.
 */
class DaisyMae implements DaisyMaeInterface
{
    /** 
     * @param int $price
     * @param int $count
     * 
     * @return Turnips
     */
    public function buy(int $price, int $count): Turnips
    {
        return new Turnips($price, $count);
    }
}
