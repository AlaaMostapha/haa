<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;

class DashboardBaseController extends Controller {
    /* @var $translationPrefix string */

    public $translationPrefix = '';
    /* @var $className string */
    public $className = '';
    /* @var $unitName string */
    public $unitName = '';
    /* @var $tableName string */
    public $tableName = '';

    public function __construct() {
        if (!$this->unitName) {
            $this->unitName = last(explode('\\', $this->className));
        }
        if (!$this->tableName) {
            $this->tableName = lcfirst($this->unitName) . 's';
        }
        if (!$this->translationPrefix) {
            $this->translationPrefix = lcfirst($this->unitName) . '.';
        }
        $this->unitName = __($this->translationPrefix . $this->unitName);
    }

    /**
     * Get the form inputs data.
     *
     * @return array
     */
    public function getFormComponents($modelObject) {
        return [];
    }

    /**
     * Get the prepared form inputs data.
     *
     * @return array
     */
    public function getPreparedFormComponents($modelObject) {
        $formComponents = $this->getFormComponents($modelObject);
        foreach ($formComponents as $formComponentName => &$formComponent) {
            if (!isset($formComponent['type'])) {
                $formComponent['type'] = 'text';
            }
            if (!isset($formComponent['accessor'])) {
                $formComponent['accessor'] = $formComponentName;
                if (preg_match('/\[/', $formComponentName) === 1) {
                    $formComponent['accessor'] = str_replace(']', '', $formComponent['accessor']);
                    $formComponent['accessor'] = str_replace('[', '.', $formComponent['accessor']);
                }
            }
        }

        return $formComponents;
    }

