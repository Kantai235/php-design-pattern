<?php

namespace DesignPatterns\Structural\BridgePattern;

/**
 * Class BaseService.
 */
abstract class BaseService
{
    /**
     * @var TurnipsInterface
     */
    protected $implementation;

    /**
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->implementation = $turnips;
    }

    /**
     * @param TurnipsInterface $turnips
     */
    public function setImplementation(TurnipsInterface $turnips)
    {
        $this->implementation = $turnips;
    }

    abstract public function calculatePrice(): int;
}
