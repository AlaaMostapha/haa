<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Services\CompanyTaskService;
use App\Models\CompanyTask;
use App\Models\CompanyTaskUserApply;

class CompanyTaskController extends DashboardBaseController
{

    /* @var $translationPrefix string */
    public $translationPrefix = 'companytask.';
    public $className = CompanyTask::class;
    /* @var $tableName string */
    public $tableName = 'company_tasks';

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation()
    {
        return [
            'title' => ['filterType' => 'text', 'sortable' => true],
            'status' =>[
                        'type'=> 'translated',
                        'filterType'=>'select', 
                        'options' => CompanyTaskService::status(),
                        'sortable' => true
            ],
            'startDate' => ['type' => 'date'],
            'endDate' => ['type' => 'date'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getListRowActions()
    {
        return [
            ['type' => 'show'],
            ['type' => 'activate', 'route' => 'dashboard.companytask.activate', 'displayParameter' => 'suspendedByAdmin'],
            ['type' => 'deactivate', 'route' => 'dashboard.companytask.deactivate', 'displayParameter' => 'suspendedByAdmin'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormComponents($modelObject)
    {
        return CompanyTaskService::getFormComponents();
    }
    public function show($id)
    {
        $modelObject = call_user_func($this->className.'::findOrFail', $id);
        $majors = optional($modelObject->majors)->map(function($major){
            return $major->name;        
        })->toArray();        
        $modelObject->{"majors"} = $majors;
        // dd($modelObject);
        $usersTask = CompanyTaskUserApply::where('company_task_id' , $modelObject->id)->with('user')->paginate(10);    
        $pageData = [
            'title' => $this->unitName.' | '.__('Show'),
            'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix.'index')], ['label' => __('Show')]],
            'translationPrefix' => $this->translationPrefix,
        ];

        return view('dashboard.task.details', ['pageData' => $pageData, 'displayData' => $this->getShowDisplayedDataInformation(), 'data' => $modelObject , 'usersTask' =>$usersTask ,'majors'=>$majors]);
    }

}
