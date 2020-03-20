<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Services\UserService;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMailUsers;


class SubscriberController extends DashboardBaseController {

    public $className = Subscriber::class;
    public $tableName = 'subscribers';
    public $translationPrefix = 'Subscriber.';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation() {
        return [

            'email' => ['filterType' => 'text', 'sortable' => true],
            'created_at' => ['filterType' => 'daterange', 'type' => 'date', 'sortable' => true],

        ];
        
    }


    public function getListMultipleRowsActions()
    {
       return  [[
            'type' => 'send_email_user',
            'route' => 'dashboard.subscriber.send-multi-user-email',
       ]];
    }



    public function sendMultiEmail() {
        $rules = [
            'ids' => 'required|max:170',
            'subject' => 'required|max:170',
            'description' => 'required|max:1000',
            // 'file' => 'nullable|file|mimes:pdf,ppt,docx,png,jpeg,gif,jpg|max:2048',
        ];
        $data = (object) \request()->only(array_keys($rules));
        $validator = validator()->make(((array) $data), $rules);
        if ($validator->fails()) {
            session()->flash('update', true);
            return;
        }
        if (isset($data->file)) {
            $data->file = Upload::file($data->file, User::UPLOAD_PATH_EMAIL);
        }
        collect(explode(',', $data->ids))->each(
            function ($id) use ($data) {
            $obj = Subscriber::find($id);
            $email = $obj->email;
            Mail::to($email)->send(new SendMailUsers($data));
        });


        session()->flash('successMessage', __('Done successfully'));
        return \redirect(route('dashboard.user.index'));
    }

}
