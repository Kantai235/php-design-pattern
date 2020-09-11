<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\IteratorPattern\Bag;
use DesignPatterns\Behavioral\IteratorPattern\Turnips;
use PHPUnit\Framework\TestCase;

/**
 * Class IteratorPatternTest.
 */
class IteratorPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_can_iterate_over_bag()
    {
        $bag = new Bag();
        $bag->addTurnips(new Turnips('Island_A', 100, 40));
        $bag->addTurnips(new Turnips('Island_B', 90, 40));
        $bag->addTurnips(new Turnips('Island_C', 80, 40));

        $islands = [];

        foreach ($bag as $turnips) {
            $islands[] = $turnips->getIsland();
        }

        $this->assertSame(
            array(
                'Island_A',
                'Island_B',
                'Island_C'
            ),
            $islands
        );
    }

    /**
     * @test
     */
    public function test_can_iterate_over_bag_after_removing_turnips()
    {
        $turnipsA = new Turnips('Island_A', 100, 40);
        $turnipsB = new Turnips('Island_B', 200, 10);

        $bag = new Bag();
        $bag->addTurnips($turnipsA);
        $bag->addTurnips($turnipsB);
        $bag->removeTurnips($turnipsA);

        $islands = [];
        foreach ($bag as $turnips) {
            $islands[] = $turnips->getIsland();
        }

        $this->assertSame(
            array('Island_B'),
            $islands
        );
    }

    /**
     * @test
     */
    public function test_can_add_turnips_to_bag()
    {
        $turnips = new Turnips('Island_A', 100, 40);

        $bag = new Bag();
        $bag->addTurnips($turnips);

        $this->assertCount(1, $bag);
    }

    /**
     * @test
     */
    public function test_can_remove_turnips_from_bag()
    {
        $turnips = new Turnips('Island_A', 100, 40);

        $bag = new Bag();
        $bag->addTurnips($turnips);
        $bag->removeTurnips($turnips);

        $this->assertCount(0, $bag);
    }
}
