<?php

namespace DesignPatterns\Structural\BridgePattern;

/**
 * Class TurnipsService.
 */
class TurnipsService extends BaseService
{
    /**
     * @return int
     */
    public function calculatePrice(): int
    {
        return $this->implementation->calculatePrice();
    }
}
