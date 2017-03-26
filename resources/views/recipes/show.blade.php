@extends('layouts.app')

@section('content')
    <h1>{{ $recipe->title }}</h1>
    @if ($recipe->isOwner())
        <a href="/recipe/{{ $recipe->id }}/update">Edit</a>
    @endif
    <p>{{ $recipe->description }}</p>
@endsection
