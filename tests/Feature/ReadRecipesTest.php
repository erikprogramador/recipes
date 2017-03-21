<?php

namespace Tests\Feature;

use App\Recipe;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function lists_all_recipes_on_home()
    {
        $recipe = factory(Recipe::class)->create();
        $response = $this->get('/');

        $response->assertSee($recipe->title);
    }
}
