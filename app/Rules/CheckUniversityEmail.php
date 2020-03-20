<?php

namespace App\Rules;

use App\Services\UserService;
use Illuminate\Contracts\Validation\Rule;

class CheckUniversityEmail implements Rule
{


    public $listEmail  =  [
                            'student.riyadh.edu.sa' ,
                            'st.uqu.edu.sa',
                            'sm.imamu.edu.sa',
                            'stu.kau.edu.sa',
                            'student.ksu.edu.sa',
                            'kfupm.edu.sa',
                            'nauss.edu.sa',
                            'student.kfu.edu',
                            'kku.edu.sa',
                            'qu.edu.sa',
                            'taibahu.edu.sa',
                            'students.tu.edu.sa',
                            'stu.jazanu.edu.sa',
                            'example.com',
                            'stu.bu.edu.sa',
                            'stu.ut.edu.sa',
                            'nu.edu.sa',
                            'pnu.edu.sa',
                            'ksau-hs.edu.sa',
                            'iau.edu.sa',
                            'kaust.edu.sa',
                            'std.psau.edu.sa',
                            'std.su.edu.sa',
                            's.mu.edu.sa',
                            'eu.edu.sa',
                            'uj.edu.sa',
                            'ttcollege.edu.sa',
                            'uhb.edu.sa',
                            'mbsc.edu.sa',
                            'sr.edu.sa',
                            'Ibnsina.edu.sa',
                            'bmc.edu.sa',
                            'alfaisal.edu',
                            'alfarabi.edu.sa',
                            'mcst.edu.sa',
                            'riyadh.edu.sa',
                            'dah.edu.sa',
                            'upm.edu.sa',
                            'dau.edu.sa',
                            'psu.edu.sa',
                            'aou.edu.om',
                            'yu.edu.sa',
                            'fbsu.edu.sa',
                            'pmu.edu.sa',
                            'ubt.edu.sa',
                            'jicollege.edu.sa',
                            'tctc.gov.sa',
                            'amc.edu.sa',
                            'tendegrees.sa'
                        ];
    
                        /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        list($beforeAt,$domain) = explode('@' , $value);
        $domain = strtolower($domain);
        // if (in_array($domain, $this->listEmail))
        if (in_array($domain, $this->getListEmail()))
        {
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.university_email_validation');
    }

    function getListEmail() {
        return UserService::getAllUniversityEmails();
    }
}
