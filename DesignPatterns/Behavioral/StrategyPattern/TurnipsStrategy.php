<?php

namespace DesignPatterns\Behavioral\StrategyPattern;

/**
 * Class TurnipsStrategy.
 */
class TurnipsStrategy implements Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int
    {
        return $price * $count;
    }
}
