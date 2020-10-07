<?php

namespace DesignPatterns\Behavioral\SpecificationPattern;

/**
 * Class TurnipsSpecification.
 */
class TurnipsSpecification implements Specification
{
    /**
     * @var Turnips[]
     */
    protected array $turnips;

    /**
     * Turnips constructor.
     * 
     * @param Turnips[] $turnips
     */
    public function __construct(Turnips ...$turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        $total = 0;
        foreach ($this->turnips as $turnip) {
            $total += $turnip->getPrice() * $turnip->getCount();
        }

        return $total;
    }
}
