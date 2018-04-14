<?php

namespace FakerPlus\Tests\Providers;

use Faker\Generator;
use FakerPlus\Tests\TestCase;
use FakerPlus\Providers\Library\Colors;

class ColorsTest extends TestCase
{
    /**
     * @test
     */
    public function generatesRandomColorName()
    {
        $colors = new Colors(new Generator());

        $this->assertContains($colors->colorName(), Colors::NAMES);
    }
    
    /**
     * @test
     */
    public function generatesRandomColorHex()
    {
        $colors = new Colors(new Generator());

        preg_match('/#(?:[a-f0-9]{3}){1,2}\b/i', $colors->colorHex(), $matches);

        $this->assertNotEmpty($matches);
    }

    /**
     * @test
     */
    public function generatesRandomRgbColor()
    {
        $colors = new Colors(new Generator());

        preg_match('/rgb\((?:\s*\d+\s*,){2}\s*[\d]+\)/', $colors->colorRgb(), $matches);

        $this->assertNotEmpty($matches);
    }

    /**
     * @test
     */
    public function generatesRandomRgbaColor()
    {
        $colors = new Colors(new Generator());

        preg_match('/rgba\((?:\s*\d+\s*,){3}\s*[\d\.]+\)/', $colors->colorRgba(), $matches);

        $this->assertNotEmpty($matches);
    }
}
