<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

/**
 * Class Turnips.
 */
class Turnips extends TurnipsTemplate
{
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
}