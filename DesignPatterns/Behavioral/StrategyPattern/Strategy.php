<?php

namespace DesignPatterns\Behavioral\StrategyPattern;

/**
 * Interface Strategy.
 */
interface Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int;
}
