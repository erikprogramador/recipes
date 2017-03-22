@extends('layouts.app')

@section('content')
    <h1>{{ $recipe->title }}</h1>
    <p>{{ $recipe->description }}</p>
@endsection
