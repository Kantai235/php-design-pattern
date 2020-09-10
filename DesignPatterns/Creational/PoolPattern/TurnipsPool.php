<?php

namespace DesignPatterns\Creational\PoolPattern;

use Countable;

/**
 * Class TurnipsPool.
 */
class TurnipsPool implements Countable
{
    /**
     * @var Turnips[]
     */
    protected $pool = [];

    /**
     * @var int
     */
    protected $total = 0;

    /**
     * @return Turnips
     */
    public function get(string $key = null): Turnips
    {
        if (isset($key)) {
            $turnips = $this->pool[$key];
            unset($this->pool[$key]);
        } else {
            $turnips = array_pop($this->pool);
        }

        $this->total -= $turnips->calculatePrice();

        return $turnips;
    }

    /**
     * 把大頭菜塞到池子裡
     *
     * @param Turnips $turnips
     * 
     * @return string
     */
    public function set(Turnips $turnips): string
    {
        $key = spl_object_hash($turnips);
        $this->total += $turnips->calculatePrice();
        $this->pool[$key] = $turnips;

        return $key;
    }

    /**
     * @return int
     */
    public function total(): int
    {
        return $this->total;
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->pool);
    }
}
