<?php

namespace App\Http\Controllers;

use App\Recipe;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class PrintController extends Controller
{
    /**
     * Print a recipe
     *
     * @param  Recipe
     */
    public function print(Recipe $recipe)
    {
        $print = PDF::loadView('recipes.print', compact('recipe'));
        return $print->download($recipe->title.'.pdf');
    }
}
