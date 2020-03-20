@extends('frontend.site.layouts.app')

@section('subtitle'){{ optional($task)->title }}@endsection

@section('content')
<div class="inner-pages col-xs-12">
    <div class="profile-wrap company-wrap col-xs-12">
        <div class="container">
            <div class="prof-sidebar col-lg-4 col-md-5 col-xs-12">
                <div class="inner">
                    @if(optional($task->company)->company_logo)
                    <div class="prof-pic">
                        <a href="{{route('company.company.detail',[optional($task->company)->id])}}"><img src="{{ optional($task->company)->company_logo }}" alt="{{ optional($task->company)->name }}"></a>
                    </div>
                    @endif
                    <div class="prof-info">
                            <a href="{{route('company.company.detail',[optional($task->company)->id])}}"><h3>{{ optional($task->company)->name }}</h3></a>
                        {{-- <span>Telecommunications</span> --}}
                        <div>
                            <span class="word-wrap">{{ optional($task)->briefDescription }}</span>
                        </div>

                    </div>
                    {{--<div class="prof-bio">
                        <p>Etihad Etisalat Co. is a Saudi Arabian telecommunications services company that offers fixed line, mobile telephony, and Internet services under the brand name Mobily. The company was established in 2004, and in the summer of that year, won the bid for Saudi Arabia’s second GSM licence.</p>
                    </div>--}}
                    <div class="prof-edit">
                            <a href="{{route('user.login')}}" class="btn">{{ __('companytask.Apply') }}</a>
                            <a href="{{ url()->previous() }}" class="btn btn-border">{{ __('site.back') }}</a>
                        {{-- <a href="{{ route( ((auth()->guard('company')->check()) ? 'company' : 'user') . '.tasks.index') }}" class="btn btn-border">{{ __('site.back') }}</a> --}}
                    </div>
                </div>
            </div>
            <div class="prof-box col-lg-8 col-md-7 col-xs-12">
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
                                <span>
                                {{__('companytask.'.optional($task)->type)}}
                                </span>
                            </div>
                            @endif

                                <div>
                                    <h3>{{ __('companytask.fullDescription') }}</h3>
                                    <span class="word-wrap">{{ optional($task)->fullDescription }}</span>
                                </div>
                                <div class="languages">
                                    <h3>{{ __('companytask.language') }}</h3>
                                    @php $arrLang= json_decode(optional($task)->language, true)@endphp
                                    @if ($arrLang)
                                        @foreach($arrLang as $Lang)
                                        <!-- <span>{{ (count($arrLang)>1)?implode(",",$arrLang): $arrLang[0]}}</span> -->
                                        <span>{{(count($arrLang)>0)?__($Lang):""}}</span>
                                        @endforeach
                                    @else
                                        <span> {{__('nolanguage')}}</span>
                                    @endif

                                </div>
                                <div class="space-between border-bottom-gray">
                                    <span>
                                        <i class="fa fa-user"></i>
                                        {{ __('companytask.willTakeCertificate') }}
                                    </span>
                                    <span>{{ (optional($task)->willTakeCertificate == 1)?__('yes'):__('no')}}</span>
                                </div>

                            </div>
                        </div>
                        <div class="box-item">
                            <div class="row">
                            @if(optional($task)->startDate)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-calendar"></i>
                                            {{ __('companytask.startDate') }}
                                        </span>
                                        <span class="col-xs-5">{{ optional($task)->startDate->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                                @endif
                            @if(optional($task)->endDate)
                                <div class="col-lg-6">
                                    <div class="row mb-1 border-bottom-gray">
                                        <span class="col-xs-7">
                                            <i class="fa fa-calendar"></i>
                                            {{ __('companytask.endDate') }}
                                        </span>
                                        <span class="col-xs-5">{{ optional($task)->endDate->format('Y-m-d')}}</span>
                                    </div>
                                </div>
                                @endif
                            @if(optional($task)->price)
                                <div class="col-12  border-bottom-gray prize mb-1">
                                    <div class="row pt-1 ">
                                        <span class="col-xs-7">
                                            <i class="fa fa-trophy fa-lg"></i>
                                            {{ __('companytask.price') }}
                                        </span>
                                        <span class="col-xs-5 text-left">{{ optional($task)->price }}
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

                        <div class="box-item">
                            <div class="it-head col-12">
                                <h3>{{ __('location') }}</h3>
                            </div>
                            <div class="space-between col-md-6 border-bottom-gray">
                                <span>
                                    <span> {{optional(optional($task)->city)->name}}</span>
                                    <i class="fa fa-map-marker fa-lg"></i>
                                    <!-- {{ __('companytask.City') }}
                                </span>
                                <span> -->


                                </span>
                            </div>
                            <div class="space-between col-md-6 border-bottom-gray">
                                <span>

                                    <!-- {{ __('companytask.location') }}
                                </span>
                                <span> -->
                                    <span>{{ optional($task)->location}}</span>
                                    <i class="fa fa-map-marker fa-lg"></i>
                                </span>
                            </div>
                            <div class="space-between col-12 border-bottom-gray">
                                <span>
                                        <!-- {{implode(","  , optional($task->majors)->pluck('name')->toArray()) }} -->
                                        <i class="fa fa-map-marker fa-lg"></i>
                                        {{ __('companytask.cityExistImportance') }}
                                </span>
                                <span>{{ (optional($task)->cityExistImportance == "important")?__('companytask.important'):__('companytask.not_important')}}</span>
                            </div>
                        </div>
                        <div class="box-item majors">
                            <div class="it-head">
                                <h3>{{ __('companytask.fields') }}</h3>
                            </div>
                            @foreach($task->majors as $major)
                            <span>{{(count($task->majors)>1)?$major:__('no_found_majors')}}</span>
                            @endforeach
                        </div>







            </div>
        </div>
    </div>
</div>
@endsection
