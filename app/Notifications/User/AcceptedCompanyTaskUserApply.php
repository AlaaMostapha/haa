<?php

namespace App\Notifications\User;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class AcceptedCompanyTaskUserApply extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var string $companyName */
    protected $companyName;
    /** @var string $companyTaskViewUrl */
    protected $companyTaskViewUrl;
    /** @var string $companyTaskTitle */
    protected $companyTaskTitle;
    /** @var string|null $companyLogo */
    protected $companyLogo;

    /**
     * Create a new notification instance.
     *
     * @param string $companyName
     * @param string $companyTaskViewUrl
     * @param string $companyTaskTitle
     * @param string|null $companyLogo
     * @return void
     */
    public function __construct($companyName, $companyTaskViewUrl, $companyTaskTitle, $companyLogo = null)
    {
        $this->companyName = $companyName;
        $this->companyTaskViewUrl = $companyTaskViewUrl;
        $this->companyTaskTitle = $companyTaskTitle;
        $this->companyLogo = $companyLogo;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->companyName . ' ' . __('notifications.accepted your apply on the task') . ' ' . $this->companyTaskTitle,
            'url' => $this->companyTaskViewUrl,
            'image' => $this->companyLogo,
        ];
    }
}
