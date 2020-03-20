@extends('frontend.user.layouts.notlogged')

@section('subtitle'){{ __('Forgot your password ?') }}@endsection

@section('content')
<div class="sign-area col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner col-md-7 col-xs-12 positionCentered">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="Logo">
                <h3>{{ __('Forgot your password ?') }}</h3>
            </div>
            <div class="sign-form col-xs-12">
                <div class="col-xs-12 form-group">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                </div>
                <form method="POST" action="{{ url('/user/password/email') }}">
                    @csrf
                    <div class="form-group col-xs-12 @error('university_email') has-error @enderror">
                        <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="university_email" value="{{ old('university_email') }}" required="" autocomplete="university_email" autofocus="">
                        @error('university_email')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn">{{ __('Submit') }}</button>
                    </div>
                </form>
            </div>
            <div class="choose-inner col-xs-12">
                <p><a href="{{ route('user.login') }}">{{ __('Login') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
