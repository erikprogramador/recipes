<?php

namespace Tests\Unit;

use App\Recipe;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecipeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_be_featured()
    {
        $recipe = factory(Recipe::class)->create();
        $recipe->feature();

        $this->assertTrue($recipe->isFeatured());
    }

    /** @test */
    function it_can_be_unfeatured()
    {
        $recipe = factory(Recipe::class)->create(['featured' => true]);
        $recipe->unfeature();

        $this->assertFalse($recipe->isFeatured());
    }
}
