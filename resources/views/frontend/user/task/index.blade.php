@extends('frontend.user.layouts.app')

@section('subtitle'){{ __('companytask.Tasks') }}@endsection

@section('content')

<div class="inner-pages col-xs-12">
    <div class="profile-wrap tasks-wrap col-xs-12">
        <div class="container">
            <div class="prof-box col-xs-12">
                <div class="box-item col-xs-12">
                    @if (session('successMessage'))
                    <div class="col-xs-12 form-group">
                        <div class="alert alert-success" role="alert">
                            {{ session('successMessage') }}
                        </div>
                    </div>
                    @endif
                    <div class="it-head col-xs-12">
                        <h3>{{ __('user.my_tasks') }}</h3>
                        <div class="filter-options">
                            <button type="button" class="op-filter">
                                <i class="fa fa-sliders"></i>
                            </button>
                            <button type="button" class="op-search">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>

                    <?php
//                    dd(request()->route()->getName());
                    ?>

                    <form action="{{ route( request()->route()->getName() ) }}" class="dev-search-form">
                        <!--<form action="{{ route('user.tasks.index') }}" class="dev-search-form">-->
                        <div class="filter-area col-xs-12">
                            <div class="fi-item col-lg-4 col-xs-12">
                                <h4> {{ __('user.Major') }}
                                    <!-- <i class="fa fa-chevron-down"></i> -->
                                </h4>
                                <select class="select-2 dev-filter-select" multiple="" name="major[]">
                                    @foreach (\App\Models\Major::all(['id' ,'name']) as $major)
                                    {{-- <option @if(in_array( __('user.Major'), request('major', [])))selected=""@endif value="{{ __('user.Major') }}">{{ __('user.Major') }}
                                    </option> --}}
                                    <option @if(in_array( $major->id, request('major', [])))selected=""@endif
                                        value="{{ $major->id}}">{{ $major->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="fi-item col-lg-4 col-xs-12">
                                <h4>{{ __('companytask.price') }}
                                    <!-- <i class="fa fa-chevron-down"></i> -->
                                </h4>
                                <select class="select-2 dev-filter-select" multiple="" name="priceRange[]">
                                    <option @if(in_array('1,500', request('priceRange', [])))selected=""@endif value="1,500">{{ __('companytask.From') }}: 1 {{ __('companytask.SAR') }} {{ __('companytask.To') }}: 500 {{ __('companytask.SAR') }}</option>
                                    <option @if(in_array('501,1000', request('priceRange', [])))selected=""@endif value="501,1000">{{ __('companytask.From') }}: 501 {{ __('companytask.SAR') }} {{ __('companytask.To') }}: 1000 {{ __('companytask.SAR') }}</option>
                                    <option @if(in_array('1001,2000', request('priceRange', [])))selected=""@endif value="1001,2000">{{ __('companytask.From') }}: 1001 {{ __('companytask.SAR') }} {{ __('companytask.To') }}: 2000 {{ __('companytask.SAR') }}</option>
                                    <option @if(in_array('2000,5000', request('priceRange', [])))selected=""@endif value="2000,5000">{{ __('companytask.From') }}: 2000 {{ __('companytask.SAR') }} {{ __('companytask.To') }}: 5000 {{ __('companytask.SAR') }}</option>

                                </select>
                            </div>
                            <div class="fi-item col-lg-4 col-xs-12">
                                <h4>{{ __('companytask.Date') }}
                                    <!-- <i class="fa fa-chevron-down"></i> -->
                                </h4>
                                <select class="select-2 dev-filter-select" multiple="" name="durationRange[]">
                                    <option @if(in_array('week', request('durationRange', [])))selected="" @endif
                                        value="week">{{ __('companytask.From') }}: {{ __('companytask.Last week') }}
                                        {{ __('companytask.To') }}: {{ __('companytask.Today') }}</option>
                                    <option @if(in_array('month', request('durationRange', [])))selected="" @endif
                                        value="month">{{ __('companytask.From') }}: {{ __('companytask.Last month') }}
                                        {{ __('companytask.To') }}: {{ __('companytask.Today') }}</option>
                                    <option @if(in_array('year', request('durationRange', [])))selected="" @endif
                                        value="year">{{ __('companytask.From') }}: {{ __('companytask.Last year') }}
                                        {{ __('companytask.To') }}: {{ __('companytask.Today') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="search-area col-xs-12">
                            <div class="form-group">
                                <input type="search" class="form-control"
                                    placeholder="{{ __('companytask.Search by title') }} ....." name="title"
                                    value="{{ request('title') }}">
                                <button type="submit" class="btn">
                                    <i class="fa fa-search color-white"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <div class="it-body col-xs-12">
                        <div class="">
                            <table class="rwd-table w-100" id="data-table-th">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('companytask.title') }}</th>
                                        <th>{{ __('companytask.price') }}</th>
                                        <th>{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($tasks->total() > 0)
                                    @foreach ($tasks as $task)
                                    <tr>
                                        <td data-th="{{ __('companytask.title') }}">
                                            @if($task->company->company_logo)
                                            <div class="t-img">
                                                <img src="{{ $task->company->company_logo }}"
                                                    alt="{{ $task->company->name }}">
                                            </div>
                                            @endif
                                        </td>
                                        <td data-th="{{ __('companytask.price') }}">
                                            <div class="it-info" style="max-width: 200px;">
                                                <div class="data">
                                                    <h4>{{ $task->title }}</h4>
                                                    <span>{{ optional($task->major)->name }}</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td data-th="{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}">
                                            <div class="it-price">
                                                <h4>{{ $task->price }}</h4>
                                                <p>{{ __('companytask.SAR') }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="it-date">
                                                <p>{{ $task->startDate->format('F d') }} -
                                                    {{ $task->endDate->format('J d') }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="app-n text-center">
                                                <a
                                                    href="{{ route('user.tasks.show', ['companyTask' => $task]) }}">{{ __('View') }}</a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="5"> {{__("companytask.noSearchResult")}}</td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
