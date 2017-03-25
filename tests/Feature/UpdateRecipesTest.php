<?php

namespace Tests\Feature;

use App\{User, Recipe};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_owner_user_can_update_the_recipe()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());

        $this->get("/recipe/{$recipe->id}/update")
             ->assertRedirect('/');

        $this->be($user);

        $this->get("/recipe/{$recipe->id}/update")
             ->assertSee($recipe->title)
             ->assertSee($recipe->description);
    }

    /** @test */
    function update_a_recipe()
    {
        $this->be($user = factory(User::class)->create());
        $oldRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['user_id' => $user->id]);

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe->toArray());

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertEquals($newRecipe->title, $recipe->title);
        $this->assertEquals($newRecipe->description, $recipe->description);
    }

    /** @test */
    function only_the_owner_user_can_update_a_recipe()
    {
        $user = factory(User::class)->create();
        $loggedUser = factory(User::class)->create();
        $oldRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['user_id' => $loggedUser->id]);

        $this->be($loggedUser);
        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe->toArray())
             ->assertRedirect('/');

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertNotEquals($newRecipe->title, $recipe->title);
        $this->assertNotEquals($newRecipe->description, $recipe->description);
    }

    /** @test */
    function when_a_recipe_are_update_needs_to_redirect_to_the_single_recipe()
    {
        $this->be($user = factory(User::class)->create());
        $oldRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['user_id' => $user->id]);

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe->toArray())
             ->assertRedirect('/recipe/' . $oldRecipe->id);
    }
}
