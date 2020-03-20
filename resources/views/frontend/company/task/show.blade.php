@extends('frontend.company.layouts.app')

@section('subtitle'){{ __('companytask.Tasks') }} | {{ $task->title }}@endsection

@section('content')
<div class="inner-pages col-xs-12">
    <div class="profile-wrap applicants-wrap col-xs-12">
        <div class="container">
            <div class="row justify-content-center">
                <div class="prof-box  col-xs-10">
                    <div class="task-wrap">
                        @if (session('errorMessage'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('errorMessage') }}
                        </div>
                        @endif

                        @if (session('successMessage'))
                        <div class="alert alert-success" role="alert">
                            {{ session('successMessage') }}
                        </div>
                        @endif
                        <div class="box-item">
                            <div class="task-head mb-0">
                                <div class="it-body">
                                    <h4>{{ $task->title }}</h4>
                                    <span class="word-wrap">{{ $task->briefDescription }}</span>
                                </div>
                                <div>
                                </div>
                            </div>
                        </div>
                        <div class="box-item">
                            <div class="task-desc">
                            @if($task->type)
                            <div class="space-between border-bottom-gray">
                                <span>
                                <i class="fa fa-shopping-bag"></i>
                                    {{__('companytask.workKind')}}
                                </span>
                                <span class="text-left">
                                {{__('companytask.'.optional($task)->type)}}
                                </span>
                            </div>
                            @endif
                                <div>
                                    <h3>{{ __('companytask.fullDescription') }}</h3>
                                    <span class="word-wrap">{{ $task->fullDescription }}</span>
                                </div>
                                <div class="languages">
                                    <h3>{{ __('companytask.language') }}</h3>
                                    @php $arrLang= json_decode($task->language, true)@endphp

                                   <div class="it-body container">
                                   <div class="row">
                                   @foreach($arrLang as $Lang)
                                    <!-- <span>{{ (count($arrLang)>1)?implode(",",$arrLang): $arrLang[0]}}</span> -->
                                    <span class="m-half">{{(count($arrLang)>0)?__($Lang):""}}</span>
                                    @endforeach
                                   </div>
                                   </div>
                                </div>
                                <div class="space-between border-bottom-gray">
                                    <span>
                                        <i class="fa fa-user"></i>
                                        {{ __('companytask.willTakeCertificate') }}
                                    </span>
                                    <span class="text-left">{{ ($task->willTakeCertificate == 1)?__('yes'):__('no')}}</span>
                                </div>

                            </div>
                        </div>

                        <div class="box-item">
                            <div class="row">
                            @if( $task->startDate)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-calendar"></i>
                                            {{ __('companytask.startDate') }}
                                        </span>
                                        <span class="col-xs-5">{{ $task->startDate->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                                @endif
                            @if($task->endDate)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-calendar"></i>
                                            {{ __('companytask.endDate') }}
                                        </span>
                                        <span class="col-xs-5">{{ $task->endDate->format('Y-m-d')}}</span>
                                    </div>

                                </div>
                                @endif
                            @if($task->price)
                                <div class="col-12  border-bottom-gray prize mb-1">
                                    <div class="row pt-1 ">
                                        <span class="col-xs-7">
                                            <i class="fa fa-trophy fa-lg"></i>
                                            {{ __('companytask.price') }}
                                        </span>
                                        <span class="col-xs-5 text-left">{{ $task->price }}
                                            <b>{{ __('companytask.SAR') }}</b></span>
                                    </div>

                                </div>
                                @endif
                            @if(optional($task)->workHoursFrom)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-clock-o"></i>
                                            {{__('companytask.workHoursFrom')}}
                                        </span>
                                        <span class="col-xs-5">{{ optional($task)->workHoursFrom}}</span>
                                    </div>
                                </div>
                                @endif
                            @if(optional($task)->workHoursTo)
                                <div class=" col-lg-6 ">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-clock-o"></i>
                                            {{__('companytask.workHoursTo')}}
                                        </span>
                                        <span class="col-xs-5">{{ optional($task)->workHoursTo}}</span>
                                    </div>
                                </div>
                                @endif
                                @if($task->requiredNumberOfUsers)
                            <div class="col-lg-6 ">
                                <div class="row mb-1 border-bottom-gray">
                                    <span class="col-xs-7">
                                    <i class="fa fa-user"></i>
                                    {{ __('companytask.requiredNumberOfUsers') }}
                                        </span>
                                    <span class="col-xs-5 text-left">
                                    {{ $task->requiredNumberOfUsers}}
                                    </span>
                                </div>

                            </div>
                             @endif
                            @if(optional($task)->workDaysCount)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-clock-o"></i>
                                            {{__('companytask.workDaysCount')}}
                                        </span>
                                        <span class="col-xs-5">{{ optional($task)->workDaysCount}}</span>
                                    </div>

                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="box-item majors">
                            <div class="it-head">
                                <h3>{{ __('companytask.fields') }}</h3>
                            </div>
                            <div class="it-body container">
                           <div class="row">
                           @foreach($majors as $major)
                            <span class="m-half">{{(count($majors)>1)?$major:__('no_found_majors')}}</span>
                            @endforeach
                           </div>
                            </div>
                        </div>


                        <div class="box-item">
                            <div class="it-head col-12">
                                <h3>{{ __('location') }}</h3>
                            </div>
                            <div class="space-between col-md-6 border-bottom-gray">
                                <span>
                                    <span>{{optional($task)->city->name}}</span>
                                    <i class="fa fa-map-marker fa-lg"></i>
                                    <!-- {{ __('companytask.City') }}
                                </span>
                                <span> -->
                                </span>
                            </div>
                            <div class="space-between col-md-6 border-bottom-gray">
                                <span>
                                    <span> {{ $task->location}}</span>
                                    <i class="fa fa-map-marker fa-lg"></i>
                                    <!-- {{ __('companytask.location') }}
                                </span>
                                <span> -->
                                    <!-- {{ $task->location}} -->
                                </span>
                            </div>
                            <div class="space-between col-12 border-bottom-gray">
                                <span>
                                    <i class="fa fa-map-marker fa-lg"></i>
                                    {{ __('companytask.cityExistImportance') }}
                                </span>
                                <span>{{ ($task->cityExistImportance == "important")?__('companytask.important'):__('companytask.not_important')}}</span>
                            </div>

                        </div>



                        @if ($canFinishTheTask)
                        <div class="text-center">
                            <a href="#" class="btn btn-sm"
                                onclick="event.preventDefault();document.getElementById('task-finish-{{ $task->id }}').submit();">{{ __('companytask.Finish') }}</a>
                            <form id="task-finish-{{ $task->id }}"
                                action="{{ route('company.tasks.finish', ['companyTask' => $task]) }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </div>
                        @endif

                    </div>
                </div>
                <div class="prof-sidebar col-xs-10">
                    <div class="row">
                        @foreach($applicantsRequests as $applicantRequest)
                        <div class=" col-lg-4 col-md-6 h-50 mt-3">
                            <div class="inner p-0 t-100 ">
                                @if($applicantRequest->user->user_personal_photo)
                                <div class="prof-pic">
                                    <img src="{{ $applicantRequest->user->user_personal_photo }}"
                                        alt="{{ $applicantRequest->user->firstName . ' ' . $applicantRequest->user->lastName }}">
                                </div>
                                @endif
                                <div class="prof-info">
                                    <h3 class="mt-1">
                                        {{ $applicantRequest->user->firstName . ' ' . $applicantRequest->user->lastName }}
                                    </h3>
                                    <span
                                        class="profile-info-major">{{ optional($applicantRequest->user->major)->name }}</span>
                                </div>
                                <div class="prof-rate profile-rate-re-design mb-0 row">

                                    @if ($applicantRequest->status ===
                                    \App\Models\CompanyTaskUserApply::STATUS_ASSIGNED)
                                    <span class="d-inline col-6">
                                        <i class="fa fa-check purple"></i> {{ __('companytask.Hired') }}
                                    </span>
                                    <span class="d-inline col-6">
                                        <i class="fa fa-star purple"></i>
                                        {{ $applicantRequest->user->reviews_count }}
                                    </span>
                                    @else
                                    <span class="d-inline col-12 my-1">
                                        <i class="fa fa-star purple"></i>
                                        {{ $applicantRequest->user->reviews_count }}
                                    </span>
                                    <div class="col-12 mb-1">
                                        <a href="#" class="btn accBtn"
                                            onclick="event.preventDefault();document.getElementById('applicants-accept-{{ $applicantRequest->id }}').submit();">{{ __('companytask.Accept') }}</a>
                                    </div>
                                    <form id="applicants-accept-{{ $applicantRequest->id }}"
                                        action="{{ route('company.tasks.applicants.accept', ['companyTask' => $task, 'companyTaskUserApply' => $applicantRequest]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    <div class="col-12">
                                        <a href="#" class="btn btn-border refBtn"
                                            onclick="event.preventDefault();document.getElementById('applicants-reject-{{ $applicantRequest->id }}').submit();">{{ __('companytask.Reject') }}</a>
                                    </div>
                                    <form id="applicants-reject-{{ $applicantRequest->id }}"
                                        action="{{ route('company.tasks.applicants.reject', ['companyTask' => $task, 'companyTaskUserApply' => $applicantRequest]) }}"
                                        method="POST" style="display: none;">
                                        @csrf
                                    </form>

                                    @endif


                                </div>
                                <div class="prof-edit p-1">

                                    <a href="{{ route('company.users.show', ['user' => $applicantRequest->user]) }}"
                                        class="btn btn-border">{{ __('Profile') }}</a>
                                </div>
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection
