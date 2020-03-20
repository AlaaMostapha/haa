<style>
    #side-menu>li>a:hover{
        background-color: #23c6c8 !important;
        color: white;
    }

    #side-menu>li.active{
        border-left: 4px solid #2f4050;
        color: darkgray;
        background-color: #18a689 !important;
    }
</style>

<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <span>
                        <img src="{{ asset('/frontend/images/logo.png') }}" width="100%" />
                    </span>
                </div>
            </li>
            <li @if(request()->getRequestUri() == route('dashboard.home', [], false) ) class="active"@endif>
                <a href="{{ route('dashboard.home') }}"><i class="fa fa-home"></i> <span>{{ __('Home') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.user.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.user.index') }}"><i class="fa fa-user"></i> <span>{{ __('user.Users') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.company.index', [], false)) !== false && strpos(request()->getRequestUri(), route('dashboard.companytask.index', [], false)) === false) class="active"@endif>
                <a href="{{ route('dashboard.company.index') }}"><i class="fa fa-building"></i> <span>{{ __('company.companies') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.companytask.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.companytask.index') }}"><i class="fa fa-paper-plane"></i> <span>{{ __('companytask.Tasks') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.major.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.major.index') }}"><i class="fa fa-tasks"></i> <span>{{ __('major.majors') }}</span></a>
            </li>
            <li @if(request()->getRequestUri() === route('dashboard.university.index', [], false)) class="active"@endif>
                <a href="{{ route('dashboard.university.index') }}"><i class="fa fa-university"></i> <span>{{ __('university.universities') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.subscriber.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.subscriber.index') }}"><i class="fa fa-university"></i> <span>{{ __('Subscriber.subscribers') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.contactus.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.contactus.index') }}"><i class="fa fa-university"></i> <span>{{ __('contactus.contactus') }}</span></a>
            </li>
            <li @if(strpos(request()->getRequestUri(), route('dashboard.universityEmail.index', [], false)) !== false) class="active"@endif>
                <a href="{{ route('dashboard.universityEmail.index') }}"><i class="fa fa-university"></i> <span>{{ __('universityEmail.UniversityEmail') }}</span></a>
            </li>

        </ul>
    </div>
</nav>
