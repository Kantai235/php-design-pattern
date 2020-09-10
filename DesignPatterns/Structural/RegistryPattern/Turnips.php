<?php

namespace DesignPatterns\Structural\RegistryPattern;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var string
     */
    protected string $island;

    /**
     * @var int
     */
    protected int $price;

    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param string $island
     * @param int $price
     * @param int $count
     */
    public function __construct(string $island, int $price, int $count)
    {
        $this->setIsland($island);
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @param string $island
     */
    public function setIsland(string $island)
    {
        $this->island = $island;
    }

    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return string
     */
    public function getIsland(): string
    {
        return $this->island;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }
}