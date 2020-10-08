<?php

namespace DesignPatterns\Behavioral\StrategyPattern;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var int
     */
    protected int $price;

    /**
     * @var int
     */
    protected int $count;

    /**
     * @var Strategy
     */
    protected Strategy $strategy;

    /**
     * Turnips constructor.
     * 
     * @param int $price
     * @param int $count
     * @param Strategy $strategy
     */
    public function __construct(int $price, int $count, Strategy $strategy = null)
    {
        $this->price = $price;
        $this->count = $count;
        $this->strategy = empty($strategy) ? new TurnipsStrategy() : $strategy;
    }

    /**
     * @param Strategy $strategy
     */
    public function setStrategy(Strategy $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->strategy->calculatePrice($this->price, $this->count);
    }
}
