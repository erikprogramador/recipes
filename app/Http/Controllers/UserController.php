<?php

namespace App\Http\Controllers;

use App\{
    User,
    Recipe
};
use Illuminate\Http\Request;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class UserController extends Controller
{
    /**
     * Return all recipes by this user
     *
     * @param  User
     */
    public function recipes(User $user)
    {
        $recipes = Recipe::where('user_id', $user->id)->get();
        return view('welcome', compact('recipes'));
    }
}
