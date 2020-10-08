<?php

namespace DesignPatterns\Behavioral\StrategyPattern;

/**
 * Class SpoliedStrategy.
 */
class SpoliedStrategy implements Strategy
{
    /**
     * @return int
     */
    public function calculatePrice(int $price, int $count): int
    {
        return 0;
    }
}
