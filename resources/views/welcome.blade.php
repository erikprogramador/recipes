@extends('layouts.app')

@section('content')
    <h1>Welcome to recipes</h1>
    <ul>
        @if ($recipes->count() <= 0)
            <h2>Be the first to write a recipe!</h2>
        @endif
        @foreach ($recipes as $recipe)
            <li>{{ $recipe->title }}</li>
        @endforeach
    </ul>
@endsection
