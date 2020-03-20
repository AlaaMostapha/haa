<?php

namespace App\Http\Controllers\Frontend\Company;

use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use App\Services\CompanyService;
use App\Services\CompanyTaskService;
use Auth;

class ProfileController extends Controller {

    /**
     * Display the company profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyTaskService $companyTaskService) {
        $companyProfile = Auth::guard('company')->user();
        $companyFinishedCompanyTasks = $companyTaskService->getFinishedCompanyTasks($companyProfile);
        return view('frontend.company.profile.show', [
            'title' => __('My profile'),
            'companyProfile' => $companyProfile,
            'companyFinishedCompanyTasks' => $companyFinishedCompanyTasks,
            'editLink' => route('company.profile.edit')
        ]);

//        return redirect(route('company.tasks.index'));
    }

    public function load_more(CompanyTaskService $companyTaskService)
    {
        $companyProfile = Auth::guard('company')->user();
        if (request()->ajax()) {
                if (request()->has('id')) {
                    $companyFinishedCompanyTasks = $companyTaskService->getFinishedCompanyTasksLoadMore($companyProfile ,request()->id);
                    return view('frontend.company.profile.finished_company_tasks' , [
                        'companyFinishedCompanyTasks' => $companyFinishedCompanyTasks
                    ]);
                }

        }
    }










    /**
     * Show the form for editing the account.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $company = auth()->user();
        $formRules = CompanyService::getFormValidationRules($company);
        if (!session('update')) {
            $formInputsData = array();
            foreach ($formRules as $modelAttributeName => $modelAttributeValidationRules) {
                if ($modelAttributeName === 'commercialRegistrationExpiryDate') {
                    
                    $formInputsData[$modelAttributeName] = optional(object_get($company, $modelAttributeName))->format('Y-m-d');
                    continue;
                }
                $formInputsData[$modelAttributeName] = object_get($company, $modelAttributeName);
            }
            session()->flashInput($formInputsData);
        }

        return view('frontend.company.profile.edit');
    }

    /**
     * Update the account information in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update() {
        $company = auth()->user();
        $rules = CompanyService::getFormValidationRules($company);
        $data = request(array_keys($rules));
        if (isset($data['mobile'])) {
            try {
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatInternational();
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatE164();
            } catch (\Exception $e) {

            }
        }
        $validator = validator()->make($data, $rules);
        if ($validator->fails()) {
            session()->flash('update', true);
            return redirect()->route('company.profile.edit')->withErrors($validator)->withInput();
        } else {
            if (isset($data['logo'])) {
                $data['logo'] = $data['logo']->store('uploads/company-logo', 'public');
                $oldPath = $company->logo;
                if ($oldPath) {
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
            }

            if ($data['password']) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $company->fill($data)->save();
            session()->flash('successMessage', __('Done successfully'));
            return redirect()->route('company.profile.edit');
        }
    }

}
