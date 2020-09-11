<?php

namespace DesignPatterns\Behavioral\CommandPattern;

/**
 * Class Invoker.
 */
class Invoker
{
    /**
     * @var Command
     */
    protected Command $command;

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return void
     */
    public function run()
    {
        $this->command->execute();
    }
}
