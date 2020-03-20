@extends('frontend.site.layouts.app')

@section('title'){{ __('Home page') }}@endsection

@section('content')

<style>
    .whyhaa .why-data-student .g-head h3:after {
        right: 40% !important;
    }

    .whyhaa .why-data-comp .g-head h3:after {
        right: 40% !important;
    }

</style>


<div class="hero-s col-xs-12">
    <div class="inner" style="background-image: url({{ asset('/frontend/images/hero.png') }});  background-repeat: no-repeat;">
        <div class="container">
            <div class="caption col-md-7 col-xs-12 mb-2">
                <h3 data-aos="fade-up" data-aos-duration="1000" style="color:#fff">منصة هاء; </h3>
                <h2 data-aos="fade-up" data-aos-duration="1000" data-aos-delay="500" style="font-weight:bold"> الوجهة الأيسر لأصحاب الأعمال
                    والشباب الجامعي الشغوف</h2>
                <p data-aos="fade-up" data-aos-duration="1000" data-aos-delay="700"> منصة إلكترونية تسعى لتقليص الفجوة
                    بين أصحاب الأعمال والشباب الجامعي لإنجاز المهام بسهولة.</p>
                <div class="show-more-container">
                    <a href="{{route('join-haa')}}" class="btn join-haa-btn p-0 mb-0" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="900" style="width:15rem;height:5rem;">{{__('site.START_NOW')}}</a>
                    <a href="{{route('about')}}" class="btn btn-border p-0" data-aos="fade-up" data-aos-duration="1000"
                        data-aos-delay="1000" style="width:15rem;height:5rem;">{{__('site.LEARN_MORE')}}</a>
                </div>
            </div>
        </div>
    </div>
</div>
<video class='home-page-video' style="width:100%" controls>
    <source src="{{ asset('/frontend/videos/Haa_Animation_New_2.mp4') }}" type="video/mp4">
</video>
<div class="hworks col-xs-12" id="hworks">
    <div class="container">
        <div class="g-head col-xs-12 title">
            <h3>{{__("paragraph.How_it_works?")}} </h3>
            {{-- <p>Quick wafting zephyrs vex bold Jim. Quick zephyrs blow, vexing daft Jim. Charged fop blew my junk TV quiz. </p> --}}
        </div>
        <div class="g-body col-xs-12">
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/company-h1.png') }}" alt="">
                    </div>
                    <h3>{{__("paragraph.Post_a_Task")}}</h3>
                    <p> {{__("paragraph.Post_a_Task_description")}}</p>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="500">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h4.png') }}" alt="">
                    </div>
                    <h3>{{__("paragraph.select")}}</h3>
                    <p> {{__("paragraph.select_description")}}</p>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="700">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h1.png') }}" alt="">
                    </div>
                    <h3>{{__("paragraph.Confirm")}}</h3>
                    <p> {{__("paragraph.Confirm_description")}}</p>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="900">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/company-h4.png') }}" alt="">
                    </div>
                    <h3>{{__("paragraph.Review")}}</h3>
                    <p>{{__("paragraph.Review_description")}}</p>
                </div>
            </div>
        </div>
        <div class="g-footer col-xs-12">
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="00">{{__('site.START_NOW')}}</a>
            <a href="{{route('about')}}" class="btn btn-border" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="700">{{__('site.LEARN_MORE')}}</a>
        </div>
    </div>
</div>

<div class="hworks hworks-student col-xs-12" style="display: none;">
    <div class="container">
        <div class="g-head col-xs-12 ">
            <h3>{{__('paragraph.How_it_works?')}}</h3>
            <p>Quick wafting zephyrs vex bold Jim. Quick zephyrs blow, vexing daft Jim. Charged fop blew my junk TV
                quiz. </p>
        </div>
        <div class="g-body col-xs-12">
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h1.png') }}" alt="">
                    </div>
                    <h3>register</h3>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="500">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h2.png') }}" alt="">
                    </div>
                    <h3>find</h3>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="600">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h3.png') }}" alt="">
                    </div>
                    <h3>apply</h3>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="700">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h4.png') }}" alt="">
                    </div>
                    <h3>complete</h3>
                </div>
            </div>
            <div class="block" data-aos="fade-up-right" data-aos-duration="1000" data-aos-delay="800">
                <div class="inner">
                    <div class="i-ico">
                        <img src="{{ asset('/frontend/images/user-h5.png') }}" alt="">
                    </div>
                    <h3>Get Reward</h3>
                </div>
            </div>
        </div>
        <div class="g-footer col-xs-12">
            <a href="{{route('join-haa')}}" class="btn" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="00">{{__('site.START_NOW')}}</a>
            <a href="{{route('about')}}" class="btn btn-border" data-aos="fade-up" data-aos-duration="1000"
                data-aos-delay="700">{{__('site.LEARN_MORE')}}</a>

        </div>
    </div>
</div>
<div>
    <div class="g-head title text-center  col-xs-12 mt-5">
        <h3 data-aos="fade-up" data-aos-duration="1000">{{__('paragraph.Why_Haa?')}}</h3>
    </div>
</div>

<div class="whyhaa col-xs-12 p-0 pb-2">
    <div class="container">
        <div class="why-img col-md-6 col-xs-12" data-aos="fade-up-left" data-aos-duration="1500">
            <img src="{{ asset('/frontend/images/user-h1.png') }}" alt="user">
        </div>
        <div class="why-data col-md-6 col-xs-12">
            <div class="g-head">
                <h3 data-aos="fade-up" data-aos-duration="1000" class="mb-0 pb-0">{{__("paragraph.Student")}}</h3>
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

<div class="whyhaa why-sec col-xs-12 pb-2">
    <div class="container">
        <div class="why-img col-md-6 col-xs-12" data-aos="fade-up-left" data-aos-duration="1500">
            <img src="{{ asset('/frontend/images/why-company.png') }}" alt="company" style="height: 323px;">
        </div>
        <div class="why-data col-md-6 col-xs-12">
            <div class="g-head">
                <h3 data-aos="fade-up" data-aos-duration="1000" class="mb-0 pb-0">{{__('company.companies')}}</h3>
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
