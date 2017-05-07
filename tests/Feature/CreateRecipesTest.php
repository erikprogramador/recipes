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

class CreateRecipesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function just_logged_users_can_see_the_create_recipes_page()
    {
        $this->get('/recipe/create')
             ->assertRedirect('/login');

        $this->signIn();
        $this->get('/recipe/create')
             ->assertSee('Create a recipe');
    }

    /** @test */
    function only_logged_users_can_store_a_recipe()
    {
        $recipe = $this->makeRecipe([], createMany(Category::class, 3));

        $this->post('/recipe/store', $recipe)
             ->assertRedirect('/login');

        $this->signIn();
        $this->post('/recipe/store', $recipe);

        $lastRecipe = Recipe::latest()->get()->first();
        $this->get('/recipe/'.$lastRecipe->id)
             ->assertSee($recipe['title'])
             ->assertSee($recipe['description']);
    }

    /** @test */
    function title_field_is_required()
    {
        $recipe = $this->makeRecipe(['title' => null], createMany(Category::class, 3));

        $this->signIn();
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['title']);
    }

    /** @test */
    function description_field_is_required()
    {
        $recipe = $this->makeRecipe(['description' => null], createMany(Category::class, 3));

        $this->signIn();
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['description']);
    }

    /** @test */
    function cover_field_is_required()
    {
        $recipe = $this->makeRecipe(['cover' => null], createMany(Category::class, 3));

        $this->signIn();
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['cover']);
    }

    /** @test */
    function a_recipe_can_be_featured()
    {
        $recipe = $this->makeRecipe(['featured' => true], createMany(Category::class, 3));

        $this->signIn();
        $this->post('/recipe/store', $recipe);

        $first = Recipe::first();

        $this->assertTrue($first->isFeatured());
    }

    /** @test */
    function a_recipe_without_have_be_featured_can_not_be_featured()
    {
        $recipe = $this->makeRecipe(['featured' => false], createMany(Category::class, 3));

        $this->signIn();
        $this->post('/recipe/store', $recipe);

        $fistRecipe = Recipe::first();

        $this->assertFalse($fistRecipe->isFeatured());
    }

    /** @test */
    function a_recipe_can_have_many_categories()
    {
        $categories = createMany(Category::class, 3);
        $recipe = $this->makeRecipe([], $categories);

        $this->signIn();
        $this->post('/recipe/store', $recipe)
             ->assertRedirect('/recipe/1');

        $find = Recipe::find(1);

        $newCategories = $find->categories;

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($newCategories[$i]->title, $categories[$i]->title);
        }
    }

        /** @test */
    function a_recipe_must_have_a_category()
    {
        $recipe = make(Recipe::class);

        $this->signIn();
        $this->post('/recipe/store', $recipe->toArray())
             ->assertSessionHasErrors('category_id');
    }

    /** @test */
    function a_recipe_can_attach_many_ingredients()
    {
        $this->signIn();
        $recipe = $this->makeRecipe(['user_id' => $this->user->id], create(Category::class));
        $ingredients = makeMany(Ingredient::class, 3);
        $recipe['ingredients'] = $ingredients->pluck('name');
        $recipe['quantity'] = $ingredients->pluck('quantity');

        $this->post('/recipe/store', $recipe)
              ->assertStatus(302);

        $find = Recipe::find(4);

        $this->assertEquals(3, $find->ingredients->count());
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
}
