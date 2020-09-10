<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Bag;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;

/**
 * Class BoxHandler.
 */
class BoxHandler extends Handler
{
    /**
     * @param Bag $bag
     */
    public function sellTurnips(Bag $bag): Bag
    {
        $bells = function(int $oldBells, int $price, int $count) {
            $_bells = ($price * $count) * 0.8;
            $_bells += $oldBells;
            return $_bells;
        };

        if ($bag->getTurnips()->getCount() >= 20) {
            $newBells = $bells($bag->getBells(), $bag->getTurnips()->getPrice(), 20);
            $bag->setBells($newBells);
            $bag->getTurnips()->setCount($bag->getTurnips()->getCount() - 20);

            return $this->upper->sellTurnips($bag);
        }

        $newBells = $bells($bag->getBells(), $bag->getTurnips()->getPrice(), $bag->getTurnips()->getCount());
        $bag->setBells($newBells);
        $bag->getTurnips()->setCount(0);

        return $bag;
    }
}
