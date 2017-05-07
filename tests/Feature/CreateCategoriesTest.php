<?php

namespace Tests\Feature;

use App\{User, Category};
use Tests\TestCase;
use Faker\Provider\Lorem as Faker;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateCategoriesTest extends TestCase
{
    use DatabaseMigrations;

    protected $createUrl = '/category/create';
    protected $storeUrl = '/category/store';

    /** @test */
    function logged_user_can_see_the_create_category_page()
    {
        $this->get($this->createUrl)
             ->assertRedirect('/login');

        $this->signIn();
        $this->get($this->createUrl)
             ->assertSee('Create a category');
    }

    /** @test */
    function only_logged_users_can_create_a_category()
    {
        $category = factory(Category::class)->make();

        $this->post($this->storeUrl, $category->toArray())
             ->assertRedirect('/login');

        $this->signIn();
        $this->post($this->storeUrl, $category->toArray())
             ->assertRedirect('/');
    }

    /** @test */
    function a_user_can_create_a_category()
    {
        $this->signIn();
        $category = factory(Category::class)->make();

        $this->post($this->storeUrl, $category->toArray())
             ->assertRedirect('/');

        $find = Category::find(1);

        $this->assertEquals($category->title, $find->title);
        $this->assertEquals($category->slug, $find->slug);
    }

    /** @test */
    function a_category_must_have_a_title()
    {
        $category = factory(Category::class)->make(['title' => null]);

        $this->signIn();
        $this->post($this->storeUrl, $category->toArray())
             ->assertSessionHasErrors('title');
    }

    /** @test */
    function a_category_title_can_not_have_more_than_fifty_caracters()
    {
        $category = factory(Category::class)->make(['title' => Faker::sentence(100)]);

        $this->signIn();
        $this->post($this->storeUrl, $category->toArray())
             ->assertSessionHasErrors('title');
    }
}
