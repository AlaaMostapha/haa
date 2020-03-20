

<div class="row border-bottom">
    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
        <div class="navbar-header">
            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
        </div>
        <ul class="nav navbar-top-links navbar-right">
            {{--<li>
                <a class="dropdown-item btn" href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale() === 'en' ? 'ar' : 'en') }}">
                    <img width="32" height="32" src="{{ asset('dashboard/img/flags/' . (app()->getLocale() === 'en' ? '32/Saudi-Arabia' : '16/United-States') . '.png') }}">
                    {{ app()->getLocale() === 'en' ? 'AR' : 'EN' }}
                </a>
            </li>--}}
            <li>
                <a href="{{ route('dashboard.profile.edit') }}">  <i class="fa fa-user"></i> {{ auth()->user()->name }}</a>
            </li>
            <li>
                <a class="dropdown-item" href="{{ route('dashboard.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> {{ __('Logout') }}
                </a>
            </li>
        </ul>
    </nav>
</div>
