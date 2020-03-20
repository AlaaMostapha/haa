@extends('frontend.user.layouts.notlogged')
@section('subtitle'){{ __('Verify') }}@endsection
@section('content')
<div class="sign-area col-xs-12 vheight">
    <div class="container">
        <div class="sign-inner col-md-7 col-xs-12 positionCentered">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('frontend/images/haa-arabic-logo-2.png') }}" alt="logo">
                <h3>{{ __('site.Welcome to Haa Platform') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="choose-inner">
                    @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        {{ __('A Fresh Verification Link Has Been Sent To Your Email Address') }}
                    </div>
                    @endif
                    <p>{{__('verification_mail_text')}}</p>
                    <p>{{__('re_verification_mail_text')}}</p>
                    <a href="{{ route('verification.resend') }}">{{ __('verification_resend_mail') }}</a>.
                {{-- <p> <form>{{__('browsing_without_active_account')}}</a></p> --}}
                    <p>
                            <form id="logout-form" action="{{ route('user.logout') }}" method="POST" style="display: none;">
                                    @csrf
                            </form>
                            <a class="dropdown-item" href="{{ route('user.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> {{__('browsing_without_active_account')}}
                            </a>

                    </p>
            </div>
        </div>
    </div>
</div>
@endsection
