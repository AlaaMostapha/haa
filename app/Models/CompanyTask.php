<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTask extends Model {

    const STATUS_NEW = 'new';
    const STATUS_LIVE = 'live';
    const STATUS_FINISHED = 'finished';
    const CITY_EXIST_IMPORTANCE = [
        'important',
        'not_important'
    ];

    const PRICE_PAYMENT_TYPE = [
        'pay_once',
        'pay_daily',
        'pay_weekly',
        'pay_monthly',
    ];

      const TYPE = [
        'part_time',
        'part_time_remotely',
        'freelance',
    ];

    const LANGUAGE = [
        'english',
        'arabic',
        'other',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'status', 'title', 'startDate', 'endDate', 'price',
        'major', 'requiredNumberOfUsers', 'appliedUsersCount',
        'hiredUsersCount', 'briefDescription', 'fullDescription',
        'suspendedByAdmin',
        'workHoursFrom','workHoursTo',
        'type', 'workHoursCount', 'workDaysCount', 'location', 'city_id', 'cityExistImportance', 'pricePaymentType', 'language', 'willTakeCertificate',
        'company_task_id'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
        'suspendedByAdmin' => 'boolean',
    ];

    /**
     * Get the company that owns the task.
     */
    public function company() {
        return $this->belongsTo(Company::class);
    }

    // public function major()
    // {
    //     return $this->belongsTo(Major::class);
    // }

    public function majors()
    {
        return $this->belongsToMany(Major::class,'company_task_major' , 'company_task_id' ,'major_id');
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }


}
