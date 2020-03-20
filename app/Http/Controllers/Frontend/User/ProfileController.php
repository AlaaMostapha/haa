<?php

namespace App\Http\Controllers\Frontend\User;

use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Services\CompanyTaskService;
use App\Http\Controllers\Controller;
use App\Services\UserService;
use App\Models\User;
use App\Models\UserCertificate;
use App\Models\UserExperience;
use App\Models\UserLanguage;

use App\Models\UserProject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller {

    /**
     * Display the user profile.
     *
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyTaskService $companyTaskService) {
        $user = auth()->user();
        $userProjects = $user->projects()->orderBy('id' ,'asc')->limit(3)->get();
        $userFinishedCompanyTasks = $companyTaskService->getUserFinishedCompanyTasks($user);

        $userReviewsQuery = $companyTaskService->getUserReviews($user);

        $userReviewsCount = $userReviewsQuery->count();
        if (request()->get('display') && request()->get('display') == 'all') {
            $userReviews = $userReviewsQuery->get();
        } else {
            $userReviews = $userReviewsQuery->paginate(User::REVIEWS_COUNT_DEFAULT);
        }

        return view('frontend.user.profile.show', [
            'title' => __('My profile'),
            'user' => $user,
            'userFinishedCompanyTasks' => $userFinishedCompanyTasks,
            'userReviews' => $userReviews,
            'userReviewsCount' => $userReviewsCount,
            'userProjects' => $userProjects,
            'editLink' => route('user.profile.edit')
        ]);
    }

    public function load_more_projects(UserService $userService)
    {
        $user = auth()->user();
        if (request()->ajax()) {
            if (request()->has('id')) {
                $userProjects = $userService->getUserProjectLoadMore($user ,request()->id);
                return view('frontend.user.profile.user_projects_ajax' , ['userProjects' => $userProjects]);
            }
        }    
    }
    public function load_more(CompanyTaskService $companyTaskService)
    {
        $user = auth()->user();
        if (request()->ajax()) {
                if (request()->has('id')) {
                    $userFinishedCompanyTasks = $companyTaskService->getUserFinishedCompanyTasksLoadMore($user ,request()->id);
                    return view('frontend.user.profile.finished_user_tasks' , [
                        'userFinishedCompanyTasks' => $userFinishedCompanyTasks
                    ]);
                }

        }
    }

    public function certificateDelete($id)
    {
        $certificate = UserCertificate::findOrFail($id);
        $certificate->delete();        
        $certificateCount = optional(auth()->user())->certificates()->count();

        return response()->json(['message' => __('The_Certificate_is_delete_success') , 'certificateCount' => $certificateCount] ,200);

    }
    public function languageDelete($id)
    {
        $language =  UserLanguage::findOrFail($id);
        $language->delete();
        
        $languageCount = optional(auth()->user())->languages()->count();
        return response()->json(['message' => __('The_Language_is_delete_success') , 'languageCount' => $languageCount] ,200);

    }

    public function experienceDelete($id)
    {
        $experience = UserExperience::findOrFail($id);
        $experience->delete();        
        $experienceCount = optional(auth()->user())->experiences()->count();

        return response()->json(['message' => __('The_experience_is_delete_success') , 'experienceCount' => $experienceCount] ,200);

    }
    /**
     * Show the form for editing the account.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit() {
        $user = auth()->user();
        $formRules = UserService::getFormValidationRules($user);
        if (!session('update')) {
            $formInputsData = array();
            foreach ($formRules as $modelAttributeName => $modelAttributeValidationRules) {
                $formInputsData[$modelAttributeName] = object_get($user, $modelAttributeName);
            }
            $formInputsData['id'] = $user->certificates()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['certificate_name'] = $user->certificates()->get()->map(function($model){
                    return $model->certificate_name;
            })->toArray();
            $formInputsData['certificate_from'] = $user->certificates()->get()->map(function($model){
                
                return $model->certificate_from;
            })->toArray();
            $formInputsData['certificate_date'] = $user->certificates()->get()->map(function($model){
                return $model->certificate_date;
            })->toArray();
            $formInputsData['certificate_description'] = $user->certificates()->get()->map(function($model){
            return $model->certificate_description;
            })->toArray();


            $formInputsData['language_id'] = $user->languages()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['language_name'] = $user->languages()->get()->map(function($model){
                    return $model->language_name;
            })->toArray();
            $formInputsData['language_level'] = $user->languages()->get()->map(function($model){
                return $model->language_level;
            })->toArray();

            $formInputsData['language_other'] = $user->languages()->get()->map(function($model){
                return $model->language_other;
            })->toArray();


            $formInputsData['experience_id'] = $user->experiences()->get()->map(function($model){
                return $model->id;
            })->toArray();
            $formInputsData['experience_name'] = $user->experiences()->get()->map(function($model){
                    return $model->experience_name;
            })->toArray();
            $formInputsData['experience_from'] = $user->experiences()->get()->map(function($model){
                
                return $model->experience_from;
            })->toArray();
            $formInputsData['experience_date'] = $user->experiences()->get()->map(function($model){
                return $model->experience_date;
            })->toArray();
            $formInputsData['experience_description'] = $user->experiences()->get()->map(function($model){
            return $model->experience_description;
            })->toArray();
            session()->flashInput($formInputsData);
        }
        return view('frontend.user.profile.edit');
    }

    /**
     * Update the account information in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update() {
        $user = auth()->user();
        $rules = UserService::getFormValidationRules($user);
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
            return redirect()->route('user.profile.edit')->withErrors($validator)->withInput();
        } else {
            if (isset($data['personalPhoto'])) {
                $data['personalPhoto'] = $data['personalPhoto']->store('uploads/user-profile-picture', 'public');
                $oldPath = $user->personalPhoto;
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
            $user->fill($data)->save();

            $data['project_ids'] = request('project_ids');
            if (isset($data['project_ids']) && $data['project_ids'] != '') {
                $project_ids = explode(',', $data['project_ids']);
                foreach ($project_ids as $project) {
                    \App\Models\UserProject::where('id', $project)->update([
                        'user_id' => $user->id
                    ]);
                    }}
//            if (isset($data['pastProjects']) && is_array($data['pastProjects'])) {
//                foreach ($data['pastProjects'] as $projectUploadedImageObject) {
//                    if ($projectUploadedImageObject instanceof \Illuminate\Http\UploadedFile) {
//                        $imagePath = $projectUploadedImageObject->store('uploads/user-project-picture', 'public');
//                        \App\Models\UserProject::create([
//                            'image' => $imagePath,
//                            'user_id' => $user->id
//                        ]);
//                    }
//                }
//            }
            $data['certificate_id'] = request('certificate_id');
            $data['certificate_name'] = request('certificate_name');
            $data['certificate_from'] = request('certificate_from');
            $data['certificate_date'] = request('certificate_date');
            $data['certificate_description'] = request('certificate_description');

            $certificateSaved = UserService::saveCertificateData($data['certificate_id'] ,$data['certificate_name'] ,
                                            $data['certificate_from']  , $data['certificate_date'],$data['certificate_description'],$user->id);
            if ($certificateSaved == false) {
                return redirect()->route('user.profile.edit')->with('failMessage_certificate',__("user.certificate_field_empty"));
            }

            $data['experience_id'] = request('experience_id');
            $data['experience_name'] = request('experience_name');
            $data['experience_from'] = request('experience_from');
            $data['experience_date'] = request('experience_date');
            $data['experience_description'] = request('experience_description');

            $experienceSaved = UserService::saveExperienceData($data['experience_id'] ,$data['experience_name'] ,
                                            $data['experience_from']  , $data['experience_date'],$data['experience_description'],$user->id);
            if ($experienceSaved == false) {
                return redirect()->route('user.profile.edit')->with('failMessage_experience',__("user.experience_field_empty"));
            }

            $data['language_id'] = request('language_id');
            $data['language_name'] = request('language_name');
            $data['language_level'] = request('language_level');
            $data['language_other'] = request('language_other');
            // dd(request()->all());
            $langSaved =  UserService::saveLanguagesData( $data['language_id'] , $data['language_name']  , $data['language_level'] ,$data['language_other'] ,$user->id);
            if($langSaved == false){
                return redirect()->route('user.profile.edit')->with('failMessage_language',__("user.language_error"));
            }
            
            session()->flash('successMessage', __('Done successfully'));
            return redirect()->route('user.profile.edit');
        }
    }
        
    public function deleteFileInShowProfile() {
        $id = request('fileId');
        // dd($id ,request()->route('taskUserApplyId'));
        $taskUserApplyId = null;
        $userProjects = null ;
        if (request()->route('taskUserApplyId')) {
            # code...
            $taskUserApplyId = request('taskUserApplyId');
            $userProjects = optional(auth()->user())->projects()->where('id' ,'>' , $taskUserApplyId)->orderBy('id' ,'asc')->limit(1)->get();


            $taskUserApplyId = $userProjects->first()->id;

        }
        $project = UserProject::findOrFail($id);
        if (file_exists(Storage::disk('public')->path($project->image))) {
            unlink(Storage::disk('public')->path($project->image));
            $project->delete();
            $userProjectsCount= optional(auth()->user())->projects()->count();
            return response()->json(["project" => $project, "userProjectsCount"=>$userProjectsCount,
                                    "userProjects" => view('frontend.user.profile.user_projects_ajax' , ['userProjects' => $userProjects])->render(),
                                    "taskUserApplyId" => $taskUserApplyId,
                                    "message" => __("validation.delete_success")], 201);
        }
        return response()->json(["project" => $project, "message" => __("validation.delete_fail")], 422);
    }
            
    public function deleteFile() {
        $id = request('fileId');
        $project = UserProject::findOrFail($id);
        if (file_exists(Storage::disk('public')->path($project->image))) {
            unlink(Storage::disk('public')->path($project->image));
            $project->delete();
            return response()->json(["project" => $project, "message" => __("validation.delete_success")], 201);
        }
        return response()->json(["project" => $project, "message" => __("validation.delete_fail")], 422);
    }

    public function dropzoneStore(Request $request) {
       return UserService::saveFileDropZone($request);
    }

}
