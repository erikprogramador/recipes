@extends('layouts.app')

@section('content')
    <h1>Create a recipe</h1>
    <form action="/recipe/store">
        {{ csrf_field() }}
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" placeholder="Title">
        <label for="title">Title:</label>
        <textarea name="description" id="description" rows="10">Description</textarea>

        <input type="file" name="cover" id="cover">

        <button type="submit">Save</button>
    </form>
@endsection
