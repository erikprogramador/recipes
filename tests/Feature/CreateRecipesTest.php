<?php

namespace Tests\Feature;

use App\{
    User,
    Recipe,
    Category
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

        $this->be(factory(User::class)->create());
        $this->get('/recipe/create')
             ->assertSee('Create a recipe');
    }

    /** @test */
    function only_logged_users_can_store_a_recipe()
    {
        $recipe = $this->makeRecipe([], factory(Category::class, 3)->create());

        $this->post('/recipe/store', $recipe)
             ->assertRedirect('/login');

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe);

        $this->get('/recipe/1')
             ->assertSee($recipe['title'])
             ->assertSee($recipe['description']);
    }

    /** @test */
    function title_field_is_required()
    {
        $recipe = $this->makeRecipe(['title' => null], factory(Category::class, 3)->create());

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['title']);
    }

    /** @test */
    function description_field_is_required()
    {
        $recipe = $this->makeRecipe(['description' => null], factory(Category::class, 3)->create());

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['description']);
    }

    /** @test */
    function cover_field_is_required()
    {
        $recipe = $this->makeRecipe(['cover' => null], factory(Category::class, 3)->create());

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe)
             ->assertSessionHasErrors(['cover']);
    }

    /** @test */
    function a_recipe_can_be_featured()
    {
        $recipe = $this->makeRecipe(['featured' => true], factory(Category::class, 3)->create());

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe);

        $first = Recipe::first();

        $this->assertTrue($first->isFeatured());
    }

    /** @test */
    function a_recipe_without_have_be_featured_can_not_be_featured()
    {
        $recipe = $this->makeRecipe(['featured' => false], factory(Category::class, 3)->create());

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe);

        $fistRecipe = Recipe::first();

        $this->assertFalse($fistRecipe->isFeatured());
    }

    /** @test */
    function a_recipe_can_have_many_categories()
    {
        $categories = factory(Category::class, 3)->create();
        $recipe = $this->makeRecipe([], $categories);

        $this->be(factory(User::class)->create());
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
        $recipe = factory(Recipe::class)->make();

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray())
             ->assertSessionHasErrors('category_id');
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
