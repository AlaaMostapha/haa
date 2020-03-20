<hr/>
<div class="row">
    <div class="col-md-6">
        <strong>{{ __('Copyright') }}</strong> {{ __(config('app.name')) }} &copy; {{ date('Y') }}
    </div>
    {{-- <div class="col-md-6 {{ app()->getLocale() === 'en' ? 'text-right' : 'text-left' }}">
        <a class="dropdown-item btn" href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() === 'en' ? 'ar' : 'en') }}">
            {{ app()->getLocale() === 'en' ? 'AR' : 'EN' }}
        </a>
    </div>--}}
</div>
