<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Notifications\User\AcceptedCompanyTaskUserApply;
use App\Notifications\User\RejectedCompanyTaskUserApply;
use App\Notifications\Company\UserAppliedOnCompanyTask;
use App\Notifications\User\CompanyTaskFinished;
use App\Models\CompanyTaskUserApply;
use App\Models\CompanyTask;
use App\Models\Company;
use App\Models\User;
use App\AppConstants;
use Illuminate\Validation\Rule;

class CompanyTaskService {

    /**
     * Get the dashboard create and edit forms components
     *
     * @return array
     */
    public static function getFormComponents(): array {
        return [
            'title' => ['attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'status' => ['type' => 'translated', 'attr' => ['required' => true, 'maxlength' => AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'startDate' => ['type' => 'date', 'attr' => ['required' => true]],
            'endDate' => ['type' => 'date', 'attr' => ['required' => true]],
            'price' => ['attr' => ['max' => AppConstants::SMALL_INTEGER_MAXIMUM_VALUE]],
            'type' => ['type' => 'translated', 'attr' => ['max' => AppConstants::SMALL_INTEGER_MAXIMUM_VALUE]],
            // 'major_id' => ['type'=>'reference','attr' => ['maxlength' => AppConstants::STRINGS_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'requiredNumberOfUsers' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'appliedUsersCount' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'language' => ['details-type' => 'multi-data'],
            'location' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'workHoursCount' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'willTakeCertificate' => ['type' => 'boolean', 'attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            // 'major' => [
            //     'type' => 'reference',
            //     'reference' => 'major.name',
            //     'displayColumn' => 'major.name',
            // ],
            'company' => [
                'type' => 'reference',
                'reference' => 'company.name',
                'displayColumn' => 'company.name',
            ],
            'requiredNumberOfUsers' => ['attr' => ['max' => AppConstants::SMALL_INTEGER_MAXIMUM_VALUE]],
            'briefDescription' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'fullDescription' => ['attr' => ['required' => true, 'maxlength' => AppConstants::TEXT_MAXIMUM_LENGTH, 'minlength' => AppConstants::STRINGS_MINIMUM_LENGTH]],
            'majors' => ['details-type' => 'multi-data-majors'],

        ];
    }

    /**
     * Get the company task validation rules
     *
     * @return array
     */
    public static function getFormValidationRules(): array {
        return [
            'title' => ['required', 'string', 'max:' . AppConstants::INDEXED_STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'startDate' => ['required', 'date', 'after_or_equal:today'],
            'endDate' => ['required', 'date', 'after_or_equal:startDate'],
            'price' => ['required', 'numeric', 'max:' . AppConstants::INTEGER_MAXIMUM_VALUE],
            // 'major_id' => ['required', 'exists:majors,id'],
            'city_id' => ['required', 'exists:cities,id'],
            'cityExistImportance' => ['required', 'in:' . implode(",", CompanyTask::CITY_EXIST_IMPORTANCE)],
//            'major' => ['nullable', 'string', 'max:' . AppConstants::STRINGS_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'price' => ['required', 'numeric', 'gte:50'],
            'pricePaymentType' => ['required', 'in:' . implode(",", CompanyTask::PRICE_PAYMENT_TYPE)],
            'type' => ['required', 'in:' . implode(",", CompanyTask::TYPE)],
            // 'workHoursCount' => ['required_if:type,==,part_time' . ((request()->all('workHoursCount') !== null) ? ", 'numeric', 'gte:1', 'lte:24'" : "")],
            'workHoursFrom' => ['required_if:type,==,part_time' . ((request()->all('workHoursFrom') !== null) ? ", 'date_format:H:i:s a'" : "")],
            'workHoursTo' => ['required_if:type,==,part_time' . ((request()->all('workHoursTo') !== null) ? ", 'date_format:H:i:s a', 'after:workHoursFrom'" : "")],
            'workDaysCount' => ['required_if:type,==,part_time' . ((request()->all('workDaysCount') !== null) ? ', in:' . implode(',', range(1, 5)) : '')],
            'location' => ['required_if:type,==,part_time' . ((request()->all('location') !== null) ? ', string' : '')],
            'requiredNumberOfUsers' => ['nullable', 'numeric', 'gte:1', 'max:' . AppConstants::SMALL_INTEGER_MAXIMUM_VALUE],
            'briefDescription' => ['required', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'fullDescription' => ['required', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
            'language' => ['required', 'array', 'min:1', 'in:' . implode(",", CompanyTask::LANGUAGE)],
//          'language.*' => ['required', 'string', 'in:' . implode(",", CompanyTask::LANGUAGE)],
            'willTakeCertificate' => ['required', 'in:' . implode(",", array_keys(\App\AppConstants::getYesNoOptions()))],
            'majors' => 'required|array|min:1',
            'majors.*' => 'exists:majors,id',
        ];
    }

    /**
     * Get the user finished tasks
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserFinishedCompanyTasks(User $user): Collection {
        return CompanyTask::where('company_tasks.status', CompanyTask::STATUS_FINISHED)
                        ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                        ->where('company_task_user_applies.user_id', $user->id)
                        ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED)
                        ->orderBy('company_task_user_applies.id' ,'asc')
                        ->limit(3)
                        ->get();
    }

    /**
     * Get the user finished tasks Load More
     *
     * @param User $user
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUserFinishedCompanyTasksLoadMore(User $user ,$id): Collection {
        return CompanyTask::where('company_tasks.status', CompanyTask::STATUS_FINISHED)
                        ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                        ->where('company_task_user_applies.company_id', $user->id)
                        ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED)
                        ->orderBy('company_task_user_applies.id' ,'asc')
                        ->where('company_task_user_applies.id' ,'>',$id )
                        ->get();
    }




//    public function getUserAssignedCompanyTasks(User $user, $queryWhereParameters): Collection {
    public function getUserAssignedCompanyTasks(User $user, $queryWhereParameters) {
        $q = CompanyTask::select('company_tasks.*','company_tasks.status')->
                where($queryWhereParameters)
                ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                ->where('company_task_user_applies.user_id', $user->id)
                ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED);

        $q->Where(
                function ($q) {
            $q->where('company_tasks.status', CompanyTask::STATUS_FINISHED)->orWhere('company_tasks.status', CompanyTask::STATUS_LIVE);
        });

        return $q->orderBy('company_tasks.status', 'desc')->orderBy('company_task_user_applies.updated_at', 'desc')->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);
    }

    public function getUserReviews(User $user) {
        $q = CompanyTask::where('company_tasks.status', CompanyTask::STATUS_FINISHED)
                ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                ->where('company_task_user_applies.user_id', $user->id)
                ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED);

        $q->Where(
                function ($q) {
            $q->whereNotNull('company_task_user_applies.rate')->orWhereNotNull('company_task_user_applies.review');
        });

        return $q;
    }

    /**
     * Get the company finished tasks
     *
     * @param Company $company
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFinishedCompanyTasks(Company $company): Collection {
        return CompanyTask::where('company_tasks.status', CompanyTask::STATUS_FINISHED)
                        ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                        ->where('company_task_user_applies.company_id', $company->id)
                        ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED)
                        ->orderBy('company_task_user_applies.id' ,'asc')
                        ->limit(3)
                        ->get();
    }

    public function getFinishedCompanyTasksLoadMore(Company $company ,$id): Collection {
        return CompanyTask::where('company_tasks.status', CompanyTask::STATUS_FINISHED)
                        ->join('company_task_user_applies', 'company_tasks.id', '=', 'company_task_user_applies.company_task_id')
                        ->where('company_task_user_applies.company_id', $company->id)
                        ->where('company_task_user_applies.status', CompanyTaskUserApply::STATUS_ASSIGNED)
                        ->orderBy('company_task_user_applies.id' ,'asc')
                        ->where('company_task_user_applies.id' ,'>',$id )
                        ->get();
    }
    /**
     * Check if company can accept user apply on it is task
     *
     * @param CompanyTaskUserApply $companyTaskUserApply
     * @param CompanyTask $companyTask
     * @param Company $company
     * @return bool
     */
    public function canCompanyAcceptUserApply(CompanyTaskUserApply $companyTaskUserApply, CompanyTask $companyTask, Company $company): bool {
        if (!$this->canCompanyViewTask($companyTask, $company) || $companyTaskUserApply->company_task_id !== $companyTask->id || $companyTask->status === CompanyTask::STATUS_FINISHED || $companyTaskUserApply->status !== CompanyTaskUserApply::STATUS_APPLIED || (!is_null($companyTask->requiredNumberOfUsers) && $companyTask->requiredNumberOfUsers <= $companyTask->hiredUsersCount)) {
            return false;
        }
        return true;
    }

    /**
     * Check if company can reject user apply on it is task
     *
     * @param CompanyTaskUserApply $companyTaskUserApply
     * @param CompanyTask $companyTask
     * @param Company $company
     * @return bool
     */
    public function canCompanyRejectUserApply(CompanyTaskUserApply $companyTaskUserApply, CompanyTask $companyTask, Company $company): bool {
        if (!$this->canCompanyViewTask($companyTask, $company) || $companyTaskUserApply->company_task_id !== $companyTask->id || $companyTask->status === CompanyTask::STATUS_FINISHED || $companyTaskUserApply->status !== CompanyTaskUserApply::STATUS_APPLIED) {
            return false;
        }
        return true;
    }

    /**
     * Check if company can view task
     *
     * @param CompanyTask $companyTask
     * @param Company $company
     * @return bool
     */
    public function canCompanyViewTask(CompanyTask $companyTask, Company $company): bool {
        if ($companyTask->suspendedByAdmin || $companyTask->company_id !== $company->id) {
            return false;
        }
        return true;
    }

    /**
     * Check if company can view task
     *
     * @param CompanyTask $companyTask
     * @param Company $company
     * @return bool
     */
    public function canCompanyFinishTask(CompanyTask $companyTask, Company $company): bool {
        if ($companyTask->suspendedByAdmin || $companyTask->company_id !== $company->id || $companyTask->status !== CompanyTask::STATUS_LIVE) {
            return false;
        }
        return true;
    }

    public function canCompanyReviewUserForTask(CompanyTask $companyTask, Company $company, CompanyTaskUserApply $companyTaskUserApply): bool {

//        dd($companyTaskUserApply);

        if ($companyTask->suspendedByAdmin || $companyTask->company_id !== $company->id || $companyTask->status !== CompanyTask::STATUS_FINISHED || $companyTaskUserApply->rate !== null || $companyTaskUserApply->review !== null) {
            return false;
        }
        return true;
    }

    /**
     * Apply the user apply on the task
     *
     * @param Company $company
     * @param CompanyTask $companyTask
     * @param CompanyTaskUserApply $companyTaskUserApply
     * @return bool
     */
    public function acceptApplyOnTask(Company $company, CompanyTask $companyTask, CompanyTaskUserApply $companyTaskUserApply): bool {
        try {
            DB::transaction(function () use ($companyTask, $companyTaskUserApply) {
                if ($companyTask->status !== CompanyTask::STATUS_LIVE) {
                    $companyTask->status = CompanyTask::STATUS_LIVE;
                    $companyTask->save();
                }
                $companyTask->increment('hiredUsersCount');
                $companyTaskUserApply->status = CompanyTaskUserApply::STATUS_ASSIGNED;
                $companyTaskUserApply->save();
            });
        } catch (\Exception $e) {
            return false;
        }
        $companyImage = null;
        if ($company->logo) {
            $companyImage = asset(Storage::disk('public')->url($company->logo));
        }
        $companyTaskUserApply->user->notify(new AcceptedCompanyTaskUserApply(
                $company->name, route('user.tasks.show', ['companyTask' => $companyTask]), $companyTask->title, $companyImage
        ));
        return true;
    }

    /**
     * Reject the user apply on the task
     *
     * @param CompanyTaskUserApply $companyTaskUserApply
     * @return bool
     */
    public function rejectApplyOnTask(Company $company, CompanyTask $companyTask, CompanyTaskUserApply $companyTaskUserApply): bool {
        try {
            DB::transaction(function () use ($companyTaskUserApply) {
                $companyTaskUserApply->companyTask->decrement('appliedUsersCount');
                $companyTaskUserApply->status = CompanyTaskUserApply::STATUS_REJECTED;
                $companyTaskUserApply->save();
            });

            $companyImage = null;
            if ($company->logo) {
                $companyImage = asset(Storage::disk('public')->url($company->logo));
            }
            $companyTaskUserApply->user->notify(new RejectedCompanyTaskUserApply(
                    $company->name, route('user.tasks.show', ['companyTask' => $companyTask]), $companyTask->title, $companyImage
            ));
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Check if user applied on task
     *
     * @param CompanyTask $companyTask
     * @param User $user
     * @return bool
     */
    public function canUserApplyOnTask(CompanyTask $companyTask, User $user): bool {
        if (!$companyTask->suspendedByAdmin) {
            if ($companyTask->status !== CompanyTask::STATUS_FINISHED) {
                if (!$this->isUserApplied($companyTask, $user)) {
                    if ($companyTask->status === CompanyTask::STATUS_NEW) {
                        return true;
                    } else {
                        if (is_null($companyTask->requiredNumberOfUsers) || $companyTask->requiredNumberOfUsers > $companyTask->hiredUsersCount) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    public function isUserAppliedAndRejected(CompanyTask $companyTask, User $user): bool {
        if (!$companyTask->suspendedByAdmin) {
            return CompanyTaskUserApply::where('user_id', $user->id)
                            ->where('company_task_id', $companyTask->id)
                            ->where('status', CompanyTaskUserApply::STATUS_REJECTED)
                            ->count() > 0 ? true : false;
        }
        return false;
    }

    public function isUserAppliedAndAssigned(CompanyTask $companyTask, User $user): bool {
        if (!$companyTask->suspendedByAdmin) {
            return CompanyTaskUserApply::where('user_id', $user->id)
                            ->where('company_task_id', $companyTask->id)
                            ->where('status', CompanyTaskUserApply::STATUS_ASSIGNED)
                            ->count() > 0 ? true : false;
        }
        return false;
    }



    /**
     * Check if user applied on task
     *
     * @param CompanyTask $companyTask
     * @param User $user
     * @return bool
     */
    public function isUserApplied(CompanyTask $companyTask, User $user): bool {
        return CompanyTaskUserApply::where('user_id', $user->id)
                        ->where('company_task_id', $companyTask->id)
                        ->count() > 0 ? true : false;
    }

    /**
     * Apply for the task
     *
     * @param CompanyTask $companyTask
     * @param User $user
     * @return bool
     */
    public function userApplyOnTask(CompanyTask $companyTask, User $user): bool {
        try {
            DB::transaction(function () use ($companyTask, $user) {
                CompanyTaskUserApply::create([
                    'company_id' => $companyTask->company_id,
                    'company_task_id' => $companyTask->id,
                    'user_id' => $user->id,
                    'status' => CompanyTaskUserApply::STATUS_APPLIED,
                ]);
                $companyTask->increment('appliedUsersCount');
            });
        } catch (\Exception $e) {
            return false;
        }
        $appliedUserImage = null;
        if ($user->personalPhoto) {
            $appliedUserImage = asset(Storage::disk('public')->url($user->personalPhoto));
        }
        $companyTask->company->notify(new UserAppliedOnCompanyTask(
                $user->firstName . ' ' . $user->lastName, route('company.tasks.show', ['companyTask' => $companyTask]), $companyTask->title, $appliedUserImage
        ));
        return true;
    }

    /**
     * Finish the task
     *
     * @param CompanyTask $companyTask
     * @return bool
     */
    public function finish(CompanyTask $companyTask): bool {
        try {
            $companyTask->status = CompanyTask::STATUS_FINISHED;
            $companyTask->save();
        } catch (\Exception $e) {
            return false;
        }
        $company = $companyTask->company;
        $companyImage = null;
        if ($company->logo) {
            $companyImage = asset(Storage::disk('public')->url($company->logo));
        }
        $assignedUsersOnTask = CompanyTaskUserApply::where('status', CompanyTaskUserApply::STATUS_ASSIGNED)
                ->where('company_task_id', $companyTask->id)
                ->with('user')
                ->get();
        foreach ($assignedUsersOnTask as $assignedUserOnTask) {
            $assignedUserOnTask->user->notify(new CompanyTaskFinished(
                    $company->name, route('user.tasks.show', ['companyTask' => $companyTask]), $companyTask->title, $companyImage
            ));
        }
        return true;
    }

    public static function Status() {
        return [
            [
                'label' => __('companytask.' . CompanyTask::STATUS_NEW),
                'value' => CompanyTask::STATUS_NEW,
            ],
            [
                'label' => __('companytask.' . CompanyTask::STATUS_LIVE),
                'value' => CompanyTask::STATUS_LIVE,
            ],
            [
                'label' => __('companytask.' . CompanyTask::STATUS_FINISHED),
                'value' => CompanyTask::STATUS_FINISHED,
            ],
        ];
    }

//    public function review(CompanyTaskUserApply $companyTaskUserApply): bool {
//        try {
//            $companyTask->status = CompanyTask::STATUS_FINISHED;
//            $companyTask->save();
//        } catch (\Exception $e) {
//            return false;
//        }
//        $company = $companyTask->company;
//        $companyImage = null;
//        if ($company->logo) {
//            $companyImage = asset(Storage::disk('public')->url($company->logo));
//        }
//        $assignedUsersOnTask = CompanyTaskUserApply::where('status', CompanyTaskUserApply::STATUS_ASSIGNED)
//                ->where('company_task_id', $companyTask->id)
//                ->with('user')
//                ->get();
//        foreach ($assignedUsersOnTask as $assignedUserOnTask) {
//            $assignedUserOnTask->user->notify(new CompanyTaskFinished(
//                    $company->name, route('user.tasks.show', ['companyTask' => $companyTask]), $companyTask->title, $companyImage
//            ));
//        }
//        return true;
//    }
}