    /**
     * Get the form inputs data.
     *
     * @param object $modelObject
     *
     * @return array
     */
    public function getFormRules($modelObject) {
        return [];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $modelObject = new $this->className();
        $formComponents = $this->getPreparedFormComponents($modelObject);
        $formComponentsTypes = array_pluck($formComponents, 'type');
        if (!session('update')) {
            $formInputsData = [];
            foreach ($formComponents as $formComponentName => $formComponent) {
                $formInputsData[$formComponent['accessor']] = data_get($modelObject, $formComponent['accessor']);
            }
            session()->flashInput($formInputsData);
        }

        return view(
                'dashboard.layout.form', [
            'pageData' => [
                'title' => $this->unitName . ' | ' . __('Create'),
                'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix . 'index')], ['label' => __('Create')]],
                'translationPrefix' => $this->translationPrefix,
            ],
            'formData' => [
                'containsFiles' => in_array('file', $formComponentsTypes) || in_array('image', $formComponentsTypes),
                'action' => route('dashboard.' . $this->translationPrefix . 'store'),
            ],
            'formComponents' => $formComponents,
                ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {
        return $this->validateAndSaveModelThenReturnResponse(
                        new $this->className(), 'dashboard.' . $this->translationPrefix . 'create', [], 'dashboard.' . $this->translationPrefix . 'index'
        );
    }

    /**
     * @param object $modelObject
     * @param string $formRoute
     * @param array  $formRouteParameters
     * @param string $listRoute
     *
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function validateAndSaveModelThenReturnResponse($modelObject, $formRoute, $formRouteParameters, $listRoute) {


        $rules = $this->getFormRules($modelObject);
        $inputsNames = [];
        foreach (array_keys($rules) as $inputName) {
            if (preg_match('/\*/', $inputName) === 1) {
                $inputName = str_replace('.', '', explode('*', $inputName)[0]);
            }
            $inputsNames[$inputName] = $inputName;
        }
        $data = request($inputsNames);
        foreach ($rules as $inputName => $inputRules) {
            if (is_string($inputRules) && preg_match('/phone/', $inputRules) === 1) {
                try {
                    $data[$inputName] = PhoneNumber::make($data[$inputName])->formatInternational();
                    $data[$inputName] = PhoneNumber::make($data[$inputName])->formatE164();
                } catch (\Exception $e) {

                }
            }
        }
        $validator = validator()->make($data, $rules);
        if ($validator->fails()) {


            session()->flash('update', true);

            return redirect()->route($formRoute, $formRouteParameters)->withErrors($validator)->withInput();
        } else {
            foreach ($rules as $inputName => $inputRules) {

                if (is_array($inputRules) && count($inputRules) !== 0) {
                    foreach ($inputRules as $inputRule) {
                        if (in_array($inputRule, ['date', 'image', 'file'])) {
                            if (is_string($inputRule) && (preg_match('/image/', $inputRule) === 1 || preg_match('/file/', $inputRule) === 1)) {
                                if (isset($data[$inputName])) {
                                    $data[$inputName] = $data[$inputName]->store('uploads/' . $modelObject::UPLOAD_PATH, 'public');
                                    $oldPath = $modelObject[$inputName];
                                    if ($oldPath) {
                                        if (Storage::disk('public')->exists($oldPath)) {
                                            Storage::disk('public')->delete($oldPath);
                                        }
                                    }
                                }
                            }

                            if (is_string($inputRule) && preg_match('/date/', $inputRule) === 1) {
                                $data[$inputName] = new \Carbon\Carbon($data[$inputName]);
                            }
                        }
                    }
                }

                if (in_array($inputName, ['password', 'password_confirmation'])) {
                    if ($data[$inputName]) {
                        $data[$inputName] = Hash::make($data[$inputName]);
                    } else {
                        unset($data[$inputName]);
                    }
                }
                
            }

            $modelObject->fill($data)->save();
            session()->flash('successMessage', __('Done successfully'));

            return redirect()->route($listRoute);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);

        $formComponents = $this->getPreparedFormComponents($modelObject);
        $formComponentsTypes = array_pluck($formComponents, 'type');

        if (!session('update')) {
            $formInputsData = [];
            foreach ($formComponents as $formComponentName => $formComponent) {
                if ($formComponentName !== 'password') {
                    $formInputsData[$formComponent['accessor']] = data_get($modelObject, $formComponent['accessor']);
                }
            }
            session()->flashInput($formInputsData);
        } else {
            $formInputsData = [];
            foreach ($formComponents as $formComponentName => $formComponent) {
                $formInputsData[$formComponent['accessor']] = old($formComponent['accessor']) ? old($formComponent['accessor']) : data_get($modelObject, $formComponent['accessor']);
            }
            session()->flashInput($formInputsData);
        }

        $pageData = [
            'title' => $this->unitName . ' | ' . __('Edit'),
            'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix . 'index')], ['label' => __('Edit')]],
            'translationPrefix' => $this->translationPrefix,
        ];

        $formData = [
            'action' => route('dashboard.' . $this->translationPrefix . 'update', ['id' => $id]),
            'containsFiles' => in_array('file', $formComponentsTypes) || in_array('image', $formComponentsTypes),
            'method' => 'PUT',
        ];

        return view('dashboard.layout.form', ['pageData' => $pageData, 'formData' => $formData, 'formComponents' => $formComponents]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);

        return $this->validateAndSaveModelThenReturnResponse(
                        $modelObject, 'dashboard.' . $this->translationPrefix . 'edit', ['id' => $id], 'dashboard.' . $this->translationPrefix . 'index'
        );
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
        $modelObject->delete();
        session()->flash('successMessage', __('Successfully deleted'));
    }

    public function getListQuery() {
        $loopIndex = 0;
        $query = call_user_func($this->className . '::query')->select($this->tableName . '.*');
        foreach ($this->getListDisplayedDataInformation() as $displayDataName => $displayedrowInfromation) {
            if (isset($displayedrowInfromation['type']) && 'reference' === $displayedrowInfromation['type']) {
                list($tableName, $tableColumn) = explode('.', $displayedrowInfromation['reference']);
                list($referenceName, $tableDisplayColumn) = explode('.', $displayedrowInfromation['displayColumn']);
                $query->with($referenceName);
                $query->leftJoin(
                        $tableName . ' as ' . $tableName . $loopIndex, function ($join) use ($displayDataName, $tableName, $loopIndex) {
                    $join->on($this->tableName . '.' . $displayDataName, '=', $tableName . $loopIndex . '.id');
                }
                );
            }
            ++$loopIndex;
        }

        return $query;
    }

