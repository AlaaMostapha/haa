<?php

namespace App\Notifications;

trait HasDatabaseNotifications
{
    /**
     * The unread notifications count
     *
     * @var integer|null
     */
    private $unreadNotificationsCount = null;

    /**
     * The unread notifications count
     *
     * @return integer
     */
    public function getUnreadNotificationsCount()
    {
        if ($this->unreadNotificationsCount === null) {
            $this->unreadNotificationsCount = $this->unreadNotifications()->count();
        }
        return $this->unreadNotificationsCount;
    }

    public function getLastFiveNotifications()
    {
        return $this->notifications()->limit(5)->get();
    }

}
