<?php

namespace DesignPatterns\Structural\DecoratorPattern;

/**
 * Class Turnips.
*/
class Turnips extends TurnipsDecorator
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->turnips->calculatePrice();
    }
}
