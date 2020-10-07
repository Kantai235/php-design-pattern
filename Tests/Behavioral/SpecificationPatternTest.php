<?php

namespace Tests\Behavioral;

use DesignPatterns\Behavioral\SpecificationPattern\SpoiledSpecification;
use DesignPatterns\Behavioral\SpecificationPattern\Turnips;
use DesignPatterns\Behavioral\SpecificationPattern\TurnipsSpecification;
use PHPUnit\Framework\TestCase;

/**
 * Class SpecificationPatternTest.
 */
class SpecificationPatternTest extends TestCase
{
    /**
     * @test
     */
    public function test_single_turnips()
    {
        $turnips = new Turnips(100, 40);
        $specification = new TurnipsSpecification($turnips);

        $this->assertEquals(4000, $specification->calculatePrice());
    }

    /**
     * @test
     */
    public function test_multi_turnips()
    {
        $turnips_A = new Turnips(100, 40);
        $turnips_B = new Turnips(90, 20);
        $turnips_C = new Turnips(110, 20);
        $specification = new TurnipsSpecification($turnips_A, $turnips_B, $turnips_C);

        $this->assertEquals(8000, $specification->calculatePrice());
    }

    /**
     * @test
     */
    public function test_single_spoiled()
    {
        $turnips = new Turnips(100, 40);
        $specification = new TurnipsSpecification($turnips);
        $spoiled = new SpoiledSpecification($specification);

        $this->assertEquals(0, $spoiled->calculatePrice());
    }

    /**
     * @test
     */
    public function test_multi_spoiled()
    {
        $turnips_A = new Turnips(100, 40);
        $turnips_B = new Turnips(90, 20);
        $turnips_C = new Turnips(110, 20);
        $specification = new TurnipsSpecification($turnips_A, $turnips_B, $turnips_C);
        $spoiled = new SpoiledSpecification($specification);

        $this->assertEquals(0, $spoiled->calculatePrice());
    }
}
