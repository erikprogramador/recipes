<?php

namespace App\Http\Controllers;

use App\{
    User,
    Recipe
};
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function recipes(User $user)
    {
        $recipes = Recipe::where('user_id', $user->id)->get();
        return view('welcome', compact('recipes'));
    }
}
