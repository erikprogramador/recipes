@extends('layouts.app')

@section('content')
    @if (session('status'))
        {{ session('status') }}
    @endif

    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
        {{ csrf_field() }}

        <label for="email" class="col-md-4 control-label">E-Mail Address</label>
        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

        @if ($errors->has('email'))
            <strong>{{ $errors->first('email') }}</strong>
        @endif

        <button type="submit" class="btn btn-primary">
            Send Password Reset Link
        </button>
    </form>
@endsection
