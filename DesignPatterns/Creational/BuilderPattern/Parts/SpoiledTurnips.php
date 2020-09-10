<?php

namespace DesignPatterns\Creational\BuilderPattern\Parts;

/**
 * Class SpoiledTurnips.
 */
class SpoiledTurnips extends TurnipsPrototype
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count->get();
        } else {
            return 0;
        }
    }
}
