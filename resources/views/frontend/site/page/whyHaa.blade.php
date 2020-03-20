@extends('frontend.site.layouts.app')

@section('title'){{ __('site.Why') }} {{ __(config('app.name')) }}@endsection

@section('content')
<div class="jumpo col-xs-12">
    <div class="container">
        <div class="g-head">
            <h3>{{ __('site.Why') }} {{ __(config('app.name')) }}</h3>
            <p>{{__('paragraph."ًWhyHaa_description')}}</p>
        </div>
    </div>
</div>

<div class="whyhaa col-xs-12">
    <div class="container">
        <div class="why-img col-md-8 col-xs-12" data-aos="fade-up-left" data-aos-duration="1500">
            <img src="{{ asset('/frontend/images/user-h1.png') }}" alt="user">
        </div>
        <div class="why-data col-md-4 col-xs-12">
            <div class="g-head">
                <h3 data-aos="fade-up" data-aos-duration="1000">{{__("paragraph.Student")}}</h3>
            </div>
            <ol data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                <li>{{__("paragraph.Student_1")}}</li>
                <li>{{__("paragraph.Student_2")}}</li>
                <li>{{__("paragraph.Student_3")}}</li>
                <li>{{__("paragraph.Student_4")}}</li>
                <li>{{__("paragraph.Student_5")}}</li>
                {{-- <li>Facilitate communication with companies</li> --}}
            </ol>
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">{{__('site.START_NOW')}}</a>
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
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">{{__('site.START_NOW')}}</a>
        </div>
    </div>
</div>
@endsection
