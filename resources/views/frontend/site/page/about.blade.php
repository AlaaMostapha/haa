@extends('frontend.site.layouts.app')

@section('title'){{ __('About') }} {{ __(config('app.name')) }}@endsection

@section('content')
<div class="jumpo col-xs-12">
    <div class="container">
        <div class="g-head">
            <div class="row justify-content-center">
            <div class="col-md-4 mb-1 about-div">
                    <div class="about-divs">
                    <img src="{{ asset('/frontend/images/ic_vision-3x.png') }}" alt="user">
                        <h3 style="margin-bottom: 0;padding-top: 20px;">{{__('paragraph.about_vision')}}</h3>
                        <p class="desc">{{__('paragraph.about_vision_message')}}</p>
                    </div>
                </div>
                <div class="col-md-4 mb-1 about-div">
                    <div class="about-divs">
                    <img src="{{ asset('/frontend/images/ic_haa_yellow-3x.png') }}" alt="user">
                        <h3 style="margin-bottom: 0;padding-top: 20px;">{{ __('About') }} {{ __(config('app.name')) }} </h3>
                        <p class="desc">{{__('paragraph.about_description')}}</p>
                    </div>
                </div>

                <div class="col-md-4 mb-1 about-div">
                    <div class="about-divs">
                    <img src="{{ asset('/frontend/images/ic_message-3x.png') }}" alt="user">
                        <h3 style="margin-bottom: 0;padding-top: 20px;">{{__('paragraph.about_message')}} </h3>
                        <p class="desc"> {{__('paragraph.about_message_description')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="whyhaa col-xs-12">
    <div class="container">
        <div class="why-img col-md-6 col-xs-12" data-aos="fade-up-left" data-aos-duration="1500">
            <img src="{{ asset('/frontend/images/user-h1.png') }}" alt="user">
        </div>
        <div class="why-data col-md-6 col-xs-12">
            <div class="g-head">
                <h3 data-aos="fade-up" data-aos-duration="1000">{{__("paragraph.Student")}}</h3>
            </div>
            <ol data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                <li>{{__('paragraph.Student_1')}}</li>
                <li>{{__('paragraph.Student_2')}}</li>
                <li>{{__('paragraph.Student_3')}}</li>
                <li>{{__('paragraph.Student_4')}}.</li>
            </ol>
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="800">{{__('site.START_NOW')}}</a>
        </div>
    </div>
</div>

<div class="whyhaa why-sec col-xs-12">
    <div class="container">
        <div class="why-img col-md-6 col-xs-12" data-aos="fade-up-left" data-aos-duration="1500">
            <img src="{{ asset('/frontend/images/why-company.png') }}" alt="company">
        </div>
        <div class="why-data col-md-6 col-xs-12">
            <div class="g-head">
                <h3 data-aos="fade-up" data-aos-duration="1000">{{__('company.companies')}}</h3>
            </div>
            <ol data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                <li>{{__('paragraph.Company_1')}}</li>
                <li>{{__('paragraph.Company_2')}}</li>
                <li>{{__('paragraph.Company_3')}}</li>
                <li>{{__('paragraph.Company_4')}}</li>
            </ol>
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="800">{{__('site.START_NOW')}}</a>
        </div>
    </div>
</div>
@endsection
