<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Models\Contactus;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;

class ContactUsController extends DashboardBaseController {

    public $className = Contactus::class;
    public $tableName = 'contact_us';
    public $translationPrefix = 'contactus.';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation() {
        return [

            'email' => ['filterType' => 'text', 'sortable' => true],
            'message' => [],
            'phone'=>[],
            'created_at' =>[]

        ];
    }

        /**
     * {@inheritdoc}
     */
    // public function getListRowActions()
    // {
    //     // return [
    //     //     ['type' => 'show'],
    //     // ];
    // }

}
