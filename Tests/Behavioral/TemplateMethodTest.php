<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\TemplateMethod\Spoiled;
use DesignPatterns\Behavioral\TemplateMethod\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class TemplateMethodTest.
 */
class TemplateMethodTest extends TestCase
{
    /**
     * @test
     */
    public function test_turnips_template()
    {
        $turnips = new Turnips(100, 40);

        $this->assertEquals(100, $turnips->getPrice());
        $this->assertEquals(40, $turnips->getCount());
        $this->assertEquals(4000, $turnips->calculatePrice());
    }

    /**
     * @test
     */
    public function test_spoiled_template()
    {
        $turnips = new Spoiled(100, 40);

        $this->assertEquals(0, $turnips->getPrice());
        $this->assertEquals(40, $turnips->getCount());
        $this->assertEquals(0, $turnips->calculatePrice());
    }
}
