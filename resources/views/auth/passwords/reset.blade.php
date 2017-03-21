@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.request') }}">
        {{ csrf_field() }}

        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

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

        @if ($errors->has('password_confirmation'))
            <strong>{{ $errors->first('password_confirmation') }}</strong>
        @endif

        <button type="submit" class="btn btn-primary">Reset Password</button>
    </form>
@endsection
