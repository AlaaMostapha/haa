@extends('frontend.site.layouts.app')

@section('title'){{ __('site.Join') }} {{ __(config('app.name')) }}@endsection
@section('footer')@endsection

@section('content')
<div class="sign-area col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner col-md-8 col-xs-12 positionCentered r-50">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('frontend/images/haa-arabic-logo-2.png') }}" alt="logo">
                <h3>{{ __('site.Welcome to Haa Platform') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="choose-inner">
                <h4>{{ __('site.Continue as') }}:</h4>
                <div class="choose-inner">
                    <a href="{{ route('user.register') }}" class="btn">{{ __('user.User') }}</a>
                    <a href="{{ route('company.register') }}" class="btn btn-company">{{ __('site.Company') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
