<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Bells
 */
class Bells
{
    /**
     * @var int
     */
    protected int $bells;

    /**
     * Bells constructor.
     * 
     * @param int $bells
     */
    public function __construct(int $bells)
    {
        $this->setBells($bells);
    }

    /**
     * @param int $bells
     */
    public function setBells(int $bells)
    {
        $this->bells = $bells;
    }

    /**
     * @return int
     */
    public function getBells(): int
    {
        return $this->bells;
    }
}
