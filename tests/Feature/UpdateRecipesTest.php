<?php

namespace Tests\Feature;

use App\{
    User,
    Recipe,
    Category,
    Ingredient
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UpdateRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_the_owner_can_see_update_button_on_the_show_page_of_recipes()
    {
        $user = $this->signIn();
        $accessRecipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->signIn();
        $this->get("/recipe/{$accessRecipe->id}")
            ->assertDontSee('Edit');

        $this->signIn($user);
        $this->get("/recipe/{$accessRecipe->id}")
            ->assertSee('Edit');
    }

    /** @test */
    function only_the_owner_can_see_update_button_on_the_home_page_of_recipes()
    {
        $user = $this->signIn();
        $accessRecipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->signIn();
        $this->get("/")
            ->assertDontSee('Edit');

        $this->signIn($user);
        $this->get("/")
            ->assertSee('Edit');
    }

    /** @test */
    function only_owner_user_can_update_the_recipe()
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->signIn();
        $this->get("/recipe/{$recipe->id}/update")
             ->assertRedirect('/');

        $this->signIn($user);
        $this->get("/recipe/{$recipe->id}/update")
             ->assertSee($recipe->title)
             ->assertSee($recipe->description);
    }

    /** @test */
    function update_a_recipe()
    {
        $user = $this->signIn();
        $oldRecipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], create(Category::class));

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe);

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertEquals($newRecipe['title'], $recipe->title);
        $this->assertEquals($newRecipe['description'], $recipe->description);
    }

    /** @test */
    function only_the_owner_user_can_update_a_recipe()
    {
        $user = create(User::class);
        $loggedUser = create(User::class);
        $oldRecipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], create(Category::class));

        $this->signIn($loggedUser);
        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe)
             ->assertRedirect('/');

        $recipe = Recipe::find($oldRecipe->id);

        $this->assertNotEquals($newRecipe, $recipe->toArray());
    }

    /** @test */
    function when_a_recipe_are_update_needs_to_redirect_to_the_single_recipe()
    {
        $user = $this->signIn();
        $oldRecipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], create(Category::class));

        $this->post("/recipe/{$oldRecipe->id}/update", $newRecipe)
             ->assertRedirect('/recipe/' . $oldRecipe->id);
    }

     /** @test */
    function title_field_is_required()
    {
        $user = $this->signIn();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = make(Recipe::class, ['title' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['title']);
    }

    /** @test */
    function description_field_is_required()
    {
        $user = $this->signIn();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = make(Recipe::class, ['description' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['description']);
    }

    /** @test */
    function cover_field_is_required()
    {
        $user = $this->signIn();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = make(Recipe::class, ['cover' => null, 'user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['cover']);
    }

    /** @test */
    function category_id_field_is_required()
    {
        $user = $this->signIn();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $newRecipe = make(Recipe::class, ['user_id' => $user->id]);

        $this->post("/recipe/{$recipe->id}/update", $newRecipe->toArray())
             ->assertSessionHasErrors(['category_id']);
    }

    /** @test */
    function a_recipe_can_recive_categories_update()
    {
        $user = $this->signIn();
        $recipe = $this->createRecipe(['user_id' => $user->id], create(Category::class));
        $newRecipe = $this->makeRecipe(['user_id' => $user->id], create(Category::class));

        $this->post("/recipe/{$recipe->id}/update", $newRecipe)
             ->assertRedirect("/recipe/{$recipe->id}");

        $recipe->fresh();

        $this->assertEquals($recipe->categories->pluck('id'), $newRecipe['category_id']);
    }

    /** @test */
    function a_recipe_can_update_there_ingredients()
    {
        $user = $this->signIn();
        $recipe = create(Recipe::class, ['user_id' => $user->id]);
        $categories = create(Category::class);
        $ingredients = createMany(Ingredient::class, 3, ['recipe_id' => $recipe->id]);
        $recipe->categories()->attach($categories);
        $newIngredients = makeMany(Ingredient::class, 2);

        $update = [
            'title' => $recipe->title,
            'description' => $recipe->description,
            'cover' => $recipe->cover,
            'category_id' => $categories->pluck('id'),
            'ingredients' => $newIngredients->pluck('name'),
            'quantity' => $newIngredients->pluck('quantity')
        ];

        $this->post("/recipe/{$recipe->id}/update", $update)
             ->assertRedirect('/recipe/' . $recipe->id);

        $recipe = Recipe::find($recipe->id);

        $this->assertEquals(2, $recipe->ingredients->count());
    }

    protected function makeRecipe($overrides = [], $categories)
    {
        $recipe = make(Recipe::class, $overrides);

        $post = [
            'title' => $recipe->title,
            'description' => $recipe->description,
            'cover' => $recipe->cover,
            'featured' => $recipe->featured,
            'category_id' => $categories->pluck('id')
        ];

        return $post;
    }

    protected function createRecipe($overrides = [], $categories)
    {
        $recipe = create(Recipe::class, $overrides);
        $recipe->categories()->attach($categories);

        return $recipe;
    }
}
