<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Models\Company;
use App\Models\Admin;
use App\Models\User;
use App\AppConstants;

class ProfileController extends DashboardBaseController
{

    public $className = Admin::class;
    public $translationPrefix = 'admin.';

    /**
     * Display the admin home page
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {

        return view('dashboard.page.home', [
            'usersCount' => User::count(),
            'companiesCount' => Company::count(),
        ]);
    }

    /**
     * Get the form inputs data.
     *
     * @param object $modelObject
     *
     * @return array
     */
    public function getFormComponents($modelObject)
    {
        return [
            'name' => ['attr' => ['required' => true]],
            'email' => ['type' => 'email', 'attr' => ['required' => true]],
            'password' => ['type' => 'password'],
            'password_confirmation' => ['type' => 'password'],
        ];
    }

    /**
     * Get the form inputs data.
     *
     * @param object $modelObject
     *
     * @return array
     */
    public function getFormRules($modelObject)
    {
        return [
            'name' => 'required|max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH . '',
            'email' => 'required|email|max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH . '|unique:admins,email,' . $modelObject->id . ',id',
            'password' => 'nullable|max:' . AppConstants::STRINGS_MAXIMUM_LENGTH . '|min:' . AppConstants::PASSWORD_MINIMUM_LENGTH . '|confirmed',
            'password' => 'required_with:password|same:password',
        ];
    }

    /**
     * Show the form for editing the account.
     *
     * @return \Illuminate\Http\Response
     */

    public function edit($id = null)
    {
        $modelObject = auth()->user();
        $id = $modelObject->id;

        $formComponents = $this->getPreparedFormComponents($modelObject);
        $formComponentsTypes = array_pluck($formComponents, 'type');

        if (!session('update')) {
            $formInputsData = [];
            foreach ($formComponents as $formComponentName => $formComponent) {
                $formInputsData[$formComponent['accessor']] = data_get($modelObject, $formComponent['accessor']);
            }
            if (isset($formInputsData['password'])) {
                unset($formInputsData['password']);
            }
            session()->flashInput($formInputsData);
        }

        $pageData = [
            'title' => $this->unitName . ' | ' . __('Edit'),
            'translationPrefix' => $this->translationPrefix,
        ];

        $formData = [
            'action' => route('dashboard.profile.update'),
            'method' => 'PUT',
        ];

        return view('dashboard.layout.form', ['pageData' => $pageData, 'formData' => $formData, 'formComponents' => $formComponents]);
    }

    /**
     * Update the account information in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id = null)
    {
        return $this->validateAndSaveModelThenReturnResponse(
            auth()->user(), 'dashboard.profile.edit', [], 'dashboard.profile.edit'
        );
    }

}
