<?php

namespace App\Http\Controllers\Frontend\User\Auth;

use App\Models\User;
use App\Services\UserService;
use App\Models\UserProject;
use App\Http\Controllers\Controller;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;


class RegisterController extends Controller {
    /*
      |--------------------------------------------------------------------------
      | Register Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles the registration of new users as well as their
      | validation and creation. By default this controller uses a trait to
      | provide this functionality without requiring any additional code.
      |
     */

use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data) {
        return Validator::make($data, UserService::getFormValidationRules(new User()));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data) {
        if (isset($data['mobile'])) {
            try {
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatInternational();
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatE164();
            } catch (\Exception $e) {

            }
        }

        if (isset($data['personalPhoto'])) {
            $data['personalPhoto'] = $data['personalPhoto']->store('uploads/user-profile-picture', 'public');
        } else {
            $data['personalPhoto'] = null;
        }
        $user = User::create([
                    'firstName' => $data['firstName'],
                    'lastName' => $data['lastName'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'mobile' => $data['mobile'],
                    // 'bankAccountNumber' => $data['bankAccountNumber'],
                    'major_id' => $data['major_id'],
                    'yearOfStudy' => $data['yearOfStudy'],
                    'gpaType' => (isset($data['gpaType'])) ? $data['gpaType'] : $data['gpaType'] = null,
                    'gpa' => (isset($data['gpa'])) ? $data['gpa'] : $data['gpa'] = null,
                    'certificates' =>(isset($data['certificates'])) ? $data['certificates'] : $data['certificates'] = null ,
                    'experiences' => (isset($data['experiences'])) ? $data['experiences'] : $data['experiences'] = null,
                    'university_id' => (isset($data['university_id'])) ? $data['university_id'] : $data['university_id'] = null,
                    'howDidYouFindUs' => $data['howDidYouFindUs'],
                    'howDidYouFindUsOther' => $data['howDidYouFindUsOther'],
                    'personalPhoto' => $data['personalPhoto'],
                    'summary' => (isset($data['summary']))? $data['summary'] : $data['summary'] = null,
                    'city_id' => (isset($data['city_id'])) ? $data['city_id'] : $data['city_id'] = null,
                    'skills' => (isset($data['skills'])) ? $data['skills'] : $data['skills'] = null,
                    'academicYear' => (isset($data['academicYear'])) ? $data['academicYear'] : $data['academicYear'] = null,
                    'university_email' => $data['university_email']
        ]);

        $data['project_ids'] = request('project_ids');
        if (isset($data['project_ids']) && $data['project_ids'] != '') {
            $project_ids = explode(',', $data['project_ids']);
            foreach ($project_ids as $project) {
                \App\Models\UserProject::where('id', $project)->update([
                    'user_id' => $user->id
                ]);
            }
        }

//        if (isset($data['pastProjects']) && is_array($data['pastProjects'])) {
//            foreach ($data['pastProjects'] as $projectUploadedImageObject) {
//                if ($projectUploadedImageObject instanceof \Illuminate\Http\UploadedFile) {
//                    $imagePath = $projectUploadedImageObject->store('uploads/user-project-picture', 'public');
//                    UserProject::create([
//                        'image' => $imagePath,
//                        'user_id' => $user->id
//                    ]);
//                }
//            }
//        }

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm() {
        return view('frontend.user.auth.register');
    }

    protected function guard() {
        return Auth::guard('user');
    }

}
