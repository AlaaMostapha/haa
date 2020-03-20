@extends('frontend.common.app')

@section('title'){{ __('user.User') }} | @yield('subtitle')@endsection

@section('header')
<header class="main-head inner-head col-xs-12">
    <div class="container">
        <div class="logo">
            <a href="{{ route('home') }}">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="logo">
            </a>
        </div>
        <div class="h-extra">
            <div class="main-nav">
                    @include('frontend.user.layouts.header.menu')
            </div>
            <div class="user-srea">
                            @include('frontend.user.layouts.header.notification')
            </div>
            <button type="button" class="open-menu">
                <i class="fa fa-bars"></i>
            </button>
        </div>
    </div>
    <div class="overlay_gen"></div>
    <div class="sidebar">
        <div class="inner">
            <div class="side-user">
                <div class="user-img" style="background-image: url({{ asset('/frontend/images/hero.png') }}">
                    @if(auth()->user()->user_personal_photo)
                    <img src="{{ auth()->user()->user_personal_photo }}" alt="{{ auth()->user()->firstName . ' ' . auth()->user()->lastName }}">
                    @endif
                    <span>{{ auth()->user()->firstName . ' ' . auth()->user()->lastName }}</span>
                </div>
                <ul>
                    <li>
                        <a href="{{ route('user.profile.show') }}">
                            <i class="fa fa-user-o"></i>
                            {{ __('My profile') }}
                        </a>
                    </li>
                    <li>
                        <a href="#" class="dev-logout"><i class="fa fa-sign-out"></i> {{ __('Logout') }}</a>
                    </li>
                </ul>
            </div>
            <div class="side-links">
                <h4>{{ __('site.Menu') }}</h4>
<!--                <ul>
                    <li>
                        <a href="{{ route('user.tasks.index') }}">{{ __('companytask.Tasks') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user.tasks.myTasks') }}">{{ __('companytask.My tasks') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('user.profile.edit') }}">{{ __('Edit account') }}</a>
                    </li>
                </ul>-->
                    @include('frontend.user.layouts.header.menu')
            </div>
        </div>
    </div>

</header>
@endsection

@section('footer')
@include('frontend.common.footer')
@endsection