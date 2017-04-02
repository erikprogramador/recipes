<?php

namespace App\Http\Controllers;

use App\{
    Recipe,
    Ingredient
};
use Illuminate\Http\Request;
use App\Http\Requests\StoreRecipe;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class RecipeController extends Controller
{
    /**
     * Recipe
     * @var \App\Recip
     */
    protected $recipe;

    /**
     * Constructor
     *
     * @param Recipe
     */
    public function __construct(Recipe $recipe)
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('owner')->only(['edit', 'update', 'destroy']);
        $this->recipe = $recipe;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipes = Recipe::all();
        return view('welcome', compact('recipes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recipes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecipe $request)
    {
        $recipe = $this->recipe->createWithCategories($request->only(['title', 'description', 'cover']), $request->category_id);
        if ($request->ingredients && count($request->ingredients) > 0) {
            $recipe->addIngredients($this->ingredientsWithQuantity($request));
        }
        $feature = $request->featured ? $recipe->feature() : $recipe->unfeature();

        return redirect('/recipe/'.$recipe->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        return view('recipes.show', compact('recipe'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        return view('recipes.edit', compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRecipe $request, Recipe $recipe)
    {
        $recipe->update($request->only(['title', 'description', 'cover']));
        $recipe->categories()->sync($request->category_id);
        $feature = $request->featured ? $recipe->feature() : $recipe->unfeature();

        $recipe->ingredients()->delete();
        if ($request->ingredients && count($request->ingredients) > 0) {
            $recipe->addIngredients($this->ingredientsWithQuantity($request));
        }

        return redirect('/recipe/' . $recipe->id)->with(['message' => 'Recipe successfully updated!', 'recipe' => $recipe]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        $recipe->delete();
        return redirect('/')->with('message', 'The recipe is deleted with success!');
    }

    /**
     * Format a array with ingredients and quandities
     *
     * @return array
     */
    public function ingredientsWithQuantity(Request $request)
    {
        return request('ingredients')->map(function ($value, $key) use ($request) {
            return new Ingredient([
                'name' => $value,
                'quantity' => $request->quantity[$key]
            ]);
        });
    }
}
