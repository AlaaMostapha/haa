@extends('frontend.company.layouts.notlogged')

@section('subtitle'){{ __('Reset Password') }}@endsection

@section('content')
<div class="sign-area col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner  col-md-7 col-xs-12 positionCentered">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="Logo">
                <h3>{{ __('Reset Password') }}</h3>
            </div>
            <div class="sign-form col-xs-12">
                <div class="col-xs-12 form-group">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ route('company.password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group col-xs-12 @error('email') has-error @enderror">
                        <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="email" value="{{ $email ?? old('email') }}" required="" autocomplete="email" autofocus="">
                        @error('email')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12 @error('password') has-error @enderror">
                        <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password" required="" autocomplete="new-password">
                        @error('password')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12 @error('password_confirmation') has-error @enderror">
                        <input type="password" class="form-control" placeholder="{{ __('Confirm Password') }}" name="password_confirmation" required="" autocomplete="new-password">
                        @error('password_confirmation')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn">{{ __('Reset Password') }}</button>
                    </div>
                </form>
            </div>
            <div class="choose-inner col-xs-12">
                <p><a href="{{ route('company.login') }}">{{ __('Login') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
