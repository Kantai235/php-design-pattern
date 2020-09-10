<?php

namespace DesignPatterns\Creational\BuilderPattern\Parts;

/**
 * Class Turnips.
 */
class Turnips extends TurnipsPrototype
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return $this->price->get() * $this->count->get();
        } else {
            return 0;
        }
    }
}