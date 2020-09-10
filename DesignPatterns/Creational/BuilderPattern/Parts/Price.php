<?php

namespace DesignPatterns\Creational\BuilderPattern\Parts;

/**
 * Class Price.
 */
class Price
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * Price constructor.
     * 
     * @param int $price
     */
    public function __construct(int $price)
    {
        $this->set($price);
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     */
    public function set(int $price)
    {
        $this->price = $price;
    }
}