    /**
     * @return array
     */
    public function getListDisplayedDataInformation() {
        return [];
    }

    /**
     * @return array
     */
    public function getListRowActions() {
        return [];
    }

    /**
     * @return array
     */
    public function getListMultipleRowsActions() {
        return [];
    }

    /**
     * @return array
     */
    public function getListActions() {
        return [];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $query = $this->getListQuery();
        $displayedDataInfromation = $this->getListDisplayedDataInformation();
        $rowActions = $this->getListRowActions();
        $pageData = [
            'title' => $this->unitName . ' | ' . __('View All'),
            'unit' => $this->unitName,
            'breadcrumb' => [['label' => $this->unitName]],
            'translationPrefix' => $this->translationPrefix,
            'containsFilters' => false,
        ];
        $routeParameters = array_merge(request()->query(), ['page' => 1]);
        $currentSort = request('sort', $this->tableName . '.id');
        $currentSortDirection = request('sortDirection', 'desc');
        $oppositeSort = ($currentSortDirection === 'desc') ? 'asc' : 'desc';
        foreach ($displayedDataInfromation as $displayDataName => &$displayedrowInfromation) {
            if (isset($displayedrowInfromation['filterType'])) {
                $pageData['containsFilters'] = true;
            }
            $displayedrowInfromation['sortUrl'] = null;
            if (isset($displayedrowInfromation['sortable']) && $displayedrowInfromation['sortable']) {
                $sort = $this->tableName . '.' . $displayDataName;
                if (isset($displayedrowInfromation['sortQuery'])) {
                    $sort = $displayedrowInfromation['sortQuery'];
                }
                if (isset($displayedrowInfromation['type']) && 'reference' === $displayedrowInfromation['type']) {
                    list($tableName, $tableColumn) = explode('.', $displayedrowInfromation['reference']);
                    $sort = $tableName . array_search($displayDataName, array_keys($displayedDataInfromation)) . '.' . $tableColumn;
                }
                $queryParameters = ['sort' => $sort];
                if ($currentSort === $sort) {
                    $displayedrowInfromation['sortDirection'] = $oppositeSort;
                    $queryParameters['sortDirection'] = $oppositeSort;
                }
                $displayedrowInfromation['sortUrl'] = route(Route::currentRouteName(), array_merge($routeParameters, $queryParameters));
            }
        }
        $this->applyRequestFiltersAndSortToQuery($displayedDataInfromation, $query);
        $pageSize = '15';
        if (request('page_size')) {
            $pageSize = request('page_size');
        }
        $pageData['page_size'] = $pageSize;
        $data = $query->orderBy('created_at', 'desc')->paginate($pageSize);
        if (request('sort')) {
            $data->appends(['sort' => $sort, 'sortDirection' => request('sortDirection', 'desc')]);
        }
        $data->appends(['filters' => request('filters')]);

        $viewDataArray = [
            'pageData' => $pageData,
            'dataArray' => $data,
            'rowActions' => $this->getListRowActions(),
            'listActions' => $this->getListActions(),
            'multipleRowsActions' => $this->getListMultipleRowsActions(),
            'displayedDataInfromation' => $displayedDataInfromation,
        ];

        if (method_exists($this, 'getExtraPageData') && is_array($this->getExtraPageData()) && !empty($this->getExtraPageData())) {
            $viewDataArray = $viewDataArray + $this->getExtraPageData();
        }

        return view('dashboard/layout/list', $viewDataArray);
    }

    /**
     * @return array
     */
    public function getShowDisplayedDataInformation() {
        return $this->getPreparedFormComponents(new $this->className());
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
        $pageData = [
            'title' => $this->unitName . ' | ' . __('Show'),
            'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix . 'index')], ['label' => __('Show')]],
            'translationPrefix' => $this->translationPrefix,
        ];

        return view('dashboard.layout.details', ['pageData' => $pageData, 'displayData' => $this->getShowDisplayedDataInformation(), 'data' => $modelObject]);
    }

