<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\HasDatabaseNotifications;
use App\Notifications\Common\ResetPassword;
use App\Notifications\VerifyCompanyEmail;
use Illuminate\Support\Facades\Storage;

class Company extends Authenticatable implements MustVerifyEmail {

    use Notifiable,
        HasDatabaseNotifications;

    const UPLOAD_PATH = 'company-logo';
    const UPLOAD_PATH_EMAIL = 'company-file-upload-dashboard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'mobile', 'bankAccountNumber',
        'commercialRegistrationNumber', 'commercialRegistrationExpiryDate',
        'howDidYouFindUs', 'logo', 'suspendedByAdmin',
        'summary', 'howDidYouFindUsOther'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'commercialRegistrationExpiryDate' => 'datetime',
        'suspendedByAdmin' => 'boolean',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token, $this->name, 'company'));
    }

    public function getCompanyLogoAttribute() {
        return ($this->logo != null) ? asset(Storage::disk('public')->url($this->logo)) : asset('/frontend/images/avatar.png');
    }
    // public function routeNotificationForMail($notification) {
    //     return $this->email;
    // }


        /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyCompanyEmail);
    }

}
