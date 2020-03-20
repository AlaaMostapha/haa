<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Dashboard\DashboardBaseController;
use App\Mail\SendMailUsers;
use App\Services\UserService;
use App\Models\User;
use App\Models\UserCertificate;
use App\Models\UserLanguage;
use App\Models\UserProject;
use App\Models\UserExperience;
use Illuminate\Support\Facades\Storage;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;

class UserController extends DashboardBaseController {

    public $className = User::class;

    /**
     * {@inheritdoc}
     */
    public function getListDisplayedDataInformation() {
        return [
            'firstName' => [],
            'lastName' => [],
            'email' => ['filterType' => 'text', 'sortable' => true],
            'is_verified' => [],
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
            ['type' => 'activate', 'route' => 'dashboard.user.activate', 'displayParameter' => 'suspendedByAdmin'],
            ['type' => 'deactivate', 'route' => 'dashboard.user.deactivate', 'displayParameter' => 'suspendedByAdmin'],
            ['type' => 'isVerify'],
        ];
    }

    public function getListMultipleRowsActions()
    {
        return  [[
                'type' => 'send_email_user',
                'route' => 'dashboard.user.send-multi-user-email',
        ]];
    }






    /**
     * {@inheritdoc}
     */
    public function getFormComponents($modelObject) {
        if (strpos(request()->route()->getName(), 'show') !== false) {
//            return UserService::getDashboardFormComponents($modelObject, 'getDashboardDetailComponentsPlus');
            return array_merge(UserService::getDashboardFormComponents($modelObject, 'getDashboardDetailComponentsPlus'), ['howDidYouFindUs' => [
                    'type' => 'translated',
                    'hasOther' => true
            ]]);
        } else {
            return UserService::getDashboardFormComponents($modelObject);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFormRules($modelObject) {
        return UserService::getDashboardFormValidationRules($modelObject);
    }

    /**
     * {@inheritdoc}
     */
    public function getShowDisplayedDataInformation() {
        $data = $this->getPreparedFormComponents(new $this->className());
        unset($data['email_confirmation']);
        unset($data['password']);
        unset($data['password_confirmation']);
        return $data;
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

            $data['project_ids'] = request('project_ids');
            if (isset($data['project_ids']) && $data['project_ids'] != '') {
                $project_ids = explode(',', $data['project_ids']);
                foreach ($project_ids as $project) {
                    \App\Models\UserProject::where('id', $project)->update([
                        'user_id' => $modelObject->id
                    ]);
                }
            }

            // insert Certification and Experience and languages
            $data['certificate_id'] = request('certificate_id');
            $data['certificate_name'] = request('certificate_name');
            $data['certificate_from'] = request('certificate_from');
            $data['certificate_date'] = request('certificate_date');
            $data['certificate_description'] = request('certificate_description');

            $certificateSaved = UserService::saveCertificateData($data['certificate_id'] ,$data['certificate_name'] ,
                                            $data['certificate_from']  , $data['certificate_date'],$data['certificate_description'] ,$modelObject->id);
            if ($certificateSaved == false) {
                return redirect()->route('dashboard.user.edit',['id'=> $modelObject->id])->with('failMessage_certificate',__("user.certificate_field_empty"));
            }


            $data['experience_id'] = request('experience_id');
            $data['experience_name'] = request('experience_name');
            $data['experience_from'] = request('experience_from');
            $data['experience_date'] = request('experience_date');
            $data['experience_description'] = request('experience_description');

            $experienceSaved = UserService::saveExperienceData($data['experience_id'] ,$data['experience_name'] ,
                                            $data['experience_from']  , $data['experience_date'],$data['experience_description'] ,$modelObject->id);
            if ($experienceSaved == false) {
                return redirect()->route('dashboard.user.edit',['id'=> $modelObject->id])->with('failMessage_experience',__("user.experience_field_empty"));
            }


            $data['language_id'] = request('language_id');
            $data['language_name'] = request('language_name');
            $data['language_level'] = request('language_level');
            $data['language_other'] = request('language_other');
            // dd(request()->all());
            $langSaved =  UserService::saveLanguagesData( $data['language_id'] , $data['language_name']  , $data['language_level'] ,$data['language_other'] ,$modelObject->id);
            if($langSaved == false){
                return redirect()->route('dashboard.user.edit',['id'=> $modelObject->id])->with('failMessage_language',__("user.language_error"));
            }







//            if (isset($data['pastProjects']) && is_array($data['pastProjects'])) {
//                foreach ($data['pastProjects'] as $projectUploadedImageObject) {
//                    if ($projectUploadedImageObject instanceof \Illuminate\Http\UploadedFile) {
//                        $imagePath = $projectUploadedImageObject->store('uploads/user-project-picture', 'public');
//                        UserProject::create([
//                            'image' => $imagePath,
//                            'user_id' => $modelObject->id
//                        ]);
//                    }
//                }
//            }
            session()->flash('successMessage', __('Done successfully'));
            return redirect()->route($listRoute);
        }
    }


        public function certificateDelete($certificateId ,$userId)
        {
            $certificate = UserCertificate::findOrFail($certificateId);
            $certificate->delete();
            $certificateCount = UserCertificate::where('user_id',$userId)->count();
            // dd(optional(auth()->user()));
            // $certificateCount = optional(auth()->user())->certificates->count();
            return response()->json(['message' => __('The_Certificate_is_delete_success') , 'certificateCount' => $certificateCount] ,200);

        }
        public function languageDelete($languageId , $userId)
        {
            $language = UserLanguage::findOrFail($languageId);
            $language->delete();
            $languageCount = UserLanguage::where('user_id',$userId)->count();
            // $language =  UserLanguage::findOrFail($id);
            // $language->delete();
            // $languageCount = optional(auth()->user())->languages()->count();
            return response()->json(['message' => __('The_Language_is_delete_success') , 'languageCount' => $languageCount] ,200);

        }


        public function experienceDelete($experienceId , $userId)
        {
            $experience = UserExperience::findOrFail($experienceId);
            $experience->delete();
            $experienceCount = UserExperience::where('user_id',$userId)->count();
            // $language =  UserLanguage::findOrFail($id);
            // $language->delete();
            // $languageCount = optional(auth()->user())->languages()->count();
            return response()->json(['message' => __('The_experience_is_delete_success') , 'experienceCount' => $experienceCount] ,200);

        }


        public function show($id) {
        $modelObject = call_user_func($this->className . '::findOrFail', $id);
        $userCertificates = UserCertificate::whereUserId($modelObject->id)->get();

        $userLanguages = UserLanguage::whereUserId($modelObject->id)->get();
        $userExperiences = UserExperience::whereUserId($modelObject->id)->get();

        $pageData = [
            'title' => $this->unitName . ' | ' . __('Show'),
            'breadcrumb' => [['label' => $this->unitName, 'url' => route('dashboard.' . $this->translationPrefix . 'index')], ['label' => __('Show')]],
            'translationPrefix' => $this->translationPrefix,
        ];

        return view('dashboard.user.details', ['pageData' => $pageData, 'displayData' => $this->getShowDisplayedDataInformation(), 'data' => $modelObject ,'userCertificates'=>$userCertificates , 'userLanguages' => $userLanguages ,'userExperiences' => $userExperiences ]);
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
            // ADD data certificates to session  in edit mode
            $formInputsData['id'] = $modelObject->certificates()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['certificate_name'] = $modelObject->certificates()->get()->map(function($model){
                    return $model->certificate_name;
            })->toArray();
            $formInputsData['certificate_from'] = $modelObject->certificates()->get()->map(function($model){
                
                return $model->certificate_from;
            })->toArray();
            $formInputsData['certificate_date'] = $modelObject->certificates()->get()->map(function($model){
                return $model->certificate_date;
            })->toArray();
            $formInputsData['certificate_description'] = $modelObject->certificates()->get()->map(function($model){
            return $model->certificate_description;
            })->toArray();

            $formInputsData['language_id'] = $modelObject->languages()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['language_name'] = $modelObject->languages()->get()->map(function($model){
                    return $model->language_name;
            })->toArray();
            $formInputsData['language_level'] = $modelObject->languages()->get()->map(function($model){
                return $model->language_level;
            })->toArray();

            $formInputsData['language_other'] = $modelObject->languages()->get()->map(function($model){
                return $model->language_other;
            })->toArray();

            $formInputsData['experience_id'] = $modelObject->experiences()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['experience_name'] = $modelObject->experiences()->get()->map(function($model){
                    return $model->experience_name;
            })->toArray();
            $formInputsData['experience_from'] = $modelObject->experiences()->get()->map(function($model){
                
                return $model->experience_from;
            })->toArray();
            $formInputsData['experience_date'] = $modelObject->experiences()->get()->map(function($model){
                return $model->experience_date;
            })->toArray();
            $formInputsData['experience_description'] = $modelObject->experiences()->get()->map(function($model){
            return $model->experience_description;
            })->toArray();




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

        return view('dashboard.user.form', ['pageData' => $pageData, 'formData' => $formData, 'formComponents' => $formComponents, 'data' => $modelObject]);
    }

    public function dropzoneStore(Request $request) {
       return UserService::saveFileDropZone($request);
    }

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
                'dashboard.user.form', [
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

    public function sendMultiEmail() {
        $rules = [
            'ids' => 'required|max:170',
            'subject' => 'required|max:170',
            'description' => 'required|max:1000',
            'file' => 'nullable|file|mimes:pdf,ppt,docx,png,jpeg,gif,jpg|max:2048',
        ];
        $data = (object) \request()->only(array_keys($rules));
        $validator = validator()->make(((array) $data), $rules);
        if ($validator->fails()) {
            session()->flash('update', true);
            return;
        }
        // if (isset($data->file)) {
        //     $data->file = Upload::file($data->file, User::UPLOAD_PATH_EMAIL);
        // }
        collect(explode(',', $data->ids))->each(
            function ($id) use ($data) {
            $obj = User::find($id);
            $email = $obj->email;
            Mail::to($email)->send(new SendMailUsers($data));
        });


        session()->flash('successMessage', __('Done successfully'));
        return \redirect(route('dashboard.user.index'));
    }

}
