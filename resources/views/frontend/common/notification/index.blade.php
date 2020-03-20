@extends('frontend.' . $usedFor . '.layouts.app')

@section('subtitle'){{ __('notification.Notifications') }}@endsection

@section('content')
<div class="sign-area col-xs-12">
    <div class="container">
        @if($notifications->count() > 0)
        <div class="sign-inner notif-wrap col-xs-12">
            <div class="notifications-menu col-xs-12">
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
                                        <form id="mark-all-notification-read" action="{{ route($usedFor . '.notifications.mark-all-as-read') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('mark-all-notification-read').submit();">{{ __('notification.Mark all as read') }}</a>
                                    </li>
                                    <li>
                                        <form id="clear-all-notifications" action="{{ route($usedFor . '.notifications.delete-all') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <a href="#" onclick="event.preventDefault();document.getElementById('clear-all-notifications').submit();">{{ __('notification.Clear all') }}</a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="i-mid">
                        <ul>
                            @foreach($notifications as $notification)
                            <li @if(!$notification->read_at) class="new"@endif>
                                <form id="mark-notification-read-{{ $notification->id }}" action="{{ route($usedFor . '.notifications.mark-as-read', ['id' => $notification->id]) }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                <form id="notification-delete-{{ $notification->id }}" action="{{ route($usedFor . '.notifications.destroy', ['id' => $notification->id]) }}" method="POST" style="display: none;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    @csrf
                                </form>
                                <!-- @if(isset($notification->data['image']))
                                <img src="{{ asset($notification->data['image']) }}" alt="{{ $notification->data['title'] }}">
                                @endif -->
                                <div class="data">
                                    <p>{{ $notification->data['title'] }}</p>
                                    <div class="new-controls">
                                        @if(isset($notification->data['url']))
                                        <a href="#" onclick="event.preventDefault();document.getElementById('mark-notification-read-{{ $notification->id }}').submit();">{{ __('Show') }}</a>
                                        @endif
                                        <a href="#" onclick="event.preventDefault();document.getElementById('notification-delete-{{ $notification->id }}').submit();">{{ __('Delete') }}</a>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="text-center">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
        @else
        <div class="col-xs-12 form-group">
            <div class="alert alert-success" role="alert">
                {{ __('notification.No notifications found') }}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
