<?php

namespace DesignPatterns\Creational\FactoryMethod;

/**
 * Interface TurnipsFactoryContract.
 */
interface TurnipsFactoryContract
{
    public function createTurnips(): TurnipsContract;
}
