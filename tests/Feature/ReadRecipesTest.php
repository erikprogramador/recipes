<?php

namespace Tests\Feature;

use App\{
    User,
    Recipe
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function lists_all_recipes_on_home()
    {
        $recipe = create(Recipe::class);
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
        $recipe = create(Recipe::class);

        $this->get('/recipe/'.$recipe->id)
             ->assertSee($recipe->title)
             ->assertSee($recipe->description);
    }

    /** @test */
    function a_user_can_see_there_recipes()
    {
        $user = $this->signIn();
        $userRecipe = create(Recipe::class, ['user_id' => $user->id]);
        $notUserRecipe = create(Recipe::class, ['title' => 'XPTO Recipe']);

        $this->get("/user/{$user->id}/recipes")
             ->assertSee($userRecipe->title)
             ->assertDontSee($notUserRecipe->title);
    }
}
