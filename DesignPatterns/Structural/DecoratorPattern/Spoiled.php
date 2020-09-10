<?php

namespace DesignPatterns\Structural\DecoratorPattern;

/**
 * Class Spoiled.
*/
class Spoiled extends TurnipsDecorator
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return 0;
    }
}
