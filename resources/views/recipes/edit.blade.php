@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <h1>Create a recipe</h1>
                <form action="/recipe/store" method="POST">
                    @include('recipes.includes.form')
                </form>
            </div>
        </div>
    </div>
@endsection
