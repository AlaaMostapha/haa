<?php

namespace App\Http\Controllers\Frontend\Common;

use App\Http\Controllers\Controller;
use App\AppConstants;

class NotificationController extends Controller
{
    protected $usedFor = 'user';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $notifications = auth()->user()->notifications()->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);
        return view('frontend.common.notification.index', [
            'notifications' => $notifications,
            'usedFor' => $this->usedFor
        ]);
    }

    /**
     * Delete all notification.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteAll()
    {
        auth()->user()->notifications()->delete();
        return redirect(route($this->usedFor . '.notifications.index'));
    }

    /**
     * Mark all notification as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications()->update(['read_at' => now()]);
        return redirect(route($this->usedFor . '.notifications.index'));
    }

    /**
     * Mark notification as read.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function markAsRead($id)
    {
        $notification = auth()->user()->notifications()->where('id' ,$id)->first();
        if ($notification) {
            $notification->markAsRead();
            if (isset($notification->data['url'])) {
                return redirect($notification->data['url']);
            }
        }
        return redirect(route($this->usedFor . '.notifications.index'));
    }

    /**
     * Delete notification.
     *
     * @param  string  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $notification = auth()->user()->notifications()->where('id' ,$id)->first();
        if ($notification) {
            $notification->delete();
        }
        return redirect(route($this->usedFor . '.notifications.index'));
    }
}
