<?php

namespace DesignPatterns\Creational\SimpleFactory;

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
     * @param int $price
     * @param int $count
     * 
     * @return int
     */
    public function buy(int $price, int $count): int
    {
        $this->price = $price;
        $this->count = $count;

        return $this->calculatePrice();
    }

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
