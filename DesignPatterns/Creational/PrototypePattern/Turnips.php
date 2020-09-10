<?php

namespace DesignPatterns\Creational\PrototypePattern;

/**
 * Class Turnips.
 */
class Turnips extends TurnipsPrototype
{
    /**
     * @var string
     */
    protected $category = '大頭菜';

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
     * ...
     */
    public function __clone()
    {
        // TODO: Implement __Clone() method.
    }
}
