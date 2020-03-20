@extends('frontend.site.layouts.app')

@section('title'){{ __('site.Join') }} {{ __(config('app.name')) }}@endsection
@section('footer')@endsection

@section('content')
<div class="sign-area col-xs-12 vheight">

    <div class="container">
        <div class="sign-inner col-md-8 col-ms-12 positionCentered">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('frontend/images/haa-arabic-logo-2.png') }}" alt="logo">
                <h3>{{ __('site.Welcome to Haa Platform') }}</h3>
            </div>
            <div class="choose-inner">
                <h4>{{ __('Login') }}:</h4>
                    <div class="choose-inner">
                        <a href="{{ route('user.login') }}" class="btn">{{ __('user.User') }}</a>
                        <a href="{{ route('company.login') }}" class="btn btn-company">{{ __('site.Company') }}</a>
                    </div>
                </div>
        </div>
    </div>
</div>
@endsection
