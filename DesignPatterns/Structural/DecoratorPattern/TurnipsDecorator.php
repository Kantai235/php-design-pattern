<?php

namespace DesignPatterns\Structural\DecoratorPattern;

/**
 * Class TurnipsDecorator.
 */
abstract class TurnipsDecorator implements TurnipsInterface
{
    /**
     * @var TurnipsInterface
     */
    protected $turnips;

    /**
     * TurnipsDecorator constructor.
     * 
     * @param TurnipsInterface $turnips
     */
    public function __construct(TurnipsInterface $turnips)
    {
        $this->turnips = $turnips;
    }
}
