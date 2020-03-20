@extends('frontend.user.layouts.app')

@section('subtitle'){{ __('Edit account') }}@endsection

@section('content')
<div class="sign-area col-xs-12">
    <div class="container">
        <div class="custom-user col-md-9 sign-inner col-xs-12">
            <div class="sign-head col-xs-12">
                <h3>{{ __('Edit account') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            @if (session('successMessage'))
            <div class="col-xs-12 form-group">
                <div class="alert alert-success" role="alert">
                    {{ session('successMessage') }}
                </div>
            </div>
            @endif
            {{-- @if (session('failMessage'))
            <div class="col-xs-12 form-group">
                <div class="alert alert-danger" role="alert">
                    {{ session('failMessage') }}
                </div>
            </div>
            @endif --}}
            <div class="sign-form col-xs-12">
                @include('frontend.user.profile.form', ['signupPage' => false, 'submitUrl' => route('user.profile.update'), 'submitButtonText' => __('Edit account')])
            </div>
        </div>
    </div>
</div>
@endsection
