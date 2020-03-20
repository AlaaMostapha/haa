<?php

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */
Route::get('/test',function(){echo bcrypt('123456');});
Route::group([
    'domain' => config('app.domain'),
        ], function () {

    Route::get('/', 'Frontend\Site\PageController@home')->name('home');
    Route::post('/subscriber', 'Frontend\Site\SubscriberController@saveSubscribers')->name('subscriber');


    Route::group([
        'namespace' => 'Frontend\Site',
            ], function () {

        Route::group([
            'middleware' => ['guest'],
                ], function () {
//            Route::get('/', 'PageController@home')->name('home');
            Route::get('/join-haa', 'PageController@joinHaa')->name('join-haa');
            Route::get('/join-haa-login', 'PageController@joinHaaLogin')->name('join-haa-login');
        });

        Route::get('/why-haa', 'PageController@whyHaa')->name('why-haa');
        Route::get('/terms-and-conditions', 'PageController@termsAndConditions')->name('terms-and-conditions');
        Route::get('/privacy-policy', 'PageController@privacyPolicy')->name('privacy-policy');
        Route::get('/about', 'PageController@about')->name('about');
        Route::get('/contact-us', 'PageController@contactUs')->name('contactus');
        Route::post('/contact-us', 'PageController@storeContactUs')->name('contactus.save');

    });

    Route::group([
        'prefix' => 'user',
        'as' => 'user.',
        'namespace' => 'Frontend\User',
            ], function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');
        Route::get('all-tasks' ,'CompanyTaskController@showAllTasks')->name('all.tasks');
        Route::get('task-detail/{companyTask}/show' ,'CompanyTaskController@showDetailsTask')->name('task.detail');

        //////////////////////////////////////////////////////////////////////////
//      Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
//      Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
//      Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
        // Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verifyemail');
        //////////////////////////////////////////////////////////////////////////

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token} ', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

        Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
        Route::get('profile/project/{fileId}/delete', 'ProfileController@deleteFile')->name('file.delete');
        Route::get('profile/project/{fileId}/{taskUserApplyId}/delete', 'ProfileController@deleteFileInShowProfile')->name('file.front.delete');

        Route::post('dropzone/store', 'ProfileController@dropzoneStore')->name('dropzone.store');

        Route::group([
            'middleware' => ['auth:user', 'verified', 'active:user']
                ], function () {
//            Route::get('/user', 'PageController@home')->name('home');
            Route::get('profile', 'ProfileController@show')->name('profile.show');
            Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('profile', 'ProfileController@update')->name('profile.update');
            Route::get('certificate/{id}/delete', 'ProfileController@certificateDelete')->name('certificate.delete');
            Route::get('language/{id}/delete', 'ProfileController@languageDelete')->name('language.delete');
            Route::get('experience/{id}/delete', 'ProfileController@experienceDelete')->name('experience.delete');

            Route::get('tasks', 'CompanyTaskController@index')->name('tasks.index');
            Route::get('tasks/mine', 'CompanyTaskController@myTasks')->name('tasks.myTasks');
            Route::get('tasks/{companyTask}', 'CompanyTaskController@show')->name('tasks.show');
//            Route::get('tasks/{companyTask}/show', 'CompanyTaskController@showTask2')->name('tasks.showTask2');
            Route::post('tasks/{companyTask}/apply', 'CompanyTaskController@apply')->name('tasks.apply');

            Route::get('notifications', 'NotificationController@index')->name('notifications.index');
            Route::post('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.mark-all-as-read');
            Route::post('notifications/delete-all', 'NotificationController@deleteAll')->name('notifications.delete-all');
            Route::post('notifications/{id}/mark-as-read', 'NotificationController@markAsRead')->name('notifications.mark-as-read');
            Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
            Route::post('load-more' ,'ProfileController@load_more')->name('loadmore');
            Route::post('load-more/project' ,'ProfileController@load_more_projects')->name('loadmore.project');


        });
    });

    Route::group([
        'namespace' => 'Frontend\User',
            ], function () {
        Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
        Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
        Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
    });


    Route::group([
        'prefix' => 'company',
        'as' => 'company.',
        'namespace' => 'Frontend\Company',
            ], function () {
        Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('login', 'Auth\LoginController@login');
        Route::post('logout', 'Auth\LoginController@logout')->name('logout');

        Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('register', 'Auth\RegisterController@register');

        Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
        Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
        Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

       Route::get('email/verify', 'Auth\VerificationController@show')->name('verification.notice');
       Route::get('email/verify/{id}', 'Auth\VerificationController@verify')->name('verification.verify');
       Route::get('email/resend', 'Auth\VerificationController@resend')->name('verification.resend');
       Route::get('profile/{companyId}/show' ,'CompanyTaskController@showDetailsCompany')->name('company.detail');
       Route::post('load-more/{companyId}/profile-details' ,'CompanyTaskController@load_more_profile_details')->name('loadmore.profile');


        Route::group([
            'middleware' => ['auth:company', 'active:company' ,'company.verified']
                ], function () {
//            Route::get('/company', 'PageController@home')->name('home');

            Route::get('profile', 'ProfileController@show')->name('profile.show');
            Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
            Route::put('profile', 'ProfileController@update')->name('profile.update');
            Route::resource('tasks', 'CompanyTaskController')->except(['destroy'])->parameters(['tasks' => 'companyTask']);
            Route::post('tasks/{companyTask}/finish', 'CompanyTaskController@finish')->name('tasks.finish');

            //  can review ???
            Route::get('tasks/{companyTaskUserApply}/review', 'CompanyTaskController@review')->name('tasks.review');
            Route::post('tasks/{companyTaskUserApply}/review', 'CompanyTaskController@submitReview')->name('tasks.submitReview');


            Route::get('users/{user}', 'UserController@show')->name('users.show');
            Route::post('tasks/{companyTask}/applicants/{companyTaskUserApply}/accept', 'CompanyTaskController@acceptUserRequest')->name('tasks.applicants.accept');
            Route::post('tasks/{companyTask}/applicants/{companyTaskUserApply}/reject', 'CompanyTaskController@rejectUserRequest')->name('tasks.applicants.reject');

            Route::get('notifications', 'NotificationController@index')->name('notifications.index');
            Route::post('notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.mark-all-as-read');
            Route::post('notifications/delete-all', 'NotificationController@deleteAll')->name('notifications.delete-all');
            Route::post('notifications/{id}/mark-as-read', 'NotificationController@markAsRead')->name('notifications.mark-as-read');
            Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
            Route::post('load-more' ,'ProfileController@load_more')->name('loadmore');
        });
    });
});