    /**
     * @param array  $displayedDataInfromation
     * @param object $query
     */
    public function applyRequestFiltersAndSortToQuery(array &$displayedDataInfromation, &$query, $sortCol = 'id') {
        $queryConditions = [];
        $filters = request('filters');
        if (is_array($filters)) {
            foreach ($filters as $key => $value) {
                if (isset($displayedDataInfromation[$key]) && isset($displayedDataInfromation[$key]['filterType'])) {
                    if ($displayedDataInfromation[$key]['filterType'] === 'text' && trim($value)) {
                        if (isset($displayedDataInfromation[$key]['type']) && $displayedDataInfromation[$key]['type'] === 'reference') {
                            list($tableName, $tableColumn) = explode('.', $displayedDataInfromation[$key]['reference']);
                            $query->whereHas(
                                    $tableName, function ($query) use ($tableColumn, $value) {
                                $query->where($tableColumn, 'like', $value . '%');
                            }
                            );
                        } else {
                            if (isset($displayedDataInfromation[$key]['filterQuery'])) {
                                $queryConditions[] = [$displayedDataInfromation[$key]['filterQuery'], 'like', $value . '%'];
                            } else {
                                $queryConditions[] = [$this->tableName . '.' . $key, 'like', $value . '%'];
                            }
                        }
                    }
                    if ($displayedDataInfromation[$key]['filterType'] === 'exact' && trim($value)) {
                        if (isset($displayedDataInfromation[$key]['filterQuery'])) {
                            $queryConditions[] = [$displayedDataInfromation[$key]['filterQuery'], '=', $value];
                        } else {
                            $queryConditions[] = [$this->tableName . '.' . $key, '=', $value];
                        }
                    }
                    if ($displayedDataInfromation[$key]['filterType'] === 'select' && trim($value)) {
                        if (isset($value) && $value === 'No') {
                            $value = 0;
                        }
                        if (isset($displayedDataInfromation[$key]['filterQuery'])) {
                            $queryConditions[] = [$displayedDataInfromation[$key]['filterQuery'], '=', $value];
                        } else {
                            $queryConditions[] = [$this->tableName . '.' . $key, '=', $value];
                        }
                    }
                    if (in_array($displayedDataInfromation[$key]['filterType'], ['date', 'datetime']) && trim($value)) {
                        try {
                            $searchDate = new \DateTime(trim($value));
                            $queryConditions[] = [$this->tableName . '.' . $key, '=', $searchDate];
                        } catch (\Exception $ex) {

                        }
                    }
                    if (in_array($displayedDataInfromation[$key]['filterType'], ['daterange', 'datetimerange']) && is_array($value)) {
                        try {
                            if (isset($value['from']) && trim($value['from'])) {
                                $searchFromDate = new \DateTime(trim($value['from']));
                                $queryConditions[] = [$this->tableName . '.' . $key, '>=', $searchFromDate];
                            }
                            if (isset($value['to']) && trim($value['to'])) {
                                $searchToDate = new \DateTime(trim($value['to']));
                                $queryConditions[] = [$this->tableName . '.' . $key, '<=', $searchToDate];
                            }
                        } catch (\Exception $ex) {

                        }
                    }
                }
            }
        }
        if (count($queryConditions) > 0) {
            $query->where($queryConditions);
        }

        $sort = request('sort');
        $sortDirection = request('sortDirection', 'desc');
        if ($sort) {
            $query->orderBy($sort, $sortDirection);
        }
    }

    /**
     * Activate the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function activate($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);
        $modelObject->update(['suspendedByAdmin' => false]);
        session()->flash('successMessage', __('Successfully activated'));
    }

    /**
     * Deactivate the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deactivate($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);
        $modelObject->update(['suspendedByAdmin' => true]);
        session()->flash('successMessage', __('Successfully deactivated'));
    }

}
