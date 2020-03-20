@extends('frontend.site.layouts.app')

@section('title'){{ __('Contact us')  }}@endsection
@section('footer')@endsection
@section('content')


<div class="sign-area col-xs-12 vheight">
    <div class="spacer">
        &nbsp;
    </div>
    <div class="container">
        <div class="sign-inner col-md-8 col-xs-12 top-custom positionCenter top-add ">
            <div class="sign-head col-xs-12">
                <img src="{{ asset('/frontend/images/haa-arabic-logo-2.png') }}" alt="Logo">
                <h3>{{ __('Contact us') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="sign-form col-xs-12">
                <form class="dev-validate-form" method="POST" action="{{route('contactus.save')}}">
                    @csrf
                    <div class="row">

                        <div class="form-group col-lg-6 col-xs-12 @error('name') has-error @enderror">
                            <input type="text" class="form-control" placeholder="{{ __('user.name') }}" name="name"
                                value="{{ old('name') }}" autocomplete="name" minlength="3" maxlength="170">
                            @error('name')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <b class="required">*</b>
                        </div>
                        <div class="form-group col-lg-6 @error('email') has-error @enderror">
                            <input type="email" class="form-control" placeholder="{{ __('Email-only') }}" name="email"
                                value="{{ old('email') }}" required="" autocomplete="email" autofocus="">
                            @error('email')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <b class="required">*</b>
                        </div>
                        <div class="form-group col-lg-12 col-xs-12 mb-0 @error('phone') has-error @enderror">
                            <input type="text" class="form-control english-text " placeholder="{{ __('Phone') }}"
                                maxlength="13" minlength="13" name="phone" value="{{ old('phone') }}"
                                autocomplete="mobile">
                        </div>
                        <span class="english-text col-lg-12 col-xs-12" style="line-height:3.5">Ex: +966 5X XXX
                            XXXX</span>
                        @error('phone')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <div class="form-group  col-lg-12  @error('message') has-error @enderror">
                            <textarea class="form-control" placeholder="{{ __('Enter your message') }}" name="message"
                                minlength="3" maxlength="1000">{{ old('message') }}</textarea>
                            @error('message')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <b class="required">*</b>
                        </div>

                        <div class="form-group col-lg-12 text-center">
                            <button type="submit" class="btn">{{ __('Send Message') }} →</button>
                        </div>
                    </div>

            </div>
            </form>
        </div>
    </div>
</div>
</div>
</div>

@endsection
