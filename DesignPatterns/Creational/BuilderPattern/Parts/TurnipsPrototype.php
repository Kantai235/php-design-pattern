<?php

namespace DesignPatterns\Creational\BuilderPattern\Parts;

/**
 * Class TurnipsPrototype.
 */
abstract class TurnipsPrototype
{
    /**
     * @var Price
     */
    protected Price $price;

    /**
     * @var Count
     */
    protected Count $count;

    abstract public function calculatePrice(): int;

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = new Price($price);
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = new Count($count);
    }
}
