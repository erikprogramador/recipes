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
        $this->get('/recipies/create')
             ->assertRedirect('/login');

        $this->be(factory(User::class)->create());
        $this->get('/recipies/create')
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
}