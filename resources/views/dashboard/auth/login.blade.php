@extends('dashboard.layout.notlogged')

@section('title', __('Login'))

@section('content')
    <div class="loginColumns animated fadeInDown">
        <div class="row">

            <div class="col-md-6">
                <h2 class="font-bold">{{ __(config('app.name')) }}</h2>
            </div>
            <div class="col-md-6">
                @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="ibox-content">
                    <form class="m-t" role="form" method="POST" action="{{ route('dashboard.login') }}">
                        @csrf
                        <div class="form-group">
                            <input type="email" class="form-control{{ $errors->has('email') ? ' error' : '' }}" placeholder="{{ __('E-Mail Address') }}" required="" name="email" value="{{ old('email') }}" autofocus="">
                            @if ($errors->has('email'))
                            <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" autocomplete="off" class="form-control{{ $errors->has('password') ? ' error' : '' }}" placeholder="{{ __('Password') }}" name="password" required="">
                            @if ($errors->has('password'))
                            <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                            @endif
                        </div>
                        <div class="form-group">
                            <input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <label for="remember">{{ __('Remember Me') }}</label>
                        </div>
                        <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Login') }}</button>

                        <a href="{{ route('dashboard.password.request') }}">
                            <small>{{ __('Forgot Your Password ?') }}</small>
                        </a>
                    </form>
                </div>
            </div>
        </div>
        @include('dashboard.layout.notloggedfooter')
    </div>
@endsection
