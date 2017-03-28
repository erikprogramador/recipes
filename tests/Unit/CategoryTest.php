<?php

namespace Tests\Unit;

use App\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoryTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function it_can_be_created_with_a_slug()
    {
        $title = 'Chocolate Cake';
        $slug = 'chocolate-cake';

        $objCategory = new Category;
        $category = $objCategory->createWithSlug($title);

        $this->assertEquals($title, $category->title);
        $this->assertEquals($slug, $category->slug);
    }

    /** @test */
    function it_should_have_get_route_key_name_returning_the_slug_as_the_route_key()
    {
        $category = new Category;

        $this->assertEquals('slug', $category->getRouteKeyName());
    }
}
