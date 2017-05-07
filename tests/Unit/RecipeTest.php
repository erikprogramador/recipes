<?php

namespace Tests\Unit;

use App\{
    User,
    Recipe,
    Category,
    Ingredient
};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RecipeTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_be_featured()
    {
        $recipe = create(Recipe::class);
        $recipe->feature();

        $this->assertTrue($recipe->isFeatured());
    }

    /** @test */
    function it_can_be_unfeatured()
    {
        $recipe = create(Recipe::class, ['featured' => true]);
        $recipe->unfeature();

        $this->assertFalse($recipe->isFeatured());
    }

    /** @test */
    function if_is_or_not_checked()
    {
        $recipe = create(Recipe::class, ['featured' => true]);

        $this->assertEquals('checked', $recipe->checked());
    }

    /** @test */
    function it_has_a_owner()
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->assertEquals($user->id, $recipe->owner->id);
    }

    /** @test */
    function it_has_many_categories()
    {
        $recipe = create(Recipe::class);
        $categories = createMany(Category::class, 3);

        $recipe->categories()->attach($categories);
        $newCategories = $recipe->categories;

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($newCategories[$i]->title, $categories[$i]->title);
        }
    }

    /** @test */
    function verify_if_a_user_is_owner()
    {
        $user = create(User::class);
        $notOwner = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->assertTrue($recipe->isOwner($user));
        $this->assertFalse($recipe->isOwner($notOwner));
    }

    /** @test */
    function verify_if_the_logged_user_is_owner()
    {
        $user = create(User::class);
        $recipe = create(Recipe::class, ['user_id' => $user->id]);

        $this->assertFalse($recipe->isOwner());

        $this->signIn($user);
        $this->assertTrue($recipe->isOwner());

        $this->signIn();
        $this->assertFalse($recipe->isOwner());
    }

    /** @test */
    function it_can_create_a_recipe_with_a_user_and_many_categories()
    {
        $this->signIn();
        $recipe = make(Recipe::class);
        $categories = createMany(Category::class, 3);

        $createRecipe = new Recipe;

        $createRecipe->createWithCategories($recipe->toArray(), $categories);

        $newCategories = $createRecipe->categories;

        for ($i = 0; $i < 3; $i++) {
            $this->assertEquals($newCategories[$i]->title, $categories[$i]->title);
        }
    }

    /** @test */
    function it_should_return_if_a_category_is_associated_with()
    {
        $categories = createMany(Category::class, 3);
        $recipe = create(Recipe::class);
        $noAssociate = create(Category::class);
        $recipe->categories()->attach($categories);

        $this->assertEquals('selected', $recipe->categoryIsSelected($categories->first()));
        $this->assertNotEquals('selected', $recipe->categoryIsSelected($noAssociate));
    }

    /** @test */
    function it_has_many_ingredients()
    {
        $recipe = create(Recipe::class);
        $ingredients = createMany(Ingredient::class, 3, ['recipe_id' => $recipe->id]);

        $this->assertEquals(3, $recipe->ingredients->count());
    }

    /** @test */
    function it_can_add_ingredients()
    {
        $recipe = create(Recipe::class);
        $ingredients = makeMany(Ingredient::class, 3);

        $recipe->addIngredients($ingredients);

        $this->assertCount(3, $recipe->ingredients);
    }
}
