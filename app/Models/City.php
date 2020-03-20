<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model {

//    use SoftDeletes;
//
//    protected $dates = ['deleted_at'];

//    const UPLOAD_PATH = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var
     */
    protected $hidden = [];

}
