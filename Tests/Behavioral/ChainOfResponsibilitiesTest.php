<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\ChainOfResponsibilities\Bag;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Handler;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible\BoxHandler;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Responsible\StoreHandler;
use DesignPatterns\Behavioral\ChainOfResponsibilities\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class ChainOfResponsibilitiesTest.
 */
class ChainOfResponsibilitiesTest extends TestCase
{
    /**
     * @var Bag
     */
    protected $bag;

    /**
     * @var Handler
     */
    protected $handler;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        /**
         * 設定背包。
         */
        $this->bag = new Bag();

        /**
         * 設定收購箱、商店。
         */
        $this->handler = new BoxHandler();
        $storeHandler = new StoreHandler();
        $this->handler->setUpperHandler($storeHandler);
    }

    /**
     * @test
     */
    public function test_sell_turnips_to_store()
    {
        $this->bag->setTurnips(new Turnips(100, 40));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(3600, $this->bag->getBells());
    }

    /**
     * @test
     */
    public function test_sell_turnips_to_box()
    {
        $this->bag->setTurnips(new Turnips(80, 20));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(1280, $this->bag->getBells());
    }

    /**
     * @test
     */
    public function test_sell_turnips_to_box_and_store()
    {
        $this->bag->setTurnips(new Turnips(80, 20));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(1280, $this->bag->getBells());

        $this->bag->setTurnips(new Turnips(100, 60));
        $this->bag = $this->handler->sellTurnips($this->bag);
        $this->assertEquals(6880, $this->bag->getBells());
    }
}
