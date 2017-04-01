@extends('layouts.app')

@section('content')
    <div class="container auth-form">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <form class="form-horizontal" role="form" method="POST" action="{{ route('register') }}">
                    {{ csrf_field() }}

                    <label for="name" class="col-md-4 control-label">Name</label>
                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                    @if ($errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                    @endif

                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                        <strong>{{ $errors->first('email') }}</strong>
                    @endif

                    <label for="password" class="col-md-4 control-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                    @endif

                    <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                    <button type="submit" class="btn btn-primary">Register</button>
                </form>
            </div>
        </div>
    </div>
@endsection
