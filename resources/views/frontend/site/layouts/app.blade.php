@extends('frontend.common.app')

@section('header')
<header class="main-head col-xs-12">
    <div class="container">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="logo" class="lap-logo">
            </a>
        </div>
        <div class="h-extra">
            <div class="main-nav">
                @if(Auth::guard('company')->user() && !Auth::guard('company')->user()->suspendedByAdmin)
                    @include('frontend.company.layouts.header.menu')
                @elseif(Auth::guard('user')->user() && !Auth::guard('user')->user()->suspendedByAdmin)
                    @include('frontend.user.layouts.header.menu')
                @else
                    @include('frontend.site.layouts.header.menu')
                @endif
            </div>
            <div class="user-srea">
                @if(Auth::guard('company')->user() && !Auth::guard('company')->user()->suspendedByAdmin)
                    @include('frontend.company.layouts.header.notification')
                @elseif(Auth::guard('user')->user() && !Auth::guard('user')->user()->suspendedByAdmin)
                    @include('frontend.user.layouts.header.notification')
                @else
                    <!-- <div class="visitor">
                        <a href="{{ route('join-haa-login') }}" class="btn login">{{ __('Login') }}</a>
                        <a href="{{ route('join-haa') }}" class="btn">{{ __('site.Join') }} {{ __(config('app.name')) }}</a>
                    </div> -->
                @endif
            </div>
            <button type="button" class="open-menu">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
    <div class="overlay_gen"></div>
    <div class="sidebar">
        <div class="inner">
            <div class="side-links">
                <h4>{{ __('site.Menu') }}</h4>
                @if(Auth::guard('company')->user() && !Auth::guard('company')->user()->suspendedByAdmin)
                    @include('frontend.company.layouts.header.menu')
                @elseif(Auth::guard('user')->user() && !Auth::guard('user')->user()->suspendedByAdmin)
                    @include('frontend.user.layouts.header.menu')
                @else
                    @include('frontend.site.layouts.header.menu')
                @endif
            </div>
        </div>
    </div>
</header>
@endsection

@section('footer')
@include('frontend.common.footer')
@endsection
