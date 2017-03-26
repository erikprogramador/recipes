<?php

namespace Tests\Feature;

use App\{User, Recipe};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DeleteRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function a_user_can_delete_a_recipe()
    {
        $this->be($user = factory(User::class)->create());
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/delete", $recipe->toArray())
             ->assertRedirect('/')
             ->assertSessionHas('message');

        $findRecipe = Recipe::find($recipe->id);

        $this->assertNull($findRecipe);
    }

    /** @test */
    function on_existent_recipe_can_be_deleted()
    {
        $this->be(factory(User::class)->create());
        $this->post("/recipe/99999/delete", [])
             ->assertStatus(404);
    }

    /** @test */
    function only_the_owner_can_delete_a_recipe()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());
        $this->post("/recipe/{$recipe->id}/delete", $recipe->toArray())
             ->assertRedirect('/')
             ->assertSessionMissing('message');

        $findRecipe = Recipe::find($recipe->id);

        $this->assertNotNull($findRecipe);
    }

    /** @test */
    function only_the_owner_can_see_the_delete_button_on_show_page()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());
        $this->get("/recipe/{$recipe->id}")
             ->assertDontSee('Delete');

        $this->be($user);
        $this->get("/recipe/{$recipe->id}")
             ->assertSee('Delete');
    }

    /** @test */
    function only_the_owner_can_see_the_delete_button_on_home_page()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class, 5)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());
        $this->get("/")
             ->assertDontSee('Delete');

        $this->be($user);
        $this->get("/")
             ->assertSee('Delete');
    }
}
