<?php

namespace DesignPatterns\Behavioral\MementoPattern;

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
     * @return Memento
     */
    public function saveToMemento(): Memento
    {
        return new Memento($this->price, $this->count);
    }

    /**
     * @param Memento $memento
     */
    public function restoreFromMemento(Memento $memento)
    {
        $this->price = $memento->getPrice();
        $this->count = $memento->getCount();
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

    /**
     * @return int
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
    }

    /**
     * @return int
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->getPrice() * $this->getCount();
    }
}
