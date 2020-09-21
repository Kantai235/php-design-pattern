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
    protected MediatorInterface $mediator;

    /**
     * @param Mediator $mediator
     */
    public function setMediator(MediatorInterface $mediator)
    {
        $this->mediator = $mediator;
    }
}
