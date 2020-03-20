<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyTaskUserApply extends Model
{
    const STATUS_APPLIED = 'applied';
    const STATUS_ASSIGNED = 'assigned';
    const STATUS_REJECTED = 'rejected';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_id', 'user_id', 'company_task_id', 'status', 'rate', 'review'
    ];

    /**
     * Get the company task that the user applied on.
     */
    public function companyTask()
    {
        return $this->belongsTo(CompanyTask::class);
    }

    /**
     * Get the company that owns the task.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Get the user who applied on the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
