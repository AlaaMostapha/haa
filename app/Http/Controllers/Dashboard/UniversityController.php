<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use Illuminate\Validation\Rule;
use App\AppConstants;
use App\Models\University;

class UniversityController extends DashboardBaseController
{

    public $className = University::class;
    /* @var $tableName string */
    public $tableName = 'universities';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation()
    {
        return [
            'name' => ['filterType' => 'text', 'sortable' => true],
            'count_user' =>[]
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
    public function getFormComponents($modelObject)
    {
        return [
            'email' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormRules($modelObject)
    {
        return [
            'email' => ['required', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH, Rule::unique($this->tableName)->ignore($modelObject->id)],
        ];
    }















}
