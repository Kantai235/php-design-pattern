<?php

namespace DesignPatterns\Creational\BuilderPattern;

use DesignPatterns\Creational\BuilderPattern\Parts\Turnips;

/**
 * Class TurnipsBuilder.
 */
class TurnipsBuilder implements BuilderContract
{
    /**
     * @var Turnips
     */
    protected Turnips $turnips;

    /**
     * 
     */
    public function createTurnips()
    {
        $this->turnips = new Turnips();
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->turnips->setPrice($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->turnips->setCount($count);
    }

    /**
     * @return Turnips
     */
    public function getTurnips(): Turnips
    {
        return $this->turnips;
    }
}
