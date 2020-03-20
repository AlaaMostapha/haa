<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\UniversityEmail;
use App\AppConstants;
use Illuminate\Contracts\Validation\Rule;
use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Rules\CheckUniversityEmailDomain;

class UniversityEmailController extends DashboardBaseController
{
    
    public $className = UniversityEmail::class;
    /* @var $tableName string */
    public $tableName = 'university_emails';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation()
    {
        return [
            'email' => ['filterType' => 'text', 'sortable' => true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListActions()
    {
        return [
            ['type' => 'create'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListRowActions()
    {
        return [
            ['type' => 'edit'],
            ['type' => 'show'],
            ['type' => 'delete' , 'route'=>'dashboard.universityEmail.destroy'],


        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormComponents($modelObject)
    {
        return [
            'email' => ['type'=>'text','help' => __('please_enter_domain') ,'attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH ]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormRules($modelObject)
    {
        return [
            'email' => ['required', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH,
                        'min:' . AppConstants::STRINGS_MINIMUM_LENGTH,
                        'unique:university_emails,email,'.$modelObject->id,
                        new CheckUniversityEmailDomain],
        ];
    }













}
