<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{
    HasMany,
    BelongsTo,
    BelongsToMany
};

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class Recipe extends Model
{
    /**
     * Guarded fields
     * @var array
     */
    protected $guarded = [];

    /**
     * Define the relationship with user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define the relationship with many categories
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories() : BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * Define the relationship with many ingredients
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ingredients() : HasMany
    {
        return $this->hasMany(Ingredient::class);
    }

    /**
     * Check if the auth or passed user is the recipe owner
     *
     * @param  User|null
     * @return boolean
     */
    public function isOwner(User $user = null) : bool
    {
        if (!$user && !auth()->user()) {
            return false;
        }

        $user = $user ?? auth()->user();

        return $this->isOwnerByUserId($user);
    }

    /**
     * Feature it
     *
     * @return self
     */
    public function feature() : self
    {
        return $this->toggleFeatured(true);
    }

    /**
     * Unfeature it
     *
     * @return self
     */
    public function unfeature() : self
    {
        return $this->toggleFeatured(false);
    }

    /**
     * Check if it is featured
     *
     * @return boolean
     */
    public function isFeatured() : bool
    {
        return $this->featured;
    }

    /**
     * Verify if it is featured
     * if is return checked else return null
     *
     * @return string|null
     */
    public function checked() : ?string
    {
        return $this->featured ? 'checked' : null;
    }

    /**
     * Create it with many categories associate
     *
     * @param  array
     * @param  \Illuminate\Database\Eloquent\Collection|array
     * @return self
     */
    public function createWithCategories(array $data, $categories) : self
    {
        $this->fill($data);
        $recipe = auth()->user()->recipes()->save($this);
        $this->categories()
               ->attach($categories);
        return $this;
    }

    /**
     * Check if it is selected
     *
     * @param  Category
     * @return string
     */
    public function categoryIsSelected(Category $category) : string
    {
        return $this->categories->contains('id', $category->id) ? 'selected' : '';
    }

    /**
     * Add Ingredients to a Recipe
     *
     * @param \Illuminate\Database\Eloquent\Collection|arrray
     * @return self
     */
    public function addIngredients($ingredients) : self
    {
        $this->ingredients()->saveMany($ingredients);
        return $this;
    }

    /**
     * Feature or unfeature it
     *
     * @param  bool
     * @return self
     */
    protected function toggleFeatured(bool $state) : self
    {
        $this->featured = $state;
        $this->save();
        return $this;
    }

    /**
     * Check if user is owner by there id
     *
     * @param  User
     * @return boolean
     */
    protected function isOwnerByUserId(User $user) : bool
    {
        return $user->id === $this->owner->id;
    }

    public function byCategory($category)
    {
        return $this->whereHas('categories', function ($query) use ($category) {
            $query->where('category_id', $category->id);
        })->get();
    }
}
