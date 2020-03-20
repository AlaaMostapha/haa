@extends('frontend.company.layouts.app')

@section('subtitle'){{ __('Edit account') }}@endsection

@section('content')
<div class="sign-area test col-xs-12">
    <div class="container">
        <div class="custom-user sign-inner col-md-9 col-xs-12">
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
            <div class="sign-form col-xs-12">
                @include('frontend.company.profile.form', ['signupPage' => false, 'submitUrl' => route('company.profile.update'), 'submitButtonText' => __('Edit account')])
            </div>
        </div>
    </div>
</div>
@endsection
