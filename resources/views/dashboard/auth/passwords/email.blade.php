@extends('dashboard.layout.notlogged')

@section('title', __('Reset Password'))

@section('content')
    <div class="passwordBox animated fadeInDown">
        <div class="row">

            <div class="col-md-12">
                <div class="ibox-content">

                    <h2 class="font-bold">{{ __('Reset Password') }}</h2>

                    <div class="row">

                        <div class="col-lg-12">
                            @if (session('status'))
                                <div class="alert alert-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form class="m-t" role="form" method="POST" action="{{ route('dashboard.password.email') }}">
                                @csrf
                                <div class="form-group">
                                    <input type="email" class="form-control{{ $errors->has('email') ? ' error' : '' }}" placeholder="{{ __('E-Mail Address') }}" required="" name="email" value="{{ old('email') }}" autofocus="">
                                    @if ($errors->has('email'))
                                    <label id="email-error" class="error" for="email">{{ $errors->first('email') }}</label>
                                    @endif
                                </div>

                                <button type="submit" class="btn btn-primary block full-width m-b">{{ __('Send Password Reset Link') }}</button>

                            </form>
                        </div>
                    </div>
                    <a href="{{ route('dashboard.login') }}">
                        <small>{{ __('Login') }}</small>
                    </a>
                </div>
            </div>
        </div>
        @include('dashboard.layout.notloggedfooter')
    </div>
@endsection