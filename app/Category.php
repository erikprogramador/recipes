<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class Category extends Model
{
    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = [];

    /**
     * Create a category with slug
     *
     * @param  string
     * @return self
     */
    public function createWithSlug(string $title)
    {
        return $this->create([
            'title' => $title,
            'slug' => Slug::make($title)
        ]);
    }

    /**
     * Define the column to be find wen use route model bind
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
