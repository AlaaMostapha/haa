@extends('frontend.site.layouts.app')

@section('title'){{ __('Terms and Conditions') }}@endsection

@section('content')
<div class="jumpo col-xs-12">
    <div class="container">
        <div class="g-head">
            <h3>{{ __('Terms and Conditions') }}</h3>
            <p>Working in Haa platform provide a lot of benefits for both students and companies</p>
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
                <h3 data-aos="fade-up" data-aos-duration="1000">Student</h3>
            </div>
            <ol data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                <li>Gain practical knowledge.</li>
                <li>Make a well-known name among the companies.</li>
                <li>Certification after every accomplished task.</li>
                <li>New tasks notifications related to your major.</li>
                <li>Get paid for your works.</li>
                <li>Facilitate communication with companies</li>
            </ol>
            <a href="#" class="btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">START now</a>
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
                <h3 data-aos="fade-up" data-aos-duration="1000">Company</h3>
            </div>
            <ol data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700">
                <li>Find competent student to work with later</li>
                <li>Ability to choose the best task applicant</li>
                <li>Enhance the company productivity</li>
                <li>Facilitate communication with students</li>
                <li>online payment</li>
            </ol>
            <a href="#" class="btn" data-aos="fade-up" data-aos-duration="1000" data-aos-delay="800">START hiring</a>
        </div>
    </div>
</div>
@endsection
