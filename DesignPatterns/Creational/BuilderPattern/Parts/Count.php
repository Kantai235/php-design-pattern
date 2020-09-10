<?php

namespace DesignPatterns\Creational\BuilderPattern\Parts;

/**
 * Class Count.
 */
class Count
{
    /**
     * @var int
     */
    protected int $price = 0;

    /**
     * Price constructor.
     * 
     * @param int $price
     */
    public function __construct(int $count)
    {
        $this->set($count);
    }

    /**
     * @return int
     */
    public function get(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function set(int $count)
    {
        $this->count = $count;
    }
}
