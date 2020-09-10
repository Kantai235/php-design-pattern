<?php

namespace DesignPatterns\Creational\SimpleFactory;

/**
 * Class TurnipsFactory.
 */
class TurnipsFactory
{
    /**
     * @return Turnips
     */
    public function createTurnips(): Turnips
    {
        return new Turnips();
    }
}
