<?php

namespace Tests\Feature;

use App\{Recipe, Category};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class FilterRecipesByCategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function only_recipes_associate_with_a_given_category_must_shows_when_category_is_search()
    {
        $categories = factory(Category::class)->create();
        $recipe = factory(Recipe::class)->create();
        $recipe->categories()->attach($categories);
        $noShow = factory(Recipe::class)->create();
        $noShow->categories()->attach(factory(Category::class)->create());

        $this->get('/'. $categories->slug)
             ->assertSee($recipe->title)
             ->assertDontSee($noShow->title);
    }
}
