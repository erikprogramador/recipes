<?php

namespace Tests\Unit;

use App\{User, Recipe};
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_has_many_recipes()
    {
        $user = create(User::class);
        $recipe = make(Recipe::class);
        $user->recipes()->save($recipe);

        $this->assertEquals($recipe->title, $user->recipes->first()->title);
        $this->assertInstanceOf(
            '\Illuminate\Database\Eloquent\Collection', $user->recipes
        );
    }
}
