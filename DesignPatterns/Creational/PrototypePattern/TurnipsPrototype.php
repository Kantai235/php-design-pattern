<?php

namespace DesignPatterns\Creational\PrototypePattern;

/**
 * Class TurnipsPrototype.
 */
abstract class TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category;

    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    abstract public function __clone();

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return $this->price * $this->count;
        } else {
            return 0;
        }
    }
}
