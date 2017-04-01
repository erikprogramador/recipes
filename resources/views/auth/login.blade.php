@extends('layouts.app')

@section('content')
    <div class="container auth-form">
        <div class="row">
            <div class="col m6 offset-m3 s12">
                <form role="form" method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}

                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                            <strong>{{ $errors->first('email') }}</strong>
                    @endif

                    <label for="password" class="col-md-4 control-label">Password</label>
                    <input id="password" type="password" class="form-control" name="password" required>

                    @if ($errors->has('password'))
                        <strong>{{ $errors->first('password') }}</strong>
                    @endif

                    <label>
                    </label>

                    <div>
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label for="remember">Remember Me</label>
                    </div>

                    <div class="input-field">
                        <button type="submit" class="btn btn-primary">
                            Login
                        </button>
                        <a href="{{ route('password.request') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
