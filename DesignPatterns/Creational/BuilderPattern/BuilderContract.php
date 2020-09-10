<?php

namespace DesignPatterns\Creational\BuilderPattern;

use DesignPatterns\Creational\BuilderPattern\Parts\TurnipsPrototype;

/**
 * Interface BuilderContract.
 */
interface BuilderContract
{
    public function createTurnips();

    public function setPrice(int $price);

    public function setCount(int $count);

    public function getTurnips(): TurnipsPrototype;
}
