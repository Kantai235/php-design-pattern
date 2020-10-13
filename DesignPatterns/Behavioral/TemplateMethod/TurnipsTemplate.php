<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

/**
 * Abstract TurnipsTemplate.
 */
abstract class TurnipsTemplate
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * @var int
     */
    protected int $count = 0;

    /**
     * TurnipsTemplate constructor.
     * 
     * @param int $price
     * @param int $count
     */
    public function __construct(int $price, int $count)
    {
        $this->setPrice($price);
        $this->setCount($count);
    }

    /**
     * @return int
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * @param int $price
     */
    abstract public function setPrice(int $price);

    /**
     * @param int $count
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
        $price = $this->price;
        $count = $this->count;
        return $price * $count;
    }
}
