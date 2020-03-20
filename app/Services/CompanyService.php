<?php

namespace App\Services;

use libphonenumber\PhoneNumberType;
use Illuminate\Validation\Rule;
use App\Models\Company;
use App\AppConstants;

class CompanyService {

    /**
     * Get the dashboard create and edit forms components
     *
     * @param Company $company
     * @return array
     */
    public static function getDashboardFormComponents(Company $company): array {
        return [
            'logo' => ['type' => 'image'],
            'name' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'username' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'email' => ['type' => 'email', 'attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH]],
            'password' => ['type' => 'password', 'attr' => ['minlength' => AppConstants::PASSWORD_MINIMUM_LENGTH, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH]],
            'password_confirmation' => ['type' => 'password'],
            'mobile' => ['attr' => ['required' => true], 'class' => 'left-text'],
            // 'bankAccountNumber' => ['attr' => ['required' => true, 'maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'commercialRegistrationNumber' => ['attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'commercialRegistrationExpiryDate' => ['attr' => ['required' => true] , 'type' => 'date'],
            'summary' => ['type' => 'textarea', 'attr' => ['maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH], 'class' => 'textarea'],
        ];
    }

    /**
     * Get the user object validation rules
     *
     * @param Company $company
     * @return array
     */
    public static function getDashboardFormValidationRules(Company $company): array {
        return [
            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
            'name' => ['required', 'string', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'email' => ['required', 'string', 'email', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, Rule::unique('companies')->ignore($company->id)],
            'password' => [$company->id ? 'nullable' : 'required', 'min:' . AppConstants::PASSWORD_MINIMUM_LENGTH, 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'confirmed'],
            'password_confirmation' => [],
            'username' => ['required', 'string', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH, Rule::unique('companies')->ignore($company->id), 'regex:' . AppConstants::REGEX_NO_SPACE],
            'mobile' => 'required|min:13|max:13|string|phone:auto,' . PhoneNumberType::MOBILE . '|not_regex:#/#|not_regex:#-#',
            // 'bankAccountNumber' => ['required', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'commercialRegistrationNumber' => ['required', 'digits:10'],
            'commercialRegistrationExpiryDate' => ['required', 'date'],
            'summary' => ['nullable', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
        ];
    }

    /**
     * Get the company object validation rules
     *
     * @param Company $company
     * @return array
     */
    public static function getFormValidationRules(Company $company): array {
        return array_merge(static::getDashboardFormValidationRules($company), [
//            'logo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:1024'],
//            'summary' => ['nullable', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'howDidYouFindUs' => ['required', 'in:' . implode(",", array_keys(\App\AppConstants::getHowDidYouFindUsOptions()))],
            'howDidYouFindUsOther' => ['required_if:howDidYouFindUs,other'],
            'accept' => $company->id ? [] : ['accepted'],
        ]);
    }

    public static function getDashboardDetailComponentsPlus(Company $company): array {
        return [
            'howDidYouFindUs' => [
                'type' => 'translated',
                'hasOther' => true
            ],
        ];
    }

}
