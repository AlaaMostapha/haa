@extends('dashboard.layout.notlogged')

@section('title', __('Reset Password'))

@section('content')
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">{{ __('Reset Password') }}</h2>

                    <div class="row">

                        <div class="col-lg-12">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form class="m-t" role="form" method="POST" action="{{ route('dashboard.password.request') }}">
                                @csrf

                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ request('email') }}">

                                <div class="form-group">
                                    <input type="password" autocomplete="off" class="form-control{{ $errors->has('password') ? ' error' : '' }}" placeholder="{{ __('Password') }}" name="password" required="">
                                    @if ($errors->has('password'))
                                    <label id="password-error" class="error" for="password">{{ $errors->first('password') }}</label>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <input type="password" autocomplete="off" class="form-control{{ $errors->has('password_confirmation') ? ' error' : '' }}" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required="">
                                    @if ($errors->has('password_confirmation'))
                                    <label id="password-confirmation-error" class="error" for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Reset Password') }}</button>

                            </form>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.login') }}">
                        <small>{{ __('Login') }}</small>
                    </a>
                </div>
            </div>
        </div>
        @include('dashboard.layout.notloggedfooter')
    </div>
@endsection
