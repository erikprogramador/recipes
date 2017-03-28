<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function isOwner(User $user = null) : bool
    {
        if (!$user && !auth()->user()) {
            return false;
        }

        $user = $user ?? auth()->user();

        return $this->isOwnerByUserId($user);
    }

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

    public function checked() : ?string
    {
        return $this->featured ? 'checked' : null;
    }

    public function createWithCategories(array $data, $categories)
    {
        $this->fill($data);
        $recipe = auth()->user()->recipes()->save($this);
        $this->categories()
               ->attach($categories);
        return $this;
    }

    protected function toggleFeatured(bool $state) : self
    {
        $this->featured = $state;
        $this->save();
        return $this;
    }

    protected function isOwnerByUserId(User $user) : bool
    {
        return $user->id === $this->owner->id;
    }
}
