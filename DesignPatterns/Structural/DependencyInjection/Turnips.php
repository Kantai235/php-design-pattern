<?php

namespace DesignPatterns\Structural\DependencyInjection;

/**
 * Class Turnips.
 */
class Turnips
{
    /**
     * @var TurnipsConfiguration
     */
    protected $configuration;

    /**
     * Turnips constructor.
     * 
     * @param TurnipsConfiguration $config
     */
    public function __construct(TurnipsConfiguration $config)
    {
        $this->configuration = $config;
    }

    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->configuration->getPrice() * $this->configuration->getCount();
    }
}
