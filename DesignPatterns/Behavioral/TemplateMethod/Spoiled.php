<?php

namespace DesignPatterns\Behavioral\TemplateMethod;

/**
 * Class Spoiled.
 */
class Spoiled extends TurnipsTemplate
{
    /**
     * @param int $price
     */
    public function setPrice(int $price)
    {
        $this->price = 0;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }
}