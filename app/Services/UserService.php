<?php

namespace App\Services;
use Illuminate\Support\Facades\Validator;
use libphonenumber\PhoneNumberType;
use Illuminate\Validation\Rule;
use App\AppConstants;
use App\Models\UserLanguage;
use App\Models\City;
use App\Models\Major;
use App\Models\University;
use App\Models\UniversityEmail;
use App\Models\User;
use App\Models\UserCertificate;
use App\Models\UserExperience;
use App\Models\UserLanguage as AppUserLanguage;
use App\Rules\CheckUniversityEmail;

class UserService {

    /**
     * Get the dashboard create and edit forms components
     *
     * @param User $user
     * @return array
     */
    public static function getDashboardFormComponents(User $user, $functionName = 'getDashboardFormComponentsPlus'): array {
        $elements = [
            'personalPhoto' => ['type' => 'image', 'help' => __('user.Image hint')],
            'firstName' => ['attr' => ['required' => true, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'lastName' => ['attr' => ['required' => true, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'username' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH, 'pattern' => "^\S*$", 'title' => __('user.not_space_allow')]],
            'email' => ['type' => 'email', 'attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH]],
            'university_email' => ['type' => 'email', 'attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH]],
            'password' => ['type' => 'password', 'attr' => ['minlength' => AppConstants::PASSWORD_MINIMUM_LENGTH, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH]],
            'password_confirmation' => ['type' => 'password'],
            'mobile' => ['attr' => ['required' => true, 'maxlength' => 13, 'minlength' => 13], 'class' => 'left-text'],
            // 'bankAccountNumber' => ['attr' => ['required' => true, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            // 'yearOfStudy' => ['type'=>'select','attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
        ];

        $func = $functionName;
        $elements += UserService::$func($user);

        $elements += [
            'academicYear' => ['type'=>'translated','attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            // 'gpaType' => ['attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            // 'certificates' => ['attr' => ['maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            // 'experiences' => ['attr' => ['maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'summary' => ['type' => 'textarea', 'attr' => ['maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'skills' => ['type' => 'multi-tag' ,'attr' => ['maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'pastProjects' => ['type' => 'file-multi', 'attr' => ['multiple' => ""]],
//            'pastProjects' => ['type' => 'file-multi', 'attr' => ['multiple' => ""], 'help' => __('user.File hint')],
        ];

        return $elements;
    }

    public static function getDashboardFormComponentsPlus(User $user): array {
        return [
            'major_id' => [
                'type' => 'select',
                'options' => UserService::getMajors(),
                'attr' => ['required' => true]
            ],
            'city_id' => [
                'type' => 'select',
                'options' => UserService::getCities(),
                'attr' => ['required' => true]
            ],
            'university_id' => [
                'type' => 'select',
                'options' => UserService::getUniversities(),
                'attr' => ['required' => true]
            ],
            'yearOfStudy' =>[
                'type' =>'select',
                'options' =>UserService::getYearOfStudy()
            ],
            'academicYear' => [
                'type' => 'select',
                'options' => UserService::getAcademicYear(),
            ],
            'gpaType'=> [
                'type' => 'select',
                'options' => UserService::getGpaTypeDashboard(),
            ],
            'gpa' => ['type'=>'number' , 'attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH]],

        ];
    }

    public static function getDashboardDetailComponentsPlus(User $user): array {
        return [
            'major_id' => [
                'type' => 'reference',
                'reference' => 'major.name',
                'displayColumn' => 'major.name',
                'attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'city_id' => [
                'type' => 'reference',
                'reference' => 'city.name',
                'displayColumn' => 'city.name',
                'attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'university_id' => [
                'type' => 'reference',
                'reference' => 'university.name',
                'displayColumn' => 'university.name',
                'attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
        ];
    }

    /**
     * Get the user object validation rules
     *
     * @param User $user
     * @return array
     */
    public static function getDashboardFormValidationRules(User $user): array {
        return [
            'firstName' => ['required', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'lastName' => ['required', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'username' => ['required', 'string', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH, Rule::unique('users')->ignore($user->id), 'regex:' . AppConstants::REGEX_NO_SPACE],
            'email' => ['required', 'email', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'unique:users,email,' . $user->id],
            'university_email' => ['required', 'email', 'unique:users,university_email,' . $user->id, 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, new CheckUniversityEmail],
            'password' => [$user->id ? 'nullable' : 'required', 'min:' . AppConstants::PASSWORD_MINIMUM_LENGTH, 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'confirmed'],
            'password_confirmation' => [],
            'mobile' => 'required|min:13|max:13|string|phone:auto,' . PhoneNumberType::MOBILE . '|not_regex:#/#|not_regex:#-#',
            // 'bankAccountNumber' => ['required', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            // 'major' => ['nullable', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'major_id' => ['required', 'exists:majors,id'],
            'yearOfStudy' => ['nullable', 'date_format:Y'],
            'gpaType' => ['nullable', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH,],
            'gpa' => ['nullable', 'numeric', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH],
            'certificates' => ['nullable', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'experiences' => ['nullable', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            // 'universityName' => ['required', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'university_id' => ['required', 'exists:universities,id'],
            'summary' => ['nullable', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'skills' => ['nullable', 'string'],
            'academicYear' => ['nullable', 'string'],
            'city_id' => ['nullable', 'exists:cities,id'],
            'personalPhoto' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
            'pastProjects' => ['nullable', 'array'],
//            'pastProjects.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf,xlsx,xls,doc,docx,ppt', 'max:500000'],
            'pastProjects.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf,xlsx,xls,doc,docx,ppt', 'max:2000'],
            'certificate_name' => ['nullable' , 'array'],
            'certificate_from' => ['nullable' , 'array'],
            'certificate_date' => ['nullable' , 'array'],
            'certificate_description' => ['nullable' , 'array'],
            'language_other.*' => ['required_if:language_name,==,other'],
            'experience_name' => ['nullable' , 'array'],
            'experience_from' => ['nullable' , 'array'],
            'experience_date' => ['nullable' , 'array'],
        ];
    }

    /**
     * Get the user object validation rules
     *
     * @param User $user
     * @return array
     */
    public static function getFormValidationRules(User $user): array {
        return array_merge(static::getDashboardFormValidationRules($user), [
            'howDidYouFindUs' => ['required', 'in:' . implode(",", array_keys(\App\AppConstants::getHowDidYouFindUsOptions()))],
            'howDidYouFindUsOther' => ['required_if:howDidYouFindUs,other'],
            'accept' => $user->id ? [] : ['accepted'],
        ]);
    }

    public static function getUniversities() {
        return University::all()->map(function ($university) {
                    return [
                        'label' => $university->name,
                        'value' => $university->id,
                    ];
                })->toArray();
    }

    public static function getCities() {
        return City::all()->map(function ($city) {
                    return [
                        'label' => $city->name,
                        'value' => $city->id,
                    ];
                })->toArray();
    }

    public static function getMajors() {
        return Major::all()->map(function ($major) {
                    return [
                        'label' => $major->name,
                        'value' => $major->id,
                    ];
                })->toArray();
    }

    public static function  getAcademicYear()
    {
        return [
            [
                'label' => __('user.first_year'),
                'value' => 'first_year',
            ],
            [
                'label' =>__('user.second_year'),
                'value' => 'second_year',
            ],
            [
                'label' =>  __('user.third_year'),
                'value' => 'third_year',
            ],
            [
                'label' =>  __('user.four_year'),
                'value' => 'four_year',
            ],
            [
                'label' => __('user.last_year'),
                'value' => 'last_year',
            ],
        ];
    }

    public static function getYearOfStudy()
    {
        $years = [];
        for ($year = 2020; $year <=2030; $year++){
            array_push($years , [
                'label' => $year ,
                'value' => $year,
            ]);
        }
        return $years;
    }



    public static function saveFileDropZone($request)
    {
        $data = $request->all();
        $validation = [
            'pastProjects' => ['nullable', 'array'],
            'pastProjects.*' => ['nullable', 'file', 'mimes:jpeg,jpg,png,pdf,xlsx,xls,doc,docx,ppt', 'max:2000'],
        ];

        $validator = Validator::make($data, $validation);
        if ($validator->fails()) {
            $error = implode(' , ', $validator->errors()->toArray()['pastProjects.0']);
            return response()->json(['error' => $error], 400);
        }

        $pastProjects = $request->file('pastProjects');

        if (isset($pastProjects) && is_array($pastProjects)) {
            $project_ids = [];
//            $user = auth()->user();
            foreach ($pastProjects as $projectUploadedImageObject) {
                if ($projectUploadedImageObject instanceof \Illuminate\Http\UploadedFile) {
                    
                    $fileName = $projectUploadedImageObject->getClientOriginalName();
                    $fileSize  =  $projectUploadedImageObject->getSize();

                        //Display File Extension
                        // $fileOriginalExtension    =  $projectUploadedImageObject->getClientOriginalExtension();
                        //Display File Real Path
                        // $fileRealPath    =  $projectUploadedImageObject->getRealPath();
                        //Display File Mime Type
                        // $fileMimeType    =  $projectUploadedImageObject->getMimeType();
                    $imagePath = $projectUploadedImageObject->store('uploads/user-project-picture', 'public');
                    $project = \App\Models\UserProject::create([
                                'image' => $imagePath,
                                'fileName' => $fileName,
                                'fileSize' => $fileSize
//                                'user_id' => $user->id
                    ]);

                    if ($project) {
                        $project_ids[] = $project->id;
                    }
                }
            }
        }

        return response()->json(['project_ids' => implode(',', $project_ids)]);
    }

    public static function saveCertificateData($certificate_id_array , $certificate_name_array ,$certificate_from_array , $certificate_date_array , $certificate_description_array ,$userId)
    {
        if(
            isset($certificate_name_array) && $certificate_name_array != '' &&
            isset($certificate_from_array) && $certificate_from_array != '' &&
            isset($certificate_date_array) && $certificate_date_array != '' &&
            isset($certificate_description_array) && $certificate_description_array != ''
            )
            {
                if( 
                !in_array(null ,$certificate_name_array) &&
                !in_array(null ,$certificate_from_array) &&
                !in_array(null ,$certificate_date_array) &&
                !in_array(null ,$certificate_description_array)
                )
                {
                    if(
                        count($certificate_name_array) == count($certificate_from_array) &&
                        count($certificate_from_array) == count($certificate_date_array) &&
                        count($certificate_date_array) == count($certificate_description_array)
                    )
                    {

                        for($i = 0 ; $i < count($certificate_name_array);$i++ ){
                            $certificate_id_array[$i] = isset($certificate_id_array[$i])?$certificate_id_array[$i] :null;
                            $certificate = UserCertificate::updateOrCreate(
                                                                    ['id' => $certificate_id_array[$i]],
                                                                    ['certificate_name' => $certificate_name_array[$i]  ,
                                                                    'certificate_from' => $certificate_from_array[$i]  ,
                                                                    'certificate_date' => $certificate_date_array[$i]  ,
                                                                    'certificate_description' => $certificate_description_array[$i]  ,
                                                                    'user_id' => $userId  
                                                                    ]);
                        }
                        return true;

                    }else{
                        return false;
                    }

                }else{
                    if( count($certificate_name_array)> 1 &&
                        count($certificate_from_array)> 1 &&
                        count($certificate_date_array)> 1 &&
                        count($certificate_description_array)>1){
                            return false;
                    }

                    return true;
                }

            }else{
                return false ;
            }

    }

    public static function saveExperienceData($experience_id_array , $experience_name_array ,$experience_from_array , $experience_date_array , $experience_description_array ,$userId)
    {
        if(
            isset($experience_name_array) && $experience_name_array != '' &&
            isset($experience_from_array) && $experience_from_array != '' &&
            isset($experience_date_array) && $experience_date_array != '' &&
            isset($experience_description_array) && $experience_description_array != ''
            )
            {
                if( 
                !in_array(null ,$experience_name_array) &&
                !in_array(null ,$experience_from_array) &&
                !in_array(null ,$experience_date_array) &&
                !in_array(null ,$experience_description_array)
                )
                {
                    if(
                        count($experience_name_array) == count($experience_from_array) &&
                        count($experience_from_array) == count($experience_date_array) &&
                        count($experience_date_array) == count($experience_description_array)
                    )
                    {

                        for($i = 0 ; $i < count($experience_name_array);$i++ ){
                            $experience_id_array[$i] = isset($experience_id_array[$i])?$experience_id_array[$i] :null;
                            $experience = UserExperience::updateOrCreate(
                                                                    ['id' => $experience_id_array[$i]],
                                                                    ['experience_name' => $experience_name_array[$i]  ,
                                                                    'experience_from' => $experience_from_array[$i]  ,
                                                                    'experience_date' => $experience_date_array[$i]  ,
                                                                    'experience_description' => $experience_description_array[$i]  ,
                                                                    'user_id' => $userId  
                                                                    ]);
                        }
                        return true;

                    }else{
                        return false;
                    }

                }else{
                    if( count($experience_name_array)> 1 &&
                        count($experience_from_array)> 1 &&
                        count($experience_date_array)> 1 &&
                        count($experience_description_array)>1){
                            return false;
                    }

                    return true;
                }

            }else{
                return false ;
            }

    }

    public static function saveLanguagesData($language_id_array , $language_name_array, $language_level_array , $language_other_array ,$userId)
    {         
        if(
            isset($language_name_array) && $language_name_array != '' &&
            isset($language_level_array) && $language_level_array != '' &&
            isset($language_other_array) && $language_other_array != ''
            ){   

                if(
                    count($language_name_array) == count($language_level_array) &&
                    count($language_level_array) == count($language_other_array) &&
                    count($language_other_array) == count($language_name_array)
                ){
                    for($i = 0 ; $i < count($language_name_array);$i++ ){
                        if($language_name_array[$i] == 'other' && $language_other_array[$i] == null){
                            return false;
                        }
                        $language_id_array[$i] = isset($language_id_array[$i])?$language_id_array[$i] :null;
                        $language = UserLanguage::updateOrCreate(
                                                                ['id' => $language_id_array[$i]],
                                                                ['language_name' => $language_name_array[$i]  ,
                                                                'language_level' => $language_level_array[$i]  ,
                                                                'language_other' => $language_other_array[$i]  ,
                                                                'user_id' => $userId
                                                                ]);
                    }
                    return true;
                }else{
                    return false;
                }
            }else{
                return true;
            }
    }


















    /**
     *  Get gpatype  to select 
     * @return array
     */
    public static function getGpaType(): array {
        return [
            '4' => '4',
            '5' => '5',
            '100' =>'100',
        ];
    }


    public static function getGpaTypeDashboard(): array {
        return [
            [
                'label' => '4',
                'value' => '4',
            ],
            [
                'label' => '5',
                'value' => '5',
            ],
            [
                'label' => '100',
                'value' => '100',
            ],
        ];
    }



    public static function languages()
    {
        return [
            'english' => __("english") ,
            'arabic' => __("arabic"),
            "other"=> __("other")
        ];
    }
    public static function languagesLevel()
    {
        return [
            'beginner' => __("beginner") ,
            'intermediate' => __("intermediate"),
            "professional"=> __("professional"),
            "fluent"=> __("fluent"),

        ];
    }


    public static function getAllUniversityEmails()
    {
        return array_pluck(UniversityEmail::get(['email'])->toArray(), 'email');
        // return UniversityEmail::get(['email'])->map(function($u){return $u->email;})->toArray();

    }
    public function getUserProjectLoadMore(User $user , $id)
    {
        return $user->projects()->where('id' ,'>' , $id)->orderBy('id' , 'asc')->get();
    }



}
