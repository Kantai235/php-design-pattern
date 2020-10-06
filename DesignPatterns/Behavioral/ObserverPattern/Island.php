<?php

namespace DesignPatterns\Behavioral\ObserverPattern;

use SplObjectStorage;
use SplObserver;
use SplSubject;

/**
 * Class Island.
 */
class Island implements SplSubject
{
    /**
     * 用來存放觀察者名單。
     * 
     * @var SplObjectStorage
     */
    protected SplObjectStorage $observers;

    /**
     * Island constructor.
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
        $this->sendMessages("有玩家加入了！");
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
        $this->sendMessages("有玩家離開了！");
    }

    /**
     * 通知觀察者。
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $observer->update();
        }
    }

    /**
     * @param string $message
     */
    public function sendMessages(string $message)
    {
        foreach ($this->observers as $observer) {
            $observer->sendMessage($message);
        }
    }
}
