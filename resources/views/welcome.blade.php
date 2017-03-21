@extends('layouts.app')

@section('content')
    <h1>Welcome to recipes</h1>
    <ul>
        @foreach ($recipes as $recipe)
            <li>{{ $recipe->title }}</li>
        @endforeach
    </ul>
@endsection
