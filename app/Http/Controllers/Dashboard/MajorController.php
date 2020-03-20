<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use Illuminate\Validation\Rule;
use App\AppConstants;
use App\Models\Major;

class MajorController extends DashboardBaseController
{

    public $className = Major::class;

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
    public function getListRowActions()
    {
        return [
            ['type' => 'edit'],
            ['type' => 'show'],
            ['type' => 'delete' , 'route'=>'dashboard.major.destroy'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormComponents($modelObject)
    {
        return [
            'name' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormRules($modelObject)
    {
        return [
            'name' => ['required', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH, Rule::unique($this->tableName)->ignore($modelObject->id)],
        ];
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);
        $majorUsers  =  $modelObject->users()->paginate(10);
        $pageData = [
            'title' => $this->unitName . ' | ' . __('Show'),
            'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix . 'index')], ['label' => __('Show')]],
            'translationPrefix' => $this->translationPrefix,
        ];

        // return view('dashboard.layout.details', ['pageData' => $pageData, 'displayData' => $this->getShowDisplayedDataInformation(), 'data' => $modelObject]);
        return view('dashboard.major.details', ['pageData' => $pageData, 'displayData' => $this->getShowDisplayedDataInformation(), 'data' => $modelObject , 'majorUsers' => $majorUsers]);

    }

        /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);
        if(count($modelObject->users)){
            session()->flash('errorMessage', __('Error deleted'));
            return;
        }
        $modelObject->delete();
        session()->flash('successMessage', __('Successfully deleted'));
    }

}
