<?php

namespace DesignPatterns\Structural\FlyweightPattern;

use Countable;

/**
 * Class FlyweightFactory.
 */
class FlyweightFactory implements Countable
{
    /**
     * @var TurnipsFlyweight[]
     */
    protected $turnips = [];

    /**
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function get(string $island, int $price = 0, int $count = 0): TurnipsFlyweight
    {
        if (!isset($this->turnips[$island])) {
            $this->turnips[$island] = new TurnipsFlyweight($island, $price, $count);
        }

        return $this->turnips[$island];
    }

    /**
     * @return int
     */
    public function calculateTotal(): int
    {
        $total = 0;
        foreach ($this->turnips as $turnip) {
            $total += $turnip->calculatePrice();
        }

        return $total;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->turnips);
    }
}
