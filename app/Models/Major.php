<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function getCountUserAttribute()
    {
        return $this->users()->count();

    }
    public function company_tasks()
    {
        return $this->belongsToMany(CompanyTask::class);
    }
}
