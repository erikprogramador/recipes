<?php

namespace Tests\Feature;

use App\{User, Recipe};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateRecipiesTest extends TestCase
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
        $recipe = factory(Recipe::class)->make();

        $this->post('/recipe/store', $recipe->toArray())
             ->assertRedirect('/login');

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray());

        $this->get('/recipe/1')
             ->assertSee($recipe->title)
             ->assertSee($recipe->description);
    }

    /** @test */
    function title_field_is_required()
    {
        $recipe = factory(Recipe::class)->make(['title' => null]);

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray())
             ->assertSessionHasErrors(['title']);
    }

    /** @test */
    function description_field_is_required()
    {
        $recipe = factory(Recipe::class)->make(['description' => null]);

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray())
             ->assertSessionHasErrors(['description']);
    }

    /** @test */
    function cover_field_is_required()
    {
        $recipe = factory(Recipe::class)->make(['cover' => null]);

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray())
             ->assertSessionHasErrors(['cover']);
    }

    /** @test */
    function a_recipe_can_be_featured()
    {
        $recipe = factory(Recipe::class)->make(['featured' => true]);

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray());

        $fistRecipe = Recipe::first();

        $this->assertTrue($fistRecipe->isFeatured());
    }

    /** @test */
    function a_recipe_without_have_be_featured_can_not_be_featured()
    {
        $recipe = factory(Recipe::class)->make(['featured' => false]);

        $this->be(factory(User::class)->create());
        $this->post('/recipe/store', $recipe->toArray());

        $fistRecipe = Recipe::first();

        $this->assertFalse($fistRecipe->isFeatured());
    }
}
