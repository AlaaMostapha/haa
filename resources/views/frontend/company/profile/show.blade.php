@extends('frontend.company.layouts.app')

@section('subtitle'){{ $title }}@endsection

@section('content')
<div class="inner-pages col-xs-12">
    <div class="profile-wrap col-xs-12">
        <div class="container">
            <div class="prof-sidebar col-md-4 col-xs-12">
                <div class="inner">
                    @if($companyProfile->company_logo)
                    <div class="prof-pic">
                        <img src="{{ $companyProfile->company_logo }}"
                            alt="{{ $companyProfile->firstName . ' ' . $companyProfile->lastName }}">
                        <img src="" alt="">
                    </div>
                    @endif
                    <div class="prof-info">
                        {{-- <h3>{{ $companyProfile->firstName . ' ' . $companyProfile->lastName }}</h3> --}}
                        <h3>{{ $companyProfile->name }}</h3>
                        {{-- <span>{{ $companyProfile->major }}</span> --}}
                        {{-- <h3></h3>
                        <span></span> --}}
                    </div>

                    <div class="prof-edit">
                        <a href="{{$editLink}}" class="btn btn-border">{{ __('Edit') }}</a>
                    </div>
                </div>
            </div>
            <div class="prof-box col-md-8 col-xs-12">

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('company.Brief') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <p class="word-wrap">{{optional($companyProfile)->summary}}</p>
                    </div>
                </div>
                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('Informations') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="col-xs-12">
                            <div class="company-info custom-company-info">
                                <ul>
                                    <li class="col-md-6 col-xs-12">
                                        <div class="row">
                                            <span class="col-md-7">
                                                <i class="fa fa-phone fa-lg"></i>
                                                {{ __('company.mobile') }}
                                            </span>

                                            <span class="col-md-5 text-left">{{optional($companyProfile)->mobile}}</span>
                                        </div>
                                    </li>
                                    <li class="col-md-6 col-xs-12">
                                        <div class="row">
                                            <span class="col-md-7">
                                                <i class="fa fa-at fa-lg"></i>
                                                {{__('company.email')}}
                                            </span>
                                            <span class="col-md-5 text-left"> {{optional($companyProfile)->email}} </span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box-item col-xs-12">
                    <div class="it-head col-xs-12">
                        <h3>{{ __('companytask.Past Tasks') }}</h3>
                    </div>
                    <div class="it-body col-xs-12">
                        <div class="p-tasks col-xs-12  border-0">
                            <table class="rwd-table companyTable" id="data-table-th">
                                <thead>
                                    <tr>
                                        <th>{{ __('companytask.title') }}</th>
                                        <th>{{ __('companytask.price') }}</th>
                                        <th>{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}</th>
                                    </tr>
                                </thead>
                                <tbody id="post_data">
                                    @foreach($companyFinishedCompanyTasks as $task)
                                    <tr>
                                        <td data-th="{{ __('companytask.title') }}">
                                            <div class="it-info">
                                                @if($task->company->logo)
                                                <a href="{{route('company.company.detail' ,[optional($task->company)->id])}}">
                                                    <img src="{{ optional($task->company)->logo }}"
                                                        alt="{{ $task->name }}" />
                                                        <span>{{optional($task->company)->name }}</span>
                                                </a>    
                                                @else
                                                    <a href="{{route('company.company.detail' ,[optional($task->company)->id])}}">
                                                        <img src="{{ asset('/frontend/images/company-default.jfif') }}"
                                                        alt="{{ optional($task->company)->name }}" />
                                                        <span>{{optional($task->company)->name }}</span>
                                                    </a>    
                                                @endif
                                                <div class="data">
                                                    <h4>{{ $task->title }}</h4>
                                                    <span>{{ optional($task->major)->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="{{ __('companytask.price') }}">
                                            <div class="it-price">
                                                <h4 class="d-inline">{{ $task->price }} <h4 class="d-inline">{{ __('companytask.SAR') }}</h4></h4>
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
                        <button id="load_more_button"   task-user-apply-id ="{{$companyFinishedCompanyTasks[$companyFinishedCompanyTasks->count()-1]->id}}" taskidcount-raw="{{$companyFinishedCompanyTasks->count()}}"  url="{{route('company.loadmore')}}">
                            {{__('Load More')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
