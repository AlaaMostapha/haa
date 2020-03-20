                <ul>
                    <li>
                        <a href="{{ route('home') }}">{{ __('Home page') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('contactus') }}">{{ __('Contact us') }}</a>
                    </li>
                    @if(auth()->user())
                    <li @if(Route::current()->getName() === 'user.tasks.index') class="current-menu-item"@endif>
                        <a href="{{ route('user.tasks.index') }}">{{ __('companytask.Taskss') }}</a>
                    </li>
                    @else
                    <li @if(Route::current()->getName() === 'user.all.tasks') class="current-menu-item"@endif>
                            <a href="{{ route('user.all.tasks') }}">{{ __('companytask.Taskss') }}</a>
                    </li>
                    @endif
                    {{--<li>
                        <a href="{{ route('why-haa') }}">{{ __('site.Why') }} {{ __(config('app.name')) }}</a>
                    </li>
                    <li>
                        <a href="{{ route('terms-and-conditions') }}">{{ __('Terms and Conditions') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a>
                    </li> --}}
                    <li>
                        <a href="{{ route('about') }}">{{ __('About') }} {{ __(config('app.name')) }}</a>
                    </li>
                    <li  class="visitor">
                    <a href="{{ route('join-haa-login') }}" class="btn login">{{ __('Login') }}</a>
                    </li>
                    <li class="visitor">
                    <a href="{{ route('join-haa') }}" class="btn color-white">{{ __('site.Join') }} {{ __(config('app.name')) }}</a>
                    </li>
                </ul>
