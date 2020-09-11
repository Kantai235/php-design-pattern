<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\CommandPattern\BuyCommand;
use DesignPatterns\Behavioral\CommandPattern\Invoker;
use DesignPatterns\Behavioral\CommandPattern\Receiver;
use DesignPatterns\Behavioral\CommandPattern\SellCommand;
use PHPUnit\Framework\TestCase;

/**
 * Class CommandPatternTest.
 */
class CommandPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_invocation()
    {
        $invoker = new Invoker();
        $receiver = new Receiver();
        $receiver->setBells(10000);

        $invoker->setCommand(new BuyCommand($receiver, 100, 40));
        $invoker->run();
        $this->assertSame(6000, $receiver->getBells());

        $invoker->setCommand(new SellCommand($receiver, 200, 40));
        $invoker->run();
        $this->assertSame(14000, $receiver->getBells());
    }
}
