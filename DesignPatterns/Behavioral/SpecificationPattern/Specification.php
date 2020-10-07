<?php

namespace DesignPatterns\Behavioral\SpecificationPattern;

/**
 * Interface Specification.
 */
interface Specification
{
    /**
     * @return int
     */
    public function calculatePrice(): int;
}
