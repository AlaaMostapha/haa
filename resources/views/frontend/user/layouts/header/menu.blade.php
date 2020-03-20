<ul>
    <li  @if(Route::current()->getName() == 'home') class="current-menu-item"@endif>
          <a href="{{ route('home') }}">{{ __('Home page') }}</a>
    </li>
    <li @if(Route::current()->getName() === '') class="current-menu-item"@endif>
         <a href="{{ route('contactus') }}">{{ __('Contact us') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'user.tasks.index') class="current-menu-item"@endif>
         <a href="{{ route('user.tasks.index') }}">{{ __('companytask.Tasks') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'user.tasks.myTasks') class="current-menu-item"@endif>
         <a href="{{ route('user.tasks.myTasks') }}">{{ __('companytask.My tasks') }}</a>
    </li>
    <li @if(Route::current()->getName() === 'user.profile.show') class="current-menu-item"@endif>
         <a href="{{ route('user.profile.show') }}">{{ __('My profile') }}</a>
    </li>
    <li>
        <a href="#" class="dev-logout"><i class="fa fa-sign-out"></i> {{ __('Logout') }}</a>
    </li>
</ul>

