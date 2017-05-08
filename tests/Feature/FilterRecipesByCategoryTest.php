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
        $categories = make(Category::class);
        $recipe = create(Recipe::class);
        $recipe->categories()->attach($categories);
        $noShow = create(Recipe::class, ['title' => 'ERIK XPTO']);
        $noCategory = make(Category::class, ['title' => 'Chocolate cacke', 'slug' => 'chocolate-cacke']);
        $noShow->categories()->attach($noCategory);

        $this->get('/recipe/category/'. $categories->slug)
             ->assertSee($recipe->title)
             ->assertDontSee($noShow->title);
    }
}
