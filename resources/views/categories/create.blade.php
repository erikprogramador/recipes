@extends('layouts.app')

@section('content')
    <h1>Create a category</h1>
    <form action="/category/store" method="POST">
        <label for="title">Title</label>
        <input type="text" name="title" id="title">
        <button type="submit">Create</button>
    </form>
@endsection
