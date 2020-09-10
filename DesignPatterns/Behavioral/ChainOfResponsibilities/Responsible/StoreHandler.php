<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Bag;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;

/**
 * Class StoreHandler.
 */
class StoreHandler extends Handler
{
    /**
     * @param Bag $bag
     */
    public function sellTurnips(Bag $bag): Bag
    {
        $bells = $bag->getTurnips()->getPrice() * $bag->getTurnips()->getCount();
        $bells += $bag->getBells();
        $bag->getTurnips()->setCount(0);
        $bag->setBells($bells);

        return $bag;
    }
}