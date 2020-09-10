<?php

namespace Tests\Structural;

use DesignPatterns\Structural\FlyweightPattern\FlyweightFactory;
use PHPUnit\Framework\TestCase;

/**
 * Class FlyweightPatternTest.
 */
class FlyweightPatternTest extends TestCase
{
    /**
     * @var array
     */
    protected $turnips = array(
        'Island_A' => array('price' => 90, 'count' => 40),
        'Island_B' => array('price' => 92, 'count' => 36),
        'Island_C' => array('price' => 94, 'count' => 32),
        'Island_D' => array('price' => 96, 'count' => 28),
        'Island_E' => array('price' => 98, 'count' => 24),
        'Island_F' => array('price' => 100, 'count' => 20),
        'Island_G' => array('price' => 102, 'count' => 16),
        'Island_H' => array('price' => 104, 'count' => 12),
        'Island_I' => array('price' => 106, 'count' => 8),
        'Island_J' => array('price' => 108, 'count' => 4),
        'Island_K' => array('price' => 110, 'count' => 40),
    );

    /**
     * @test
     */
    public function test_flyweight()
    {
        $factory = new FlyweightFactory();

        foreach ($this->turnips as $key => $value) {
            $flyweight = $factory->get($key, $value['price'], $value['count']);
            $total = $flyweight->calculatePrice();

            $this->assertEquals($value['price'] * $value['count'], $total);
        }

        $this->assertCount(count($this->turnips), $factory);
        $this->assertEquals(25520, $factory->calculateTotal());
    }
}
