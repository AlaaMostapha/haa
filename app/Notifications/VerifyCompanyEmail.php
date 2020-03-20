<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;


class VerifyCompanyEmail extends Notification
{
    use Queueable;

    public static $toMailCallback;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $verificationUrl = $this->verificationUrl($notifiable);

        if (static::$toMailCallback) {
            return call_user_func(static::$toMailCallback, $notifiable);
        }
        // dd(
        //     (new MailMessage)
        //     ->subject(Lang::getFromJson('Verify Email Address'))
        //     ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
        //     ->action(Lang::getFromJson('Verify Email Address'),$notifiable)
        //     ->line(Lang::getFromJson('If you did not create an account, no further action is required.'))
        // );
        return 
                    (new MailMessage)
                    ->subject(Lang::getFromJson('Verify Email Address'))
                    ->line(Lang::getFromJson('Please click the button below to verify your email address.'))
                    ->action(Lang::getFromJson('Verify Email Address'), $verificationUrl)
                    ->line(Lang::getFromJson('If you did not create an account, no further action is required.'));            
    }




    /**
     * Get the verification URL for the given notifiable.
     *
     * @param  mixed  $notifiable
     * @return string
     */
    protected function verificationUrl($notifiable)
    {
        return URL::temporarySignedRoute(
            'company.verification.verify', Carbon::now()->addMinutes(60), ['id' => $notifiable->getKey()]
        );
    }

    /**
     * Set a callback that should be used when building the notification mail message.
     *
     * @param  \Closure  $callback
     * @return void
     */
    public static function toMailUsing($callback)
    {
        static::$toMailCallback = $callback;
    }















}
