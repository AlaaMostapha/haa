<?php

namespace App\Http\Controllers\Frontend\Site;

use App\Http\Controllers\Controller;
use App\Models\Contactus;
use Illuminate\Support\Facades\Auth;
use libphonenumber\PhoneNumberType;
use Illuminate\Support\Facades\Validator;


class PageController extends Controller {

    /**
     * Display the site home page
     *
     * @return \Illuminate\Http\Response
     */
    public function home() {
//        $guard = '';
//        if (Auth::guard('company')->check() && !Auth::user('company')->suspendedByAdmin) {
//            $guard = 'company';
//        } elseif (Auth::guard('user')->check() && !Auth::user('user')->suspendedByAdmin) {
//            $guard = 'user';
//        }

//        if ($guard != '') {
//            var_dump($guard . '     pppp');
//            auth($guard)->logout();
//            return response(view('frontend.errors.503', ['error' => __('Admin deactivated your account')]));
//        }

        return view('frontend.site.page.home');
    }

    /**
     * Display why haa page
     *
     * @return \Illuminate\Http\Response
     */
    public function whyHaa() {
        return view('frontend.site.page.whyHaa');
    }

    /**
     * Display join haa page
     *
     * @return \Illuminate\Http\Response
     */
    public function joinHaa() {
        return view('frontend.site.page.joinHaa');
    }

    /**
     * Display join haa login page
     *
     * @return \Illuminate\Http\Response
     */
    public function joinHaaLogin() {
        return view('frontend.site.page.joinHaaLogin');
    }

    /**
     * Display privacy policy page
     *
     * @return \Illuminate\Http\Response
     */
    public function privacyPolicy() {
        return view('frontend.site.page.privacyPolicy');
    }

    /**
     * Display terms and conditions page
     *
     * @return \Illuminate\Http\Response
     */
    public function termsAndConditions() {
        return view('frontend.site.page.termsAndConditions');
    }

    /**
     * Display about page
     *
     * @return \Illuminate\Http\Response
     */
    public function about() {
        return view('frontend.site.page.about');
    }

    public function contactUs()
    {
        return view('frontend.site.page.contactus');
    }

    public function storeContactUs()
    {
        $rules = $this->getContactUsRules();
        $validator = validator()->make(request()->all(), $rules);

        if ($validator->fails()) {
            return redirect()->route('contactus.save')->withErrors($validator)->withInput();
        }
        $data = request()->only('name' ,'email', 'phone', 'message');
        $obj = Contactus::create($data);
        return redirect()->route('home');
    }

    protected function getContactUsRules()
    {
        return [
            'email' => 'required|email',
            'phone' => 'required|min:13|max:13|string|phone:auto,' . PhoneNumberType::MOBILE . '|not_regex:#/#|not_regex:#-#',
            'message' => 'required|max:512',
        ];
    }

}
