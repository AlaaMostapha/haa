<div class="logged">
    <div class="notifications-menu">
        <ul>
            <li class="menu-item-has-children">
                <a href="javascript:void(0)">
                    <img src="{{ asset('/frontend/images/bell.png') }}" alt="">
                    @if (auth('company')->user()->getUnreadNotificationsCount() > 0)
                    <span class="badgo">{{ auth('company')->user()->getUnreadNotificationsCount() }}</span>
                    @endif
                </a>
                <ul class="sub-menu">
                    <li>
                        <div class="menu-inner">
                            <div class="i-top">
                                <img src="{{ asset('/frontend/images/bell.png') }}" alt="">
                                <h3>{{ __('notification.Notifications') }}</h3>
                                <ul>
                                    <li class="menu-item-has-children">
                                        <a href="javascript:void(0)">
                                            <i class="fa fa-ellipsis-v"></i>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <form id="mark-all-notification-read" action="{{ route('company.notifications.mark-all-as-read') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('mark-all-notification-read').submit();">{{ __('notification.Mark all as read') }}</a>
                                            </li>
                                            <li>
                                                <form id="clear-all-notifications" action="{{ route('company.notifications.delete-all') }}" method="POST" style="display: none;">
                                                    @csrf
                                                </form>
                                                <a href="#" onclick="event.preventDefault(); document.getElementById('clear-all-notifications').submit();">{{ __('notification.Clear all') }}</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                            <div class="i-mid">
                                <ul>
                                    @foreach(auth('company')->user()->getLastFiveNotifications() as $notification)
                                    <li @if(!$notification->read_at) class="new"@endif>
                                         <form id="mark-notification-read-{{ $notification->id }}" action="{{ route('company.notifications.mark-as-read', ['id' => $notification->id]) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('mark-notification-read-{{ $notification->id }}').submit();">
                                            @if(isset($notification->data['image']))
                                            <img src="{{ asset($notification->data['image']) }}" alt="{{ $notification->data['title'] }}">
                                            @endif
                                            <div class="data">
                                                <p>{{ $notification->data['title'] }}</p>
                                            </div>
                                        </a>
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="i-bottom">
                                <a href="{{ route('company.notifications.index') }}">{{ __('notification.More') }}</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="user-img">
        @if(auth('company')->user()->company_logo)
        <a href="{{ route('company.profile.edit') }}">
            <img src="{{ auth('company')->user()->company_logo }}" alt="{{ auth('company')->user()->name }}" />
        </a>
        @endif
    </div>
</div>

<form id="logout-form" action="{{ route('company.logout') }}" method="POST" style="display: none;">
    @csrf
</form>