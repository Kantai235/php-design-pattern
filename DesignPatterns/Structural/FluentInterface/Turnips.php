<?php

namespace DesignPatterns\Structural\FluentInterface;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var int
     */
    protected $price = 0;

    /**
     * @var int
     */
    protected $count = 0;

    /**
     * @param int $price
     * 
     * @return Turnips
     */
    public function price(int $price): Turnips
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param int $count
     * 
     * @return Turnips
     */
    public function count(int $count): Turnips
    {
        $this->count = $count;

        return $this;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->price * $this->count;
    }
}
