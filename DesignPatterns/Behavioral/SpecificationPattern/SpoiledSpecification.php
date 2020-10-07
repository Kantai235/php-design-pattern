<?php

namespace DesignPatterns\Behavioral\SpecificationPattern;

/**
 * Class SpoiledSpecification.
 */
class SpoiledSpecification implements Specification
{
    /**
     * @var Specification[]
     */
    protected array $turnips;

    /**
     * SpoiledSpecification constructor.
     * 
     * @param Specification[] $turnips
     */
    public function __construct(Specification ...$turnips)
    {
        $this->turnips = $turnips;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return 0;
    }
}