Route::group([
    'domain' => config('app.dashboard_subdomain') . '.' . config('app.domain'),
    'as' => 'dashboard.',
    'namespace' => 'Dashboard',
        ], function () {
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');

    Route::group([
        'middleware' => ['auth:admin']
            ], function () {
        Route::get('/', 'ProfileController@home')->name('home');
        Route::get('profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('profile', 'ProfileController@update')->name('profile.update');
        Route::get('subscriber', 'SubscriberController@index')->name('subscriber.index');
        Route::get('conatctus', 'ContactUsController@index')->name('contactus.index');

        Route::get('certificate/{certificateId}/user/{userId}/delete', 'UserController@certificateDelete')->name('certificate.delete');
        Route::get('language/{languageId}/user/{userId}/delete', 'UserController@languageDelete')->name('language.delete');
        
        Route::resource('user', 'UserController');
        Route::post('user/{id}/activate', 'UserController@activate')->name('user.activate');
        Route::post('user/{id}/deactivate', 'UserController@deactivate')->name('user.deactivate');
        Route::post('/user/send-multi-user-email', 'UserController@sendMultiEmail')->name('user.send-multi-user-email');
        Route::post('/user/send-multi-company-email', 'CompanyController@sendMultiEmail')->name('company.send-multi-company-email');

        Route::post('/subscriber/send-multi-user-email', 'SubscriberController@sendMultiEmail')->name('subscriber.send-multi-user-email');

        Route::resource('company', 'CompanyController');
        Route::post('company/{id}/activate', 'CompanyController@activate')->name('company.activate');
        Route::post('company/{id}/deactivate', 'CompanyController@deactivate')->name('company.deactivate');

        Route::resource('companytask', 'CompanyTaskController');
        Route::post('companytask/{id}/activate', 'CompanyTaskController@activate')->name('companytask.activate');
        Route::post('companytask/{id}/deactivate', 'CompanyTaskController@deactivate')->name('companytask.deactivate');

        Route::resource('major', 'MajorController');
        Route::resource('university', 'UniversityController');
        Route::resource('universityEmail', 'UniversityEmailController');

        Route::post('dropzone/store', 'UserController@dropzoneStore')->name('dropzone.store');
    });
});
