@extends('layouts.wrapper')
@section('content')

<div class="row global-spacing top">
    <div class="column small-12 medium-6 large-6 large-offset-3">
        <div class="callout">
            <div class="column">Login</div>
            <form role="form" method="POST" action="{{ url('/login') }}">
                {{ csrf_field() }}

                <div class="column {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="column {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Password</label>

                    <div>
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="column">
                    <div>
                            <label>
                                <input type="checkbox" name="remember">Remember Me
                            </label>
                    </div>
                </div>

                <div>
                    <div class="col-md-8 col-md-offset-4">
                        <button type="submit" class="button full-width">
                            Login
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                            Forgot Your Password?
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
