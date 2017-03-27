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
}
