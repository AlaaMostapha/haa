@extends('frontend.user.layouts.notlogged')

@section('subtitle'){{ __('Login') }}@endsection
@section('footer')@endsection
@section('content')
<div class="sign-area col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner col-md-8 col-xs-12 positionCenter">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="Logo">
                <h3>{{ __('Login') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="sign-form col-xs-12">
                <form method="POST" action="{{ route('user.login') }}">
                    @csrf
                    <div class="form-group col-xs-12 @error('university_email') has-error @enderror">
                        <input type="email" class="form-control" placeholder="{{ __('Email') }}" name="university_email" value="{{ old('university_email') }}" required="" autocomplete="email" autofocus="">
                        @error('university_email')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12 @error('password') has-error @enderror">
                        <input type="password" class="form-control" placeholder="{{ __('Password') }}" name="password" required="" autocomplete="current-password">
                        @error('password')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group col-xs-12">
                        <label class="rem">
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span class="l-txt">{{ __('Remember Me') }}</span>
                        </label>
                        <a href="{{ route('user.password.request') }}" class="forgot">{{ __('Forgot your password ?') }}</a>
                    </div>
                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn">{{ __('Login') }} →</button>
                    </div>
                </form>
            </div>
            <div class="choose-inner col-xs-12">
                <p>{{ __('Do not have an account ?') }} <a href="{{ route('user.register') }}">{{ __('Signup') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
