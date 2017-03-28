<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    protected $recipe;

    public function __construct(Recipe $recipe)
    {
        $this->middleware('auth')->except(['show']);
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
        //
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
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required:max:100',
            'description' => 'required',
            'cover' => 'required',
            'category_id' => 'required'
        ]);
        $recipe = $this->recipe->createWithCategories($request->only(['title', 'description', 'cover']), $request->category_id);
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
    public function update(Request $request, Recipe $recipe)
    {
        $this->validate($request, [
            'title' => 'required:max:100',
            'description' => 'required',
            'cover' => 'required'
        ]);
        $recipe->update($request->only(['title', 'description', 'cover']));
        $feature = $request->featured ? $recipe->feature() : $recipe->unfeature();

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
}
