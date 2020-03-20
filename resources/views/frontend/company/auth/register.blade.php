@extends('frontend.company.layouts.notlogged')

@section('subtitle'){{ __('Signup') }}@endsection
@section('footer')@endsection
@section('content')
<div class="sign-area col-xs-12">
<div class="spacer">
    &nbsp;
</div>
    <div class="container user-wrapper">
        <div class="sign-inner col-md-8 col-xs-12 ">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('frontend/images/haa-arabic-logo-2.png') }}" alt="Logo">
                <h3>{{ __('Signup') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="sign-form col-xs-12">
                @include('frontend.company.profile.form', ['signupPage' => true, 'submitUrl' => route('company.register'), 'submitButtonText' => __('Signup')])
            </div>
            <div class="choose-inner col-xs-12">
                <p>{{ __('Already have an account ?') }} <a href="{{ route('company.login') }}">{{ __('Login') }}</a></p>
            </div>
        </div>
    </div>
</div>
@endsection
