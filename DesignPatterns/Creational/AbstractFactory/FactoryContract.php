<?php

namespace DesignPatterns\Creational\AbstractFactory;

/**
 * Interface FactoryContract.
 */
interface FactoryContract
{
    public function createTurnips(string $type, int $price, int $count): TurnipsContract;
}
