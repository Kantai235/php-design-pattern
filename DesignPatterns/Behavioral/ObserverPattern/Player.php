<?php

namespace DesignPatterns\Behavioral\ObserverPattern;

use SplObjectStorage;
use SplObserver;
use SplSubject;

/**
 * Class Player.
 */
class Player implements SplSubject
{
    /**
     * @var string
     */
    protected string $email;

    /**
     * @var SplObjectStorage
     */
    protected SplObjectStorage $observers;

    /**
     * Player constructor.
     */
    public function __construct()
    {
        $this->observers = new SplObjectStorage();
    }

    /**
     * 賦予觀察者物件。
     * 
     * @param SplObserver $observer
     */
    public function attach(SplObserver $observer)
    {
        $this->observers->attach($observer);
    }

    /**
     * 抽離觀察者物件。
     * 
     * @param SplObserver $observer
     */
    public function detach(SplObserver $observer)
    {
        $this->observers->detach($observer);
    }

    /**
     * 通知觀察者，讓全島民都知道你來了。
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    /**
     * 
     */
    public function join()
    {
        $this->notify();
    }

    /**
     * 
     */
    public function quit()
    {
        $this->notify();
    }
}
