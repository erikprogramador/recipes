@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <h1>Create a recipe</h1>
                <form action="/recipe/store" method="POST">
                    {{ csrf_field() }}
                    <div class="input-field">
                        <label for="title">Title:</label>
                        <input type="text" name="title" id="title" placeholder="Title" value="{{ $recipe->title }}">
                    </div>
                    <div class="input-field">
                        <label for="description">Description:</label>
                        <textarea name="description" id="description" class="materialize-textarea" rows="10" placeholder="Description">{{ $recipe->description }}</textarea>
                    </div>

                    <div>
                        <input type="checkbox" id="featured" {{ $recipe->isFeatured() ?? 'checked' }}>
                        <label for="featured">Featured</label>
                    </div>

                    <div class="file-container">
                        <label for="cover" class="waves-effect waves-light btn red">
                            Select a cover
                        </label>
                        <input type="file" name="cover" id="cover" class="file-input">
                    </div>

                    <div class="center">
                        <button class="btn-floating btn-large waves-effect waves-light red" type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
