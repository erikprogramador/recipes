<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    public function feature() : self
    {
        return $this->toggleFeatured(true);
    }

    public function unfeature() : self
    {
        return $this->toggleFeatured(false);
    }

    public function isFeatured() : bool
    {
        return $this->featured;
    }

    protected function toggleFeatured(bool $state) : self
    {
        $this->featured = $state;
        $this->save();
        return $this;
    }
}
