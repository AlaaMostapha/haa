<?php

namespace App\Notifications\Company;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserAppliedOnCompanyTask extends Notification implements ShouldQueue
{
    use Queueable;

    /** @var string $appliedUserName */
    protected $appliedUserName;
    /** @var string $companyTaskViewUrl */
    protected $companyTaskViewUrl;
    /** @var string $companyTaskTitle */
    protected $companyTaskTitle;
    /** @var string|null $appliedUserImage */
    protected $appliedUserImage;

    /**
     * Create a new notification instance.
     *
     * @param string $appliedUserName
     * @param string $companyTaskViewUrl
     * @param string $companyTaskTitle
     * @param string|null $appliedUserImage
     * @return void
     */
    public function __construct($appliedUserName, $companyTaskViewUrl, $companyTaskTitle, $appliedUserImage = null)
    {
        $this->appliedUserName = $appliedUserName;
        $this->companyTaskViewUrl = $companyTaskViewUrl;
        $this->companyTaskTitle = $companyTaskTitle;
        $this->appliedUserImage = $appliedUserImage;
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
            'title' => $this->appliedUserName . ' ' . __('notifications.applied on the task') . ' ' . $this->companyTaskTitle,
            'url' => $this->companyTaskViewUrl,
            'image' => $this->appliedUserImage,
        ];
    }

}
