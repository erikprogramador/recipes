<?php

namespace App\Http\Controllers;

use App\Recipe;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function print(Recipe $recipe)
    {
        $print = PDF::loadView('recipes.print', compact('recipe'));
        return $print->download($recipe->title.'.pdf');
    }
}
