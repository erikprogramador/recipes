<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::all();
        return view('welcome', compact('recipes'));
    }
}
