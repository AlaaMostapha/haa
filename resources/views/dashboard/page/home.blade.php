@extends('dashboard.layout.dashboard')

@section('title', __('Home'))

@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>{{ __('Welcome :name to your dashboard', ['name' => auth()->user()->name]) }}</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>{{ __('site.Registered companies') }}</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{ $companiesCount }}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="ibox ">
                            <div class="ibox-title">
                                <h5>{{ __('site.Registered users') }}</h5>
                            </div>
                            <div class="ibox-content">
                                <h1 class="no-margins">{{ $usersCount }}</h1>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
