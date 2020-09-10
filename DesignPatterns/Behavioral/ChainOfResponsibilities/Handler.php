<?php

namespace DesignPatterns\Behavioral\ChainOfResponsibilities;

/**
 * Abstract Handler.
 */
abstract class Handler
{
    /**
     * @var Handler
     */
    protected $upper;

    /**
     * @param Handler $upper
     */
    public function setUpperHandler(Handler $upper)
    {
        $this->upper = $upper;
    }

    /**
     * @param Bag $bag
     */
    abstract public function sellTurnips(Bag $bag): Bag;
}
