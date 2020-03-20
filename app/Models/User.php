<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\HasDatabaseNotifications;
use App\Notifications\Common\ResetPassword;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable implements MustVerifyEmail {

    use Notifiable,
        HasDatabaseNotifications;

     const REVIEWS_COUNT_DEFAULT = 5;
    // const ACTIVE_TRUE = 1;
    // const ACTIVE_FALSE = 0;
    const UPLOAD_PATH =  'user-profile-picture';
    const UPLOAD_PATH_EMAIL = 'user-file-upload-dashboard';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'firstName', 'lastName', 'username', 'mobile',
        'bankAccountNumber', 'major_id', 'yearOfStudy', 'gpaType', 'gpa',
        'certificates', 'experiences', 'howDidYouFindUs',
        'personalPhoto', 'summary', 'suspendedByAdmin', 'skills',
        'city_id', 'university_email', 'howDidYouFindUsOther', 'university_id',
        'is_active', 'reviews_count', 'avg_rate',
        'academicYear'
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
        'suspendedByAdmin' => 'boolean',
    ];

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token, $this->firstName . ' ' . $this->lastName));
    }

    /**
     * Get the user projects.
     */
    public function projects() {
        return $this->hasMany(UserProject::class);
    }

    /**
     * Route notifications for the mail channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForMail($notification) {
        return $this->university_email;
    }

    public function getUserPersonalPhotoAttribute() {
        return ($this->personalPhoto != null) ? asset(Storage::disk('public')->url($this->personalPhoto)) : asset('/frontend/images/avatar.png');
    }

     public function getIsVerifiedAttribute() {
        return ($this->email_verified_at !== null) ? __("Yes") : __("No");
    }

    public function major() {
        return $this->belongsTo(Major::class);
    }
    public function city() {
        return $this->belongsTo(City::class);
    }
    public function university() {
        return $this->belongsTo(University::class);
    }

    public function certificates()
    {
        return $this->hasMany(UserCertificate::class);
    }

    public function languages()
    {
        return $this->hasMany(UserLanguage::class);
    }

    public function experiences()
    {
        return $this->hasMany(UserExperience::class);
    }
}
