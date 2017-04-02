@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col s8 offset-s2">
                <h1>{{ $recipe->title }}</h1>
                <span><strong>{{ $recipe->owner->name }}</strong> <small>{{ $recipe->created_at->diffForHumans() }}</small></span>
                @foreach ($recipe->categories as $category)
                    <span class="new badge blue">{{ $category->title }}</span>
                @endforeach
                <hr>
                <img class="responseive-img" width="100%" src="{{ $recipe->cover }}" alt="{{ $recipe->title }}">
                @if ($recipe->isOwner())
                    <div class="row">
                        <div class="col s6 offset-s6">
                            <div class="row">
                                <div class="col col-6">
                                    <a class="btn blue" href="/recipe/{{ $recipe->id }}/update">Edit</a>
                                </div>
                                <div class="col col-6">
                                    <form action="/recipe/{{ $recipe->id }}/delete" method="POST">
                                        <button class="btn red" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
                <p>{{ $recipe->description }}</p>
                <a href="/print/recipe/{{ $recipe->id }}" class="btn purple">Print</a>
            </div>
        </div>
    </div>
@endsection
