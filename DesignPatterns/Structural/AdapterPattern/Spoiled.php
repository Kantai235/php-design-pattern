<?php

namespace DesignPatterns\Structural\AdapterPattern;

/**
 * Class Spoiled.
 */
class Spoiled implements SpoiledInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * Spoiled constructor.
     *
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->price = $price;
        $this->count = $count;
    }

    /**
     * @param int $pirce
     * 
     * @return int
     */
    public function risePrice(int $price): int
    {
        $this->price += $price;

        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function fallPrice(int $price): int
    {
        $this->price -= $price;

        return $this->price;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function addCount(int $count): int
    {
        $this->count += $count;

        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function subCount(int $count): int
    {
        $this->count -= $count;

        return $this->count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        if (isset($this->price) && isset($this->count)) {
            return 0 * $this->count;
        } else {
            return 0;
        }
    }
}
