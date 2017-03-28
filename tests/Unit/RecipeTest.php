<?php

namespace Tests\Unit;

use App\{
    User,
    Recipe,
    Category
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecipeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_be_featured()
    {
        $recipe = factory(Recipe::class)->create();
        $recipe->feature();

        $this->assertTrue($recipe->isFeatured());
    }

    /** @test */
    function it_can_be_unfeatured()
    {
        $recipe = factory(Recipe::class)->create(['featured' => true]);
        $recipe->unfeature();

        $this->assertFalse($recipe->isFeatured());
    }

    /** @test */
    function if_is_or_not_checked()
    {
        $recipe = factory(Recipe::class)->create(['featured' => true]);

        $this->assertEquals('checked', $recipe->checked());
    }

    /** @test */
    function it_has_a_owner()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->assertEquals($user->id, $recipe->owner->id);
    }

    /** @test */
    function it_has_many_categories()
    {
        $recipe = factory(Recipe::class)->create();
        $categories = factory(Category::class, 3)->create();

        $recipe->categories()->attach($categories);
        $newCategories = $recipe->categories;

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($newCategories[$i]->title, $categories[$i]->title);
        }
    }

    /** @test */
    function verify_if_a_user_is_owner()
    {
        $user = factory(User::class)->create();
        $notOwner = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->assertTrue($recipe->isOwner($user));
        $this->assertFalse($recipe->isOwner($notOwner));
    }

    /** @test */
    function verify_if_the_logged_user_is_owner()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->create(['user_id' => $user->id]);

        $this->assertFalse($recipe->isOwner());

        $this->be($user);
        $this->assertTrue($recipe->isOwner());

        $this->be(factory(User::class)->create());
        $this->assertFalse($recipe->isOwner());
    }

    /** @test */
    function it_can_create_a_recipe_with_a_user_and_many_categories()
    {
        $this->be(factory(User::class)->create());
        $recipe = factory(Recipe::class)->make();
        $categories = factory(Category::class, 3)->create();

        $createRecipe = new Recipe;

        $createRecipe->createWithCategories($recipe->toArray(), $categories);

        $newCategories = $createRecipe->categories;

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($newCategories[$i]->title, $categories[$i]->title);
        }
    }
}
