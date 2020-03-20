@extends('frontend.company.layouts.app')

@section('subtitle'){{ $title }}@endsection

@section('content')
<div class="inner-pages col-xs-12">
    <div class="profile-wrap col-xs-12">
        <div class="container">
            <div class="prof-sidebar col-md-4 col-xs-12">
                <div class="inner">
                    @if($user->user_personal_photo)
                    <div class="prof-pic">
                        <img src="{{ $user->user_personal_photo }}" alt="{{ $user->firstName . ' ' . $user->lastName }}">
                    </div>
                    @endif
                    <div class="prof-info">
                        <h3>{{ $user->firstName . ' ' . $user->lastName }}</h3>
                        <span>{{ optional($user->major)->name }}</span>
                    </div>
                    <div class="prof-rate">
                        <span>
                            @for($i=1 ; $i <= 5 ; $i++)
                                <i class="fa fa-star {{ ($user->avg_rate >= $i) ? 'active' : '' }}"></i>
                            @endfor
                        </span>
                        <span>{{ $user->avg_rate + 0 }}<b>{{ __('companytask.Reviews') }} ({{ $user->reviews_count }}) </b></span>
                    </div>

                    <div class="prof-extra">
                        <ul>
                            <li>
                                <span>94<i>%</i></span>
                                <p>Completed</p>
                            </li>
                            <li>
                                <span>97<i>%</i></span>
                                <p>On-time</p>
                            </li>
                        </ul>
                    </div>


                    @if($editLink)
                    <div class="prof-edit">
                        <a href="{{ $editLink }}" class="btn btn-border">{{ __('Edit') }}</a>
                    </div>
                    @endif
                </div>
            </div>
            <div class="prof-box col-md-8 col-xs-12">
                @if(count($user->projects) > 0)
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Projects') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-project col-xs-12">
                            @foreach($user->projects as $project)
                            <div class="pp-item col-md-3 col-sm-6 col-xs-12">
                                <div>                                <a href="{{ asset(Storage::disk('public')->url($project->image)) }}" download><img src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}"/></a>
                                {{--   <img src="{{ asset(Storage::disk('public')->url($project->image)) }}" alt="image"> --}}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
                {{-- experiences --}}
                <div class="prof-bio">
                        <p class="word-wrap">{{ $user->summary }}</p>
                    </div>
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('user.experiences') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="experiences col-xs-12 word-wrap">
                        {{ $user->experiences }}
                        </div>
                    </div>
                </div>

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Tasks') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-tasks col-xs-12">
                            <table class="table" id="data-table-th">
                                <thead>
                                    <tr>
                                        <th>{{ __('companytask.title') }}</th>
                                        <th>{{ __('companytask.price') }}</th>
                                        <th>{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($userFinishedCompanyTasks as $task)
                                    <tr>
                                        <td>
                                            <div class="it-info">
                                                @if($task->company->company_logo)
                                                <img src="{{ $task->company->company_logo }}" alt="{{ $task->company->name }}" />
                                                @endif
                                                <div class="data">
                                                    <h3>{{ $task->title }}</h3>
                                                    <span>{{ optional($task->major)->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="it-price">
                                                <h3>{{ $task->price }}</h3>
                                                <p>{{ __('companytask.SAR') }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="it-date">
                                                <p>{{ $task->startDate->format('F d') }} - {{ $task->endDate->format('J d') }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{  __('companytask.Reviews')  . ' (' . $userReviewsCount . ') ' }} </h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-reviews col-xs-12" id="reviews">

                            @foreach($userReviews as $review)
                                <div class="rev-item col-xs-12">
                                    <div class="rev-head col-xs-12">
                                        <img src="{{ $review->company->company_logo }}" alt="{{ $review->company->name }}" />
                                        <div class="data">
                                            <h3>{{ $review->company->name }}</h3>
                                            <p>
                                                @for($i=1 ; $i <= 5 ; $i++)
                                                    <i class="fa fa-star {{ ($review->rate >= $i) ? 'active' : '' }}"></i>
                                                @endfor
                                            </p>
                                        </div>
                                    </div>
                                    <div class="rev-desc">
                                        <p>{{ $review->review }}</p>
                                    </div>
                                </div>
                            @endforeach

                            @if($userReviewsCount > count($userReviews))
                                <div class="rev-more col-xs-12">
                                    <a href="{{ request()->url() }}?display=all#reviews">{{ __('companytask.See All Reviews') }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
