<?php

namespace DesignPatterns\Structural\FlyweightPattern;

/**
 * Interface FlyweightInterface.
 */
interface FlyweightInterface
{
    /**
     * @return int
     */
    public function calculatePrice(): int;
}
