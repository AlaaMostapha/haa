<?php

namespace App\Http\Controllers\Frontend\User;

use App\AppConstants;
use App\Models\CompanyTask;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\CompanyTaskService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyTaskController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $queryWhereParameters = [
            ['status', CompanyTask::STATUS_NEW],
            ['suspendedByAdmin', false],
        ];

        $title = trim(request('title'));
        if ($title) {
            $queryWhereParameters[] = ['title', 'like', '%'. $title . '%'];
        }
        $tasks = CompanyTask::where($queryWhereParameters)
        ->with('company');

        if(request()->has('major')){
            // $majors_id = implode("," ,request()->input('major'));
            $majors_id = request()->input('major');
            $tasks = $tasks->whereHas('majors' ,function($query)use($majors_id){
                $query->whereIn('major_id',$majors_id);
            });

        }
        // if (request()->has('priceRange')) {
        //     $isPriceRangeArray = is_array(request()->input('priceRange'));
        //     if($isPriceRangeArray){
        //         foreach (request()->input('priceRange') as  $range) {
        //             $rangeArray = explode("," ,$range);
        //             $tasks =  $tasks->whereBetween('price' ,$rangeArray);
        //         }
        //     }
        // }

        if (request()->has('priceRange')) {
            $isPriceRangeArray = is_array(request()->input('priceRange'));

            if($isPriceRangeArray){
                $priceRangeArray = request()->input('priceRange');
                if (count($priceRangeArray)>1) {
                    $rageStart = explode("," ,$priceRangeArray[0])[0];
                    $rageFinal = explode("," ,$priceRangeArray[count($priceRangeArray)-1])[1];
                    $task = $tasks->whereBetween('price' ,[$rageStart , $rageFinal]);
                }else{
                        $rangeArray = explode("," ,request()->input('priceRange')[0]);
                        $tasks =  $tasks->whereBetween('price' ,$rangeArray);
                }
            }
        }
        if (request()->has('durationRange')) {
            $isDurationRangeArray = is_array(request()->input('durationRange'));
            if($isDurationRangeArray){
                $toDay = \Carbon\Carbon::today();
                // dd(request()->input('durationRange'));
                if (in_array('year' ,request()->input('durationRange'))){
                    // dd("... year...");
                    $todayMinusOneYearAgo = \Carbon\Carbon::today()->subYear();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneYearAgo ,$toDay]);
                }else if (in_array('month' ,request()->input('durationRange'))){
                    // dd("... month ...");
                    $todayMinusOneMonthAgo = \Carbon\Carbon::today()->subMonth();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneMonthAgo ,$toDay]);
                }else {
                    // dd("....else....");
                    $todayMinusOneWeekAgo = \Carbon\Carbon::today()->subWeek();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneWeekAgo ,$toDay]);
                }
            }
        }


        $tasks = $tasks->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);


        return view('frontend.user.task.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function myTasks(CompanyTaskService $companyTaskService) {
        $queryWhereParameters = [
//            ['status', CompanyTask::STATUS_LIVE],
//            ['status', CompanyTask::STATUS_FINISHED],
            ['suspendedByAdmin', false],
        ];

        $title = trim(request('title'));
        if ($title) {
            $queryWhereParameters[] = ['title', 'like', $title . '%'];
        }
//        $tasks = CompanyTask::where($queryWhereParameters)
//                ->with('company')
//                ->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);

        $user = auth()->user();
        $tasks = $companyTaskService->getUserAssignedCompanyTasks($user, $queryWhereParameters);

//        dd($tasks);

        return view('frontend.user.task.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyTask $companyTask, CompanyTaskService $companyTaskService) {
//        abort_if($companyTask->suspendedByAdmin, 400 , __('Sorry, This task has been suspened by admin'));
        if ($companyTask->suspendedByAdmin) {
            throw new NotFoundHttpException();
        }

        $user = auth()->user();
        return view('frontend.user.task.show', [
            'task' => $companyTask,
            'showApplyLink' => $companyTaskService->canUserApplyOnTask($companyTask, $user),
            'isUserApplied' => $companyTaskService->isUserApplied($companyTask, $user),
            'isUserAppliedAndRejected' => $companyTaskService->isUserAppliedAndRejected($companyTask, $user),
            'isUserAppliedAndAssigned' => $companyTaskService->isUserAppliedAndAssigned($companyTask, $user),

        ]);
    }

    /**
     * Apply on the task
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function apply(CompanyTask $companyTask, CompanyTaskService $companyTaskService) {
        $user = auth()->user();
        if (!$companyTaskService->canUserApplyOnTask($companyTask, $user)) {
            session()->flash('errorMessage', __('companytask.You already applied on the task'));
            return redirect()->route('user.tasks.show', ['companyTask' => $companyTask]);
        }
        $operationSucceeded = $companyTaskService->userApplyOnTask($companyTask, $user);
        if (!$operationSucceeded) {
            session()->flash('errorMessage', __('companytask.You already applied on the task'));
            return redirect()->route('user.tasks.show', ['companyTask' => $companyTask]);
        }
        session()->flash('successMessage', __('Done successfully'));
        return redirect()->route('user.tasks.show', ['companyTask' => $companyTask]);
    }

    public function showAllTasks()
    {
        $queryWhereParameters = [
            ['status', CompanyTask::STATUS_NEW],
            ['suspendedByAdmin', false],
        ];

        $title = trim(request('title'));
        if ($title) {
            $queryWhereParameters[] = ['title', 'like', $title . '%'];
        }
        $tasks = CompanyTask::where($queryWhereParameters)
        ->with('company');

        if(request()->has('major')){
            // $majors_id = implode("," ,request()->input('major'));
            $majors_id = request()->input('major');
            $tasks = $tasks->whereHas('majors' ,function($query)use($majors_id){
                $query->whereIn('major_id',$majors_id);
            });

        }
        if (request()->has('priceRange')) {
            $isPriceRangeArray = is_array(request()->input('priceRange'));
            if($isPriceRangeArray){
                foreach (request()->input('priceRange') as  $range) {
                    $rangeArray = explode("," ,$range);
                    $tasks =  $tasks->whereBetween('price' ,$rangeArray);
                }
            }
        }
        if (request()->has('durationRange')) {
            $isDurationRangeArray = is_array(request()->input('durationRange'));
            if($isDurationRangeArray){
                $toDay = \Carbon\Carbon::today();
                // dd(request()->input('durationRange'));
                if (in_array('year' ,request()->input('durationRange'))){
                    // dd("... year...");
                    $todayMinusOneYearAgo = \Carbon\Carbon::today()->subYear();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneYearAgo ,$toDay]);
                }else if (in_array('month' ,request()->input('durationRange'))){
                    // dd("... month ...");
                    $todayMinusOneMonthAgo = \Carbon\Carbon::today()->subMonth();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneMonthAgo ,$toDay]);
                }else {
                    // dd("....else....");
                    $todayMinusOneWeekAgo = \Carbon\Carbon::today()->subWeek();
                    $tasks = $tasks->whereBetween('created_at' , [$todayMinusOneWeekAgo ,$toDay]);
                }
            }
        }


        $tasks = $tasks->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);
        return view('frontend.user.task.all-tasks', [
            'tasks' => $tasks,
        ]);
    }

    public function showDetailsTask(CompanyTask $companyTask , CompanyTaskService $companyTaskService)
    {
        // dd($companyTask , $companyTaskService);
        if ($companyTask->suspendedByAdmin) {
            throw new NotFoundHttpException();
        }
        // $user = optional(auth()->user());
        return view('frontend.user.task.task-detail', [
            'task' => $companyTask
            // 'showApplyLink' => $companyTaskService->canUserApplyOnTask($companyTask, $user),
            // 'isUserApplied' => $companyTaskService->isUserApplied($companyTask, $user),
            // 'isUserAppliedAndRejected' => $companyTaskService->isUserAppliedAndRejected($companyTask, $user),
        ]);
    }
}


