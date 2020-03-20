@extends('frontend.user.layouts.app')

@section('subtitle'){{ $title }}@endsection

@section('content')
<div class="inner-pages col-xs-12">
    <div class="profile-wrap col-xs-12">
        <div class="container">
            <div class="prof-sidebar col-lg-4 col-md-5 col-xs-12">
                <div class="inner p-0">
                    @if($user->user_personal_photo)
                    <div class="prof-pic">
                        <img src="{{ $user->user_personal_photo }}"
                            alt="{{ $user->firstName . ' ' . $user->lastName }}">
                        <!-- <span>{{ optional($user->major)->name }}</span> -->
                    </div>
                    @endif
                    <div class="prof-info prof-info-custom">
                        <h3>{{ $user->firstName . ' ' . $user->lastName }}</h3>
                        <span class="profile-info-major">{{ optional($user->major)->name }}</span>

                    </div>
                    <div class="prof-data">
                        <!-- <div>
                            <img src="{{ asset('/frontend/images/user/ic_profile_date.svg') }}" alt="">
                            <span class="mr-1"> {{ \Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</span>
                        </div> -->
                        <div>
                            <img src="{{ asset('/frontend/images/user/ic_profile_location.svg') }}" alt="">
                            <span class="mr-1">{{ optional($user->city)->name }}</span>
                        </div>
                        <div>
                            <img src="{{ asset('/frontend/images/user/ic_profile_email.svg') }}" alt="">
                            <span class="mr-1">{{ optional($user)->email }}</span>
                        </div>
                        <!-- <div>
                            <img src="{{ asset('/frontend/images/user/ic_profile_email2.svg') }}" alt="">
                            <span class="mr-1">{{ optional($user)->university_email }}</span>
                        </div> -->
                        <div class="mb-2">
                            <img src="{{ asset('/frontend/images/user/ic_profile_call.svg') }}" alt="">
                            <span class="mr-1">{{ optional($user)->mobile }}</span>
                        </div>
                        @if($editLink)
                        <div class="prof-edit">
                            <a href="{{ $editLink }}" class="btn btn-border">{{ __('Edit') }}</a>
                        </div>
                        @endif
                    </div>
                    <!--
                    <div class="prof-rate">
                        <span>
                            @for($i=1 ; $i <= 5 ; $i++) <i
                                class="fa fa-star {{ ($user->avg_rate >= $i) ? 'active' : '' }}"></i>
                                @endfor
                        </span>
                        <span>{{ $user->avg_rate + 0 }}<b>{{ __('companytask.Reviews') }} ({{ $user->reviews_count }})
                            </b></span>
                    </div> -->
                    <!-- <div class="prof-rate" style="text-align: center;margin-bottom: 0px; ">
                        <span> <b> {{__('user.academicYear')}} :{{__('user.'.$user->academicYear)}}</b></span>
                    </div>
                    <div class="prof-bio">
                        <p class="word-wrap">{{ $user->summary }}</p>
                    </div> -->

                </div>
            </div>
            <div class="prof-box col-lg-8 col-md-7 col-xs-12">

                <!-- @if(count($user->projects) > 0)
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Projects') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-project col-xs-12">
                            @foreach($user->projects as $project)
                            <div class="pp-item col-md-3 col-sm-6 col-xs-12">
                                <a style="width:0px; height:0px; color:red;margin-bottom: 10px;"class="delete" id="deleteFile" href="{{route('user.file.delete',$project->id)}}"><i class="fa fa-close "></i></a>
                                <a href="{{ asset(Storage::disk('public')->url($project->image)) }}" download><img src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}"/></a>
                                {{--   <img src="{{ asset(Storage::disk('public')->url($project->image)) }}" alt="image"> --}}
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif -->
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('Brief') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <p class="word-wrap">{{ $user->summary }}</p>
                    </div>
                </div>

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('user.language') }} ({{optional($user->languages())->count()}})</h3>
                    </div>
                    <div class="it-body row">
                        @foreach (optional($user->languages())->get() as $language)
                        <span class="col-xl-6 text-right space-between border-bottom-gray mb-half language-wrap">
                            <span class="language">
                                {{($language->language_name !='other') ? $language->language_name : $language->language_other}}</span>
                            <span class="languages-rate">
                                <span @switch($language->language_level) @case("beginner") class="beginner" @break
                                    @case("intermediate") class="intermediate" @break @case("fluent") class="fluent"
                                    @case("professional") class="professional" @break @endswitch>
                                    <i class="fa fa-square fa-lg"></i> <i class="fa fa-square fa-lg"></i>
                                    <i class="fa fa-square fa-lg"></i> <i class="fa fa-square fa-lg"></i>
                                </span>
                                <span @switch($language->language_level) @case("beginner") class="x" @break
                                    @case("intermediate") class="Y" @break @endswitch> {{$language->language_level}}
                                </span>
                            </span>
                        </span>
                        @endforeach
                    </div>
                </div>
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">

                        <h3>{{ __('user.certificates') }} ({{optional($user->certificates())->count()}})</h3>
                    </div>
                    <div class="it-body col-xs-12 d-flex oveflow-x-scroll">
                        <!-- <div class="experiences col-xs-12 word-wrap"> -->
                        @foreach (optional($user->certificates())->get() as $certificate)
                        <div class="ml-2 text-right">
                            <div class=" default-border mb-2">
                                <span class="col-12 d-flex">
                                    <img src="{{ asset('/frontend/images/user/ic_education.svg') }}" alt="">
                                    <h3 class="mx-1 "> {{$certificate->certificate_name}}</h3>
                                </span>
                                <div class="border-bottom-gray">
                                    <p class="font-bold mr-2">{{$certificate->certificate_from}}</p>
                                    <p class="font-bold purple mr-2">{{$certificate->certificate_date}}</p>
                                </div>
                                <p class="col-12">
                                    <span>{{$certificate->certificate_description}}</span>
                                </p>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        <!-- </div> -->
                    </div>
                </div>
                {{-- experiences --}}
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">

                        <h3>{{ __('user.experiences') }} ({{optional($user->experiences())->count()}})</h3>
                    </div>
                    <div class="it-body col-xs-12 d-flex oveflow-x-scroll">
                        <!-- <div class="experiences col-xs-12 word-wrap"> -->
                        @foreach (optional($user->experiences())->get() as $experience)
                        <div class="ml-2 text-right">
                            <div class=" default-border mb-2">
                                <span class="col-12 d-flex">
                                    <img src="{{ asset('/frontend/images/user/ic_work.svg') }}" alt="">

                                    <h3 class="mx-1"> {{$experience->experience_name}} </h3>
                                </span>
                                <div class="border-bottom-gray">
                                    <p class="font-bold mr-2"> {{$experience->experience_from}} </p>
                                    <p class="font-bold purple mr-2"> {{$experience->experience_date}}</p>
                                </div>
                                <p class="col-12">
                                    <span> {{$experience->experience_description}}</span>
                                </p>
                                </span>
                            </div>
                        </div>
                        @endforeach
                        <!-- </div> -->
                    </div>
                </div>
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        @if ($user->skills != null)

                        <h3>{{ __('user.skills') }} ({{count(explode(",",$user->skills))}})</h3>
                    </div>
                    <div class="it-body col-xs-12 skills">

                        <!-- <span>count((explode(",",$user->skills))</span> -->
                        @foreach (explode(",",$user->skills) as $skill)
                        <span>{{$skill}}</span>
                        @endforeach
                        @endif
                    </div>
                </div>
                @if(count($user->projects) > 0)
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Projects') }} <span style="color: #585858; font-size: 20px;"
                                id="userProjectsCount">({{optional($user)->projects()->count()}}) <span></h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-project col-xs-12" id="post_data_projects">
                            @foreach($userProjects as $project)

                            <div class="pp-item row border-bottom-gray">
                                <div class="col-md-8">
                                    <a class="text-right boxshadow-unset d-flex align-items-center"
                                        href="{{ asset(Storage::disk('public')->url($project->image)) }}" download>
                                        <img class="w-auto ml-2"
                                            src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}" />
                                        <div class="past-projects-data mr-1">
                                            <p>
                                                {{   $filename = ($project->fileName != null) ? explode("." , $project->fileName)[0] : '' }}
                                            </p>
                                            <p style="direction: ltr;">
                                                {{\App\AppConstants::formatSizeUnits($project->fileSize)}}
                                            </p>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-4  d-flex align-items-center justify-content-end">

                                    <!-- <div class="d-flex justify-content-center"> -->
                                    <a class="text-right boxshadow-unset h-auto download"
                                        href="{{ asset(Storage::disk('public')->url($project->image)) }}" download>
                                        <i class="fa fa-download fa-lg"></i></a>
                                    <!-- <i class="fa fa-arrow-circle-down"></i> -->
                                    <a class="delete-front boxshadow-unset h-auto" id="deleteFile"
                                        href="{{route('user.file.front.delete',[$project->id ,$userProjects[count($userProjects) -1]->id])}}">

                                        <i class="fa fa-trash fa-lg gray"></i>
                                    </a>
                                    <!-- </div> -->
                                </div>
                            </div>

                            @endforeach
                        </div>
                        <button id="load_more_projects_button"
                            task-user-apply-id="{{$userProjects[count($userProjects) -1]->id}}"
                            taskidcount-raw="{{$userProjects->count()}}" url="{{route('user.loadmore.project')}}"
                            class="load_more_button">
                            {{__("loadmore")}}</button>
                    </div>
                </div>
                @endif

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Tasks') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-tasks col-xs-12 ">
                            <table class="rwd-table" id="data-table-th">
                                <thead>
                                    <tr>
                                        <th>{{ __('companytask.title') }}</th>
                                        <th>{{ __('companytask.price') }}</th>
                                        <th>{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="post_data">
                                @foreach($userFinishedCompanyTasks as $task)
                            <tr>
                                <td data-th="{{ __('companytask.title') }}">
                                    <div class="it-info">
                                        @if($task->company->company_logo)
                                        <img src="{{ $task->company->company_logo }}"
                                            alt="{{ $task->company->name }}" />
                                        @endif
                                        <div class="data">
                                            <h4>{{ $task->title }}</h4>
                                            <span>{{ optional($task->major)->name }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td data-th="{{ __('companytask.price') }}">
                                    <div class="it-price">
                                        <h4>{{ $task->price }}</h4>
                                        <p>{{ __('companytask.SAR') }}</p>
                                    </div>
                                </td>
                                <td data-th="{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}">
                                    <div class="it-date">
                                        <p>{{ $task->startDate->format('F d') }} -
                                            {{ $task->endDate->format('J d') }}</p>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                                </tbody>
                            </table>
                            @csrf
                            <button id="load_more_button"
                                task-user-apply-id="{{$userFinishedCompanyTasks[$userFinishedCompanyTasks->count()-1]->id}}"
                                taskidcount-raw="{{$userFinishedCompanyTasks->count()}}"
                                url="{{route('user.loadmore')}}"> {{__("loadmore")}}</button>
                        </div>
                    </div>
                </div>

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{  __('companytask.Reviews')  . ' (' . $userReviewsCount . ') ' }} </h3>
                    </div>
                    <div class="it-body col-xs-12 d-flex oveflow-x-scroll" id="reviews">
                        <!-- <div class="p-reviews col-xs-12 d-flex" id="reviews"> -->
                        @foreach($userReviews as $review)
                        <div class="rev-item col-xl-4 col-md-6 default-border ml-1 mb-2">

                            <div class="rev-head d-flex border-bottom-gray ">
                                <div class="col-md-5">
                                    <img src="{{ $review->company->company_logo }}"
                                        alt="{{ $review->company->name }}" />
                                </div>
                                <div class="data col-md-7">
                                    <h3>{{ $review->company->name }}</h3>
                                    <span> <span>{{$review->rate}}</span> <i class="fa fa-star purple"></i></span>
                                    <!-- <p>
                                            @for($i=1 ; $i <= 5 ; $i++) <i
                                                class="fa fa-star {{ ($review->rate >= $i) ? 'active' : '' }}"></i>
                                                @endfor
                                        </p> -->
                                </div>
                            </div>
                            <div class="rev-desc d-flex">
                                <div class="col-12">
                                    <p>{{ $review->review }}</p>
                                </div>
                            </div>

                        </div>
                        @endforeach
                        @if($userReviewsCount > count($userReviews))
                        <div class="rev-more col-xs-12">
                            <a
                                href="{{ request()->url() }}?display=all#reviews">{{ __('companytask.See All Reviews') }}</a>
                        </div>
                        @endif
                        <!-- </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection
