@extends('layouts.app')

@section('content')
    <img src="{{ $recipe->cover }}" alt="{{ $recipe->title }}">
    <h1>{{ $recipe->title }}</h1>
    @if ($recipe->isOwner())
        <a href="/recipe/{{ $recipe->id }}/update">Edit</a>
        <form action="/recipe/{{ $recipe->id }}/delete" method="POST">
            <button type="submit">Delete</button>
        </form>
    @endif
    <p>{{ $recipe->description }}</p>
@endsection
