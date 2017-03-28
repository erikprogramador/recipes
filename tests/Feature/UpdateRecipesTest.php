<?php

namespace Tests\Feature;

use App\{
    User,
    Recipe,
    Category
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_the_owner_can_see_update_button_on_the_show_page_of_recipes()
    {
        $user = factory(User::class)->create();
        $accessRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());
        $this->get("/recipe/{$accessRecipe->id}")
            ->assertDontSee('Edit');

        $this->be($user);
        $this->get("/recipe/{$accessRecipe->id}")
            ->assertSee('Edit');
    }

    /** @test */
    function only_the_owner_can_see_update_button_on_the_home_page_of_recipes()
    {
        $user = factory(User::class)->create();
        $accessRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->be(factory(User::class)->create());
        $this->get("/")
            ->assertDontSee('Edit');

        $this->be($user);
        $this->get("/")
            ->assertSee('Edit');
    }

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
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], factory(Category::class, 3)->create());

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe);

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertEquals($newRecipe['title'], $recipe->title);
        $this->assertEquals($newRecipe['description'], $recipe->description);
    }

    /** @test */
    function only_the_owner_user_can_update_a_recipe()
    {
        $user = factory(User::class)->create();
        $loggedUser = factory(User::class)->create();
        $oldRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], factory(Category::class, 3)->create());

        $this->be($loggedUser);
        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe)
             ->assertRedirect('/');

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertNotEquals($newRecipe, $recipe->toArray());
    }

    /** @test */
    function when_a_recipe_are_update_needs_to_redirect_to_the_single_recipe()
    {
        $this->be($user = factory(User::class)->create());
        $oldRecipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], factory(Category::class, 3)->create());

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe)
             ->assertRedirect('/recipe/' . $oldRecipe->id);
    }

     /** @test */
    function title_field_is_required()
    {
        $this->be($user = factory(User::class)->create());
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['title' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['title']);
    }

    /** @test */
    function description_field_is_required()
    {
        $this->be($user = factory(User::class)->create());
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['description' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['description']);
    }

    /** @test */
    function cover_field_is_required()
    {
        $this->be($user = factory(User::class)->create());
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['cover' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['cover']);
    }

    /** @test */
    function category_id_field_is_required()
    {
        $this->be($user = factory(User::class)->create());
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);
        $newRecipe = factory(Recipe::class)->make(['user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['category_id']);
    }

    protected function makeRecipe($overrides = [], $categories)
    {
        $recipe = factory(Recipe::class)->make($overrides);

        $post = [
            'title' => $recipe->title,
            'description' => $recipe->description,
            'cover' => $recipe->cover,
            'featured' => $recipe->featured,
            'category_id' => $categories->pluck('id')
        ];

        return $post;
    }
}
