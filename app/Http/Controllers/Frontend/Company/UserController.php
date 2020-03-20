<?php

namespace App\Http\Controllers\Frontend\Company;

use App\Models\User;
use App\Services\CompanyTaskService;
use App\Http\Controllers\Controller;

//use App\Models\CompanyTaskUserApply;

class UserController extends Controller {

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, CompanyTaskService $companyTaskService) {
        $userProjects = $user->projects()->orderBy('id', 'asc')->limit(3)->get();

        $userFinishedCompanyTasks = $companyTaskService->getUserFinishedCompanyTasks($user);
        $userReviewsQuery = $companyTaskService->getUserReviews($user);

        $userReviewsCount = $userReviewsQuery->count();
        if (request()->get('display') && request()->get('display') == 'all') {
            $userReviews = $userReviewsQuery->get();
        } else {
            $userReviews = $userReviewsQuery->paginate(User::REVIEWS_COUNT_DEFAULT);
        }
//        return view('frontend.user.profile.show', [
        return view('frontend.company.user_profile.show', [
            'title' => $user->firstName . ' ' . $user->lastName,
            'user' => $user,
            'userFinishedCompanyTasks' => $userFinishedCompanyTasks,
            'userReviews' => $userReviews,
            'userReviewsCount' => $userReviewsCount,
            'userProjects' => $userProjects,
            'editLink' => null
        ]);
    }

}
