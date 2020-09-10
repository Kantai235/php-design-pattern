<?php

namespace DesignPatterns\Structural\AdapterPattern;

/**
 * Class Turnips.
 */
class Turnips implements TurnipsInterface
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
     * Turnips constructor.
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
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * 
     * @return int
     */
    public function setPrice(int $price): int
    {
        $this->price = $price;

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
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     * 
     * @return int
     */
    public function setCount(int $count): int
    {
        $this->count = $count;

        return $this->count;
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
