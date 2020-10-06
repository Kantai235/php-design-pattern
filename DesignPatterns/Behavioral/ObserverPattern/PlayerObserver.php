<?php

namespace DesignPatterns\Behavioral\ObserverPattern;

use SplObserver;
use SplSubject;

/**
 * Class PlayerObserver.
 */
class PlayerObserver implements SplObserver
{
    /**
     * @var string
     */
    protected string $user;

    /**
     * @var SplSubject[]
     */
    protected array $observers = [];
    
    /**
     * PlayerObserver constructor.
     * 
     * @param string $user
     */
    public function __construct(string $user)
    {
        $this->user = $user;
    }

    /**
     * @param SplSubject $subject
     */
    public function update(SplSubject $subject)
    {
        // TODO: Implement update() method.
    }

    /**
     * @param string $message
     */
    public function sendMessage(string $message)
    {
        echo "[$this->user 收到通知] $message";
    }
}
