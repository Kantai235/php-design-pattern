<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Turnips
 */
class Turnips
{
    /**
     * @var int
     */
    protected int $count;

    /**
     * Turnips constructor.
     * 
     * @param int $count
     */
    public function __construct(int $count)
    {
        $this->setCount($count);
    }

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
    public function getCount(): int
    {
        return $this->count;
    }
}
