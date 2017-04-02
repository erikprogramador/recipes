<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto Mono', sans-serif;
        }
    </style>
</head>
<body>
    <div id="app">
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
                </div>
            </div>
        </div>
    </div>
</body>
</html>
