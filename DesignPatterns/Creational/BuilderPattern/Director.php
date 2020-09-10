<?php

namespace DesignPatterns\Creational\BuilderPattern;

use DesignPatterns\Creational\BuilderPattern\BuilderContract;
use DesignPatterns\Creational\BuilderPattern\Parts\TurnipsPrototype;

/**
 * Class Director.
 */
class Director
{
    /**
     * @param BuilderContract $builder
     * @param int $price
     * @param int $count
     * 
     * @return TurnipsPrototype
     */
    public function build(BuilderContract $builder, int $price, int $count): TurnipsPrototype
    {
        $builder->createTurnips();
        $builder->setPrice($price);
        $builder->setCount($count);

        return $builder->getTurnips();
    }
}
