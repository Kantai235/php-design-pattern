<?php

namespace DesignPatterns\Behavioral\MediatorPattern;

/**
 * Abstract Colleague.
 */
abstract class Colleague
{
    /**
     * @var Mediator
     */
    protected Mediator $mediator;

    /**
     * @param Mediator $mediator
     */
    public function setMediator(Mediator $mediator)
    {
        $this->mediator = $mediator;
    }
}