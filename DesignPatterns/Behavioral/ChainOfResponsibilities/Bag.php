<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities;

/**
 * Class Bag.
 */
class Bag
{
    /**
     * @var Turnips
     */
    protected Turnips $turnips;

    /**
     * @var int
     */
    protected int $bells = 0;

    /**
     * @param Turnips $turnips
     */
    public function setTurnips(Turnips $turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells = $bells;
    }

    /**
     * @return Turnips
     */
    public function getTurnips(): Turnips
    {
        return $this->turnips;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}
