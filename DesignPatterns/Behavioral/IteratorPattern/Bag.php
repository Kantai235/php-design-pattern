<?php

namespace DesignPatterns\Behavioral\IteratorPattern;

use Countable;
use Iterator;

/**
 * Class Bag.
 */
class Bag implements Countable, Iterator
{
    /**
     * @var Turnips[]
     */
    protected array $turnips = [];

    /**
     * @var int
     */
    protected int $currentIndex = 0;

    /**
     * @param Turnips
     */
    public function addTurnips(Turnips $turnips)
    {
        $this->turnips[] = $turnips;
    }

    /**
     * @param Turnips
     */
    public function removeTurnips(Turnips $turnipsToRemove)
    {
        foreach ($this->turnips as $key => $turnip) {
            if ($turnip->getIsland() === $turnipsToRemove->getIsland()) {
                unset($this->turnips[$key]);
            }
        }

        $this->turnips = array_values($this->turnips);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->turnips);
    }

    /**
     * @return Turnips
     */
    public function current(): Turnips
    {
        return $this->turnips[$this->currentIndex];
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->currentIndex;
    }

    /**
     * @return void
     */
    public function next()
    {
        $this->currentIndex++;
    }

    /**
     * @return void
     */
    public function rewind()
    {
        $this->currentIndex = 0;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return isset($this->turnips[$this->currentIndex]);
    }
}
