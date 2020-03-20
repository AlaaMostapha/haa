<?php

namespace App\Http\Controllers\Frontend\Company;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\AppConstants;
use App\Models\CompanyTask;
use App\Models\CompanyTaskUserApply;
use App\Services\CompanyTaskService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyTaskController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $queryWhereParameters = [
            ['company_id', auth()->user()->id],
            ['suspendedByAdmin', false],
        ];

        $title = trim(request('title'));
        if ($title) {
            $queryWhereParameters[] = ['title', 'like', '%'.$title . '%'];
        }
        $queryWhereParametersForCountsCalculation = $queryWhereParameters;
        $status = trim(request('status'));
        if ($status) {
            $queryWhereParameters[] = ['status', '=', $status];
        }
        $tasks = CompanyTask::where($queryWhereParameters);

        if(request()->has('major')){
            // dd(request()->input('major'));
            // $majors_id = implode("," ,request()->input('major'));
            $majors_id = request()->input('major');
            $tasks = $tasks->whereHas('majors' ,function($query)use($majors_id){
                $query->whereIn('major_id',$majors_id);
            });
        }
        if (request()->has('priceRange')) {
            // dd(request()->input('priceRange'));
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



        
        $tasks = $tasks->paginate(AppConstants::LIST_ITEMS_COUNT_PER_PAGE);

        return view('frontend.company.task.index', [
            'tasks' => $tasks,
            'allTasksCount' => CompanyTask::where($queryWhereParametersForCountsCalculation)->count(),
            'liveTasksCount' => CompanyTask::where($queryWhereParametersForCountsCalculation)
                    ->where('status', CompanyTask::STATUS_LIVE)->count(),
            'finishedTasksCount' => CompanyTask::where($queryWhereParametersForCountsCalculation)
                    ->where('status', CompanyTask::STATUS_FINISHED)->count(),
            'unassignedTasksCount' => CompanyTask::where($queryWhereParametersForCountsCalculation)
                    ->where('status', CompanyTask::STATUS_NEW)->count(),
        ]);
    }

    /**
     * Get the required validation rules for creating/editing any object
     *
     * @param CompanyTask $modelObject
     * @return array
     */
    public function getFormRules(CompanyTask $modelObject): array {
        return CompanyTaskService::getFormValidationRules();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $majors = \App\Models\Major::all();
        return view('frontend.company.task.form', compact('majors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store() {
        $modelObject = new CompanyTask();
        $rules = $this->getFormRules($modelObject);
        $data = request(array_keys($rules));

        $validator = validator()->make($data, $rules);

        if ($validator->fails()) {
            session()->flash('update', true);
            return redirect()->route('company.tasks.create')->withErrors($validator)->withInput();
        } else {
            if (isset($data['willTakeCertificate']) && $data['willTakeCertificate'] === "no") {
                $data['willTakeCertificate'] = 0;
            } elseif (isset($data['willTakeCertificate']) && $data['willTakeCertificate'] === "yes") {
                $data['willTakeCertificate'] = 1;
            }

            if (isset($data['language'])) {
                $data['language'] = json_encode($data['language']);
            }


            $data['company_id'] = auth()->user()->id;
            $modelObject->fill($data)->save();
            $majors = request()->get('majors');
            $modelObject->majors()->sync($majors);
            session()->flash('successMessage', __('Done successfully'));
            return redirect()->route('company.tasks.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function show(CompanyTask $companyTask, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        if (!$companyTaskService->canCompanyViewTask($companyTask, $company)) {
            throw new NotFoundHttpException();
        }
        $showApplicantsStatuses = [CompanyTaskUserApply::STATUS_ASSIGNED];
        if (is_null($companyTask->requiredNumberOfUsers) || $companyTask->requiredNumberOfUsers > $companyTask->hiredUsersCount) {
            $showApplicantsStatuses [] = CompanyTaskUserApply::STATUS_APPLIED;
        }
        $applicantsRequests = CompanyTaskUserApply::where('company_task_id', $companyTask->id)
                ->whereIn('status', $showApplicantsStatuses)
                ->with('user')
                ->get();
        $canFinishTheTask = $companyTaskService->canCompanyFinishTask($companyTask, $company);
        $majors= optional($companyTask->majors)->map(function($major){
            return $major->name;        
        })->toArray();        
        return view('frontend.company.task.show', [
            'task' => $companyTask,
            'applicantsRequests' => $applicantsRequests,
            'canFinishTheTask' => $canFinishTheTask,
            'majors' => $majors
        ]);
    }

    /**
     * Accept user applied on the task
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Models\CompanyTaskUserApply  $companyTaskUserApply
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function acceptUserRequest(CompanyTask $companyTask, CompanyTaskUserApply $companyTaskUserApply, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        if (!$companyTaskService->canCompanyAcceptUserApply($companyTaskUserApply, $companyTask, $company)) {
            session()->flash('errorMessage', __('companytask.You can not accept the apply on the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }
        $operationSucceeded = $companyTaskService->acceptApplyOnTask($company, $companyTask, $companyTaskUserApply);
        if (!$operationSucceeded) {
            session()->flash('errorMessage', __('companytask.You can not accept the apply on the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }
        session()->flash('successMessage', __('Done successfully'));
        return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
    }

    /**
     * Reject user applied on the task
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Models\CompanyTaskUserApply  $companyTaskUserApply
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function rejectUserRequest(CompanyTask $companyTask, CompanyTaskUserApply $companyTaskUserApply, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        if (!$companyTaskService->canCompanyRejectUserApply($companyTaskUserApply, $companyTask, $company)) {
            session()->flash('errorMessage', __('companytask.You can not reject the apply on the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }
        $operationSucceeded = $companyTaskService->rejectApplyOnTask($company, $companyTask, $companyTaskUserApply);
        if (!$operationSucceeded) {
            session()->flash('errorMessage', __('companytask.You can not reject the apply on the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }
        session()->flash('successMessage', __('Done successfully'));
        return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
    }

    /**
     * Finish the task
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @param  \App\Services\CompanyTaskService  $companyTaskService
     * @return \Illuminate\Http\Response
     */
    public function finish(CompanyTask $companyTask, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        if (!$companyTaskService->canCompanyFinishTask($companyTask, $company)) {
            session()->flash('errorMessage', __('companytask.You can not finish the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }

        $operationSucceeded = $companyTaskService->finish($companyTask);
        if (!$operationSucceeded) {
            session()->flash('errorMessage', __('companytask.You can not finish the task'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }

        $companyTaskUserApply = CompanyTaskUserApply::where(['company_task_id' => $companyTask->id, 'status' => CompanyTaskUserApply::STATUS_ASSIGNED])->first();
        session()->flash('successMessage', __('Done successfully'));
        return redirect()->route('company.tasks.review', ['companyTaskUserApply' => $companyTaskUserApply]);
//        return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CompanyTask  $companyTask
     * @return \Illuminate\Http\Response
     */
    public function edit(CompanyTask $companyTask) {
        //
    }

    public function showDetailsCompany(CompanyTaskService $companyTaskService,$companyId)
    {
        $companyProfile = Company::findOrFail($companyId);
        $companyFinishedCompanyTasks = $companyTaskService->getFinishedCompanyTasks($companyProfile);

        return view('frontend.user.task.company_profile',[
            'companyProfile' =>$companyProfile ,
            'companyFinishedCompanyTasks'=>$companyFinishedCompanyTasks]);
    }


    public function load_more_profile_details($companyId , CompanyTaskService $companyTaskService)
    {

        // $companyProfile = Auth::guard('company')->user();
        $companyProfile = Company::findOrFail($companyId);
        if (request()->ajax()) {
                if (request()->has('id')) {
                    $companyFinishedCompanyTasks = $companyTaskService->getFinishedCompanyTasksLoadMore($companyProfile ,request()->id);
                    return view('frontend.company.profile.finished_company_tasks' , [
                        'companyFinishedCompanyTasks' => $companyFinishedCompanyTasks
                    ]);
                }

        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CompanyTask  $companyTask
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CompanyTask $companyTask) {
        //
    }

    public function review(CompanyTaskUserApply $companyTaskUserApply, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        $companyTask = CompanyTask::find($companyTaskUserApply->companyTask->id);
        if (!$companyTaskService->canCompanyReviewUserForTask($companyTask, $company, $companyTaskUserApply)) {
            session()->flash('errorMessage', __('companytask.You can not review this user'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }

        return view('frontend.company.review.form', ['companyTaskUserApply' => $companyTaskUserApply]);
    }

    public function submitReview(CompanyTaskUserApply $companyTaskUserApply, CompanyTaskService $companyTaskService) {
        $company = auth()->user();
        $companyTask = CompanyTask::find($companyTaskUserApply->companyTask->id);
        if (!$companyTaskService->canCompanyReviewUserForTask($companyTask, $company, $companyTaskUserApply)) {
            session()->flash('errorMessage', __('companytask.You can not review this user'));
            return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
        }

        $rules = [
            'rate' => ['required', 'array', 'min:1', 'in:' . implode(',', range(1, 5))],
//          'rate.*' => ['required', 'integer', 'in:' . implode(",", CompanyTask::LANGUAGE)],
            'review' => ['required', 'string', 'max:' . AppConstants::TEXT_MAXIMUM_LENGTH, 'min:' . AppConstants::STRINGS_MINIMUM_LENGTH],
        ];

        $data = request(array_keys($rules));
        $validator = validator()->make($data, $rules);
        if ($validator->fails()) {
            session()->flash('update', true);
            return redirect()->route('company.tasks.review', ['companyTaskUserApply' => $companyTaskUserApply])->withErrors($validator)->withInput();
        } else {
            $companyTaskUserApply->rate = $data['rate'][0];
            $companyTaskUserApply->review = $data['review'];
            if (!$companyTaskUserApply->save()) {
                session()->flash('errorMessage', __('companytask.You can not review this user'));
                return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
            }
        }

        $avg_rate = (float) CompanyTaskUserApply::whereUserId($companyTaskUserApply->user->id)->avg('rate');
//        $review->company()->update(['avg_rate' => floor($avg * 2) / 2]);

        DB::update('update users set reviews_count = reviews_count + 1 , avg_rate = ? where id = ?', [$avg_rate, $companyTaskUserApply->user->id]);
//        DB::update('update users set reviews_count = reviews_count + 1 , avg_rate = ? where id = ?', [floor($avg * 2) / 2, $companyTaskUserApply->user->id]);

        session()->flash('successMessage', __('Done successfully'));
        return redirect()->route('company.tasks.show', ['companyTask' => $companyTask]);
    }

}
