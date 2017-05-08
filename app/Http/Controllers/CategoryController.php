<?php

namespace App\Http\Controllers;

use App\{Recipe, Category};
use Illuminate\Http\Request;

/**
 * @author Erik Vanderlei Fernandes <erik.vanderlei.programador>
 * @version 1.0.0
 */
class CategoryController extends Controller
{
    protected $category;
    protected $recipe;

    public function __construct(Category $category, Recipe $recipe)
    {
        $this->middleware('auth')->only(['create', 'store']);
        $this->category = $category;
        $this->recipe = $recipe;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['title' => 'required|max:50']);
        $this->category->createWithSlug($request->title);
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $recipes = $this->recipe->byCategory($category);

        return view('welcome', compact('recipes'));
    }
}
