<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function createWithSlug(string $title)
    {
        $slug = Slug::make($title);
        return $this->create([
            'title' => $title,
            'slug' => $slug
        ]);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
