<?php

namespace App\Http\Controllers\Frontend\Company\Auth;

use App\Models\Company;
use App\Services\CompanyService;
use App\Http\Controllers\Controller;
use Propaganistas\LaravelPhone\PhoneNumber;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
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
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, CompanyService::getFormValidationRules(new Company()));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        if (isset($data['mobile'])) {
            try {
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatInternational();
                $data['mobile'] = PhoneNumber::make($data['mobile'])->formatE164();
            } catch (\Exception $e) {
            }
        }

        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('uploads/company-logo', 'public');
        } else {
            $data['logo'] = null;
        }
        return Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'username' => $data['username'],
            'mobile' => $data['mobile'],
            // 'bankAccountNumber' => $data['bankAccountNumber'],
            'commercialRegistrationNumber' => $data['commercialRegistrationNumber'],
            'commercialRegistrationExpiryDate' => (isset($data['commercialRegistrationExpiryDate'])) ? $data['commercialRegistrationExpiryDate'] : $data['commercialRegistrationExpiryDate'] = null,
            'howDidYouFindUs' => $data['howDidYouFindUs'],
            'howDidYouFindUsOther' => $data['howDidYouFindUsOther'],
            'summary' => (isset($data['summary'])) ? $data['summary'] : $data['summary'] = null,
            'logo' => $data['logo'],
        ]);
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('frontend.company.auth.register');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('company');
    }
}
