<footer class="main-footer col-xs-12" id="footer">
    <div class="container">
        <div class="f-top col-xs-12">
            <div class="f-item col-sm-4 col-xs-12">
                <img src="{{ asset('/frontend/images/footer-logo.png') }}" alt="logo">
                <div class="social">
                    <!-- <a href="#">
                        <i class="fa fa-facebook"></i>
                    </a> -->
                    <a href="https://twitter.com/haaplatform " target="_blanck">
                        <i class="fa fa-twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/haaplatform/">
                        <i class="fa fa-instagram"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?phone=0558930446" target="_blanck">
                        <i class="fa fa-whatsapp"></i>
                    </a>
                </div>
                <div class="call-us">
                <span>{{__('Call us at')}}</span>
                    <a href="tel:0558930446">055 893 0446</a>
                </div>
            </div>
            <div class="f-item col-sm-8 col-xs-12">
                <div class="f-sm-item col-sm-4 col-xs-4">
                <h3>{{__('Company')}}</h3>
                    <ul>
                        <li>
                        <a href="{{route('home')}}">{{__('Home')}}</a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}">{{ __('About') }} {{ __(config('app.name')) }}</a>
                        </li>
                        <li>
                        <a href="#hworks">{{__('Services')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="f-sm-item col-sm-4 col-xs-4">
                    <h3>{{ __('site.Getting started') }}</h3>
                    <ul>
                        <li>
                            <a href="{{ route('user.register') }}">{{ __('site.Start as Student') }}</a>
                        </li>
                        <li>
                            <a href="{{ route('company.register') }}">{{ __('site.Start As Company') }}</a>
                        </li>

                    </ul>
                </div>
                <div class="f-sm-item col-sm-4 col-xs-4">
                    <h3>{{__('Help')}}</h3>
                    <ul>
                        <li>
                            <a href="{{route('contactus')}}">{{__('Contact us')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="f-sm-item col-sm-12 col-xs-12 footer-form-container">
                <form action="{{route('subscriber')}}"  id="Subscriber-form"method="post">
                    @csrf
                        <div class="row form-group">
                                <div class="col-md-7 col-sm-7 col-xs-12 p-0 mx-1">
                                <input type="email" id= "email" name="email" class="form-control" placeholder="{{__("email_subscribe")}}">
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12 p-0 mx-1 d-flex">
                                    <button type="submit"  id="save_subscriber" class="btn">{{__("subscribe")}}</button>
                                </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="f-bottom col-xs-12">
            <p>© {{ date('Y') }} {{ __(config('app.name')) }}. @lang('All rights reserved.')</p>
            {{-- <ul class="extra-links">
                <li>
                    <a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a>
                </li>
                <li>
                    <a href="{{ route('terms-and-conditions') }}">{{ __('Terms and Conditions') }}</a>
                </li>
            </ul> --}}
        </div>
    </div>
</footer>
