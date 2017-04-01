@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <h2>Create a category</h2>
                <form action="/category/store" method="POST">
                    {{ csrf_field() }}
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title">
                    <div class="center">
                        <button class="btn-floating btn-large waves-effect waves-light red" type="submit">
                            <i class="material-icons">add</i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
