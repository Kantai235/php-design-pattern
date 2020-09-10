<?php

namespace DesignPatterns\Structural\CompositePattern;

/**
 * Class Turnips.
 */
class Turnips implements TurnipsInterface
{
    /**
     * @var int
     */
    protected $price;

    /**
     * @var int
     */
    protected $count;

    /**
     * @var TurnipsInterface[]
     */
    protected $elements = [];

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
     * @return int
     */
    public function calculatePrice(): int
    {
        $_price = $this->price;
        foreach ($this->elements as $element) {
            $_price += $element->calculatePrice();
        }

        return $_price * $this->count;
    }

    /**
     * @param TurnipsInterface $element
     */
    public function addElement(TurnipsInterface $element)
    {
        array_push($this->elements, $element);
    }
}
