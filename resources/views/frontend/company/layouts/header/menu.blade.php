<ul>
    <li @if(Route::current()->getName() === 'home') class="current-menu-item"@endif>
         <a href="{{ route('home') }}">{{ __('Home page') }}</a>
    </li>
    <li @if(Route::current()->getName() === '') class="current-menu-item"@endif>
         <a href="{{ route('contactus') }}">{{ __('Contact us') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'company.tasks.create') class="current-menu-item"@endif>
         <a href="{{ route('company.tasks.create') }}">{{ __('Create') }} {{ __('companytask.Task') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'company.tasks.index') class="current-menu-item"@endif>
         <a href="{{ route('company.tasks.index') }}">{{ __('companytask.Tasks') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'company.profile.show') class="current-menu-item"@endif>
         <a href="{{ route('company.profile.show') }}">{{ __('My profile') }}</a>
    </li>
    <li>
        <a href="#" class="dev-logout"><i class="fa fa-sign-out"></i> {{ __('Logout') }}</a>
    </li>
</ul>