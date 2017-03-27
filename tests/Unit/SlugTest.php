<?php

namespace Tests\Unit;

use App\Slug;
use Tests\TestCase;

class SlugTest extends TestCase
{
    /** @test */
    function it_returns_a_valid_slug()
    {
        $string = 'Chocolate Cake';
        $slug = 'chocolate-cake';

        $this->assertEquals($slug, Slug::make($string));
    }
}
