<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Mail\SendMailCompanies;
use App\Services\CompanyService;
use App\Models\Company;
use Illuminate\Support\Facades\Mail;

class CompanyController extends DashboardBaseController {

    public $className = Company::class;
    /* @var $tableName string */
    public $tableName = 'companies';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation() {
        return [
            'logo' => ['type' => 'image', 'height' => 50, 'width' => 50],
            'name' => [],
            'email' => ['filterType' => 'text', 'sortable' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListActions() {
        return [
            ['type' => 'create'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListRowActions() {
        return [
            ['type' => 'edit'],
            ['type' => 'show'],
            ['type' => 'activate', 'route' => 'dashboard.company.activate', 'displayParameter' => 'suspendedByAdmin'],
            ['type' => 'deactivate', 'route' => 'dashboard.company.deactivate', 'displayParameter' => 'suspendedByAdmin'],
        ];
    }

    /**
     * {@inheritdoc}
     */
//    public function getFormComponents($modelObject) {
//        return CompanyService::getDashboardFormComponents($modelObject);
//    }

    /**
     * {@inheritdoc}
     */
    public function getFormRules($modelObject) {
        return CompanyService::getDashboardFormValidationRules($modelObject);
    }

    /**
     * {@inheritdoc}
     */
    public function getShowDisplayedDataInformation() {
        $data = $this->getPreparedFormComponents(new $this->className());
        unset($data['password']);
        unset($data['password_confirmation']);
        return $data;
    }

    public function getFormComponents($modelObject) {
        if (strpos(request()->route()->getName(), 'show') !== false) {
            return array_merge(CompanyService::getDashboardFormComponents($modelObject), CompanyService::getDashboardDetailComponentsPlus($modelObject));
        } else {
            return CompanyService::getDashboardFormComponents($modelObject);
        }
    }



    public function getListMultipleRowsActions()
    {
        return  [[
                'type' => 'send_email_company',
                'route' => 'dashboard.company.send-multi-company-email',
        ]];
    }




    public function sendMultiEmail() {

        $rules = [
            'ids' => 'required|max:170',
            'subject' => 'required|max:170',
            'description' => 'required|max:1000',
        ];
        $data = (object) \request()->only(array_keys($rules));
        $validator = validator()->make(((array) $data), $rules);
        if ($validator->fails()) {
            session()->flash('update', true);
            return;
        }
        // if (isset($data->file)) {
        //     $data->file = Upload::file($data->file, Company::UPLOAD_PATH_EMAIL);
        // }
        collect(explode(',', $data->ids))->each(
            function ($id) use ($data) {
            $obj = Company::find($id);
            $email = $obj->email;
            Mail::to($email)->send(new SendMailCompanies($data));
        });


        session()->flash('successMessage', __('Done successfully'));
        return \redirect(route('dashboard.company.index'));
    }

}
