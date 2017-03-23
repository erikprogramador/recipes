@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Welcome to recipes</h1>

        @if ($recipes->count() <= 0)
            <div class="card-panel red lighten-2">
                <h5 class="white-text">Be the first to write a recipe!</h5>
            </div>
        @else
            @foreach ($recipes as $recipe)
                @include('recipies.includes.list')
            @endforeach
        @endif
    </div>
@endsection
