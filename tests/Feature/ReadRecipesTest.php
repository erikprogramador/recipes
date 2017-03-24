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
        $this->get('/')
             ->assertSee($recipe->title);
    }

    /** @test */
    function if_dont_have_any_recipes_show_a_cool_message()
    {
        $this->get('/')
             ->assertSee('Be the first to write a recipe!');
    }

    /** @test */
    function can_view_a_recipe()
    {
        $recipe = factory(Recipe::class)->create();

        $this->get('/recipe/'.$recipe->id)
             ->assertSee($recipe->title)
             ->assertSee($recipe->description);
    }
}
