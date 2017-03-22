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
    function it_has_many_recipies()
    {
        $user = factory(User::class)->create();
        $recipe = factory(Recipe::class)->make();
        $user->recipies()->save($recipe);

        $this->assertEquals($recipe->title, $user->recipies->first()->title);
        $this->assertInstanceOf(
            '\Illuminate\Database\Eloquent\Collection', $user->recipies
        );
    }
}
