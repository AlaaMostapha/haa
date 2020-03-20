@extends('frontend.company.layouts.app')

@section('subtitle'){{ __('Create') }} {{ __('companytask.Task') }}@endsection

@section('content')

<style>
    .form-group .help-block{
        text-align: right !important;
    }
</style>

<div class="sign-area  col-xs-12">
    <div class="container">
        <div class="sign-inner custom-user col-md-8 col-xs-12 form-width">
            <div class="sign-head col-xs-12">
                <h3>{{ __('Create') }} {{ __('companytask.Task') }}</h3>
                {{--<p>The quick, brown fox jumps over a lazy dog. DJs flock by when MTV ax quiz prog. Junk MTV quiz graced by fox whelps.</p>--}}
            </div>
            <div class="sign-form col-xs-12">
                <form class="dev-validate-form" method="POST" action="{{ route('company.tasks.store') }}">
                    @csrf
                    <div class="form-group col-xs-12 @error('title') has-error @enderror">
                        <input type="text" class="form-control" placeholder="{{ __('companytask.title') }}" name="title" value="{{ old('title') }}" required="" autofocus="" autocomplete="title" minlength="3" maxlength="170">
                        @error('title')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                            <div class="form-group col-md-6 col-xs-12 @error('startDate') has-error @enderror">
                                    <input type="text" class="form-control dev-date-current-input" placeholder="{{ __('companytask.startDate') }}" name="startDate" value="{{ old('startDate') }}" required="" autocomplete="startDate" data-rule-date="">
                                    @error('startDate')
                                    <span class="help-block" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <b class="required">*</b>
                            </div>
                            <div class="form-group col-md-6 col-xs-12 @error('endDate') has-error @enderror">
                                    <input type="text" class="form-control dev-date-current-input" placeholder="{{ __('companytask.endDate') }}" name="endDate" value="{{ old('endDate') }}" required="" autocomplete="endDate" data-rule-dateISO="">
                                    @error('endDate')
                                    <span class="help-block" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <b class="required">*</b>
                            </div>



                    <div class="form-group col-md-6 col-xs-12 @error('price') has-error @enderror">
                        <input type="text" class="form-control" placeholder="{{ __('companytask.price') }}" name="price" value="{{ old('price') }}" required="" min="50" autocomplete="price" data-rule-digits="" maxlength="9">
                        @error('price')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>
                    <div class="form-group-select col-md-6 col-xs-12 @error('pricePaymentType') has-error @enderror">
                        <select class="form-control" id="pricePaymentType" name="pricePaymentType" required>
                            <option value="" disabled selected>{{ __('companytask.pricePaymentType') }}</option>
                            @foreach(\App\Models\CompanyTask::PRICE_PAYMENT_TYPE as $option)
                            <option @if(old('pricePaymentType') == $option)selected=""@endif value="{{ $option }}">{{ __('companytask.'.$option) }}</option>
                            @endforeach
                        </select>
                        @error('pricePaymentType')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>
                    <div class="form-fields-group col-md-12">
                            <div class="form-group  col-xs-12 @error('type') has-error @enderror">
                                    <select class="form-control" name="type" id="workType" required>
                                        <option value="" disabled @if(old('type') == '')selected=""@endif>{{ __('companytask.type') }}</option>
                                        @foreach(\App\Models\CompanyTask::TYPE as $option)
                                        <option @if(old('type') == $option)selected=""@endif value="{{ $option }}">{{ __('companytask.'.$option) }}</option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                    <span class="help-block" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <b class="required">*</b>
                            </div>
                            <div class="form-group col-md-6 col-xs-12 @error('workHoursFrom') has-error @enderror"  id="workHoursFromDiv" @if(old('type') != 'part_time')style="display: none;"@endif>
                        {{-- <input type="time" class="form-control" id="workHoursFrom" placeholder="{{ __('companytask.workHoursFrom') }}" name="workHoursFrom" value = "13:24:00"  > --}}
                        <input type="text" class="form-control input-group clockpicker" id="workHoursFrom" placeholder="{{ __('companytask.workHoursFrom') }}" name="workHoursFrom" value = "13:24:00"  >
                        <i class="fas fa-clock"></i>
                        @error('workHoursFrom')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                    <div class="form-group col-md-6 col-xs-12 @error('workHoursTo') has-error @enderror"  id="workHoursToDiv" @if(old('type') != 'part_time')style="display: none;"@endif>
                            {{-- <input type="time" class="form-control" id="workHoursTo" placeholder="{{ __('companytask.workHoursTo') }}" name="workHoursTo" value="{{ old('workHoursTo') }}"  > --}}
                            <input type="text" class="form-control" id="workHoursTo" placeholder="{{ __('companytask.workHoursTo') }}" name="workHoursTo" value="{{ old('workHoursTo') }}"  >
                            <span class="help-block" role="alert" id="error-time" style="display:none; color:red;"> {{__('time_message')}}</span>
                            @error('workHoursTo')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                            <b class="required">*</b>
                        </div>
                            {{-- @if(old('major_id') == $major->id)selected=""@endif --}}
                            <div class="form-group-select col-xs-12 @error('majors') has-error @enderror">
                                    <select class="form-control select-multi-major" name="majors[]" required="" multiple="multiple">
                                        {{-- <option value="" disabled selected>{{ __('companytask.Major') }}</option> --}}
                                        @foreach(\App\Models\Major::all() as $major)
                                        <option {{ (is_array(old('majors')) and in_array($$major->id , old('majors'))) ? ' selected' : '' }}value="{{ $major->id }}">{{ $major->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('majors')
                                    <span class="help-block" role="alert" style="text-align: right !important;">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                    <b class="required">*</b>
                                </div>

                                {{-- <select class="js-example-basic-multiple select2" name="states[]" multiple="multiple">
                                        <option value="AL">Alabama</option>
                                          ...
                                        <option value="WY">Wyoming</option>
                                      </select> --}}
                    </div>




                    <div class="form-group col-xs-12 @error('workDaysCount') has-error @enderror"  @if(old('type') != 'part_time')style="display: none;"@endif id="workDaysCountDiv">
                        <select class="form-control" name="workDaysCount" id="workDaysCount" >
                            <option value="" disabled selected>{{ __('companytask.workDaysCount') }}</option>
                            @for($option = 1 ; $option <= 5 ; $option++)
                            <option @if(old('workDaysCount') == $option)selected=""@endif value="{{ $option }}">{{ $option }}</option>
                            @endfor
                        </select>
                        @error('workDaysCount')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                    <div class="form-group col-xs-12 @error('location') has-error @enderror"  id="workLocationDiv"  @if(old('type') != 'part_time')style="display: none;"@endif>
                        <input type="text" class="form-control" id="workLocation" placeholder="{{ __('companytask.location') }}" name="location" value="{{ old('location') }}" >
                        @error('location')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>





                    <div class="form-group-select col-md-6 col-xs-12 @error('city_id') has-error @enderror">
                        <select class="form-control select-city" name="city_id" required="">
                            <option value="" disabled selected>{{ __('companytask.City') }}</option>
                            @foreach(\App\Models\City::all() as $city)
                            <option @if(old('city_id') == $city->id)selected=""@endif value="{{ $city->id }}">{{ $city->name }}</option>
                            @endforeach
                        </select>
                        @error('city_id')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                    <div class="form-group-select col-md-6 col-xs-12 @error('cityExistImportance') has-error @enderror">
                        <select class="form-control" id="cityExistImportance" name="cityExistImportance" required>
                            <option value="" disabled selected class='test'>{{ __('companytask.cityExistImportance') }}</option>
                            @foreach(\App\Models\CompanyTask::CITY_EXIST_IMPORTANCE as $option)
                            <option @if(old('cityExistImportance') == $option)selected=""@endif value="{{ $option }}">{{ __('companytask.'.$option) }}</option>
                            @endforeach
                        </select>
                        @error('cityExistImportance')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>
                    <div class="form-group col-xs-12 @error('requiredNumberOfUsers') has-error @enderror">
                        <input type="text" class="form-control" placeholder="{{ __('companytask.requiredNumberOfUsers') }}" name="requiredNumberOfUsers" value="{{ old('requiredNumberOfUsers') }}" autocomplete="requiredNumberOfUsers" data-rule-digits="" min="1" max="255">
                        @error('requiredNumberOfUsers')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-md-6 col-md-12 col-xs-12 @error('briefDescription') has-error @enderror">
                        <textarea class="form-control" placeholder="{{ __('companytask.briefDescription') }}" name="briefDescription" required="" minlength="3" maxlength="1000">{{ old('briefDescription') }}</textarea>
                        @error('briefDescription')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>
                    <div class="form-group col-md-6 col-md-12 col-xs-12 @error('fullDescription') has-error @enderror">
                        <textarea class="form-control" placeholder="{{ __('companytask.fullDescription') }}" name="fullDescription" required="" minlength="3" maxlength="1000">{{ old('fullDescription') }}</textarea>
                        @error('fullDescription')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>




                    <div class="form-group col-xs-12 @error('language') has-error @enderror">
                        <label> {{__('companytask.language')}} </label> &nbsp;
                        @foreach(\App\Models\CompanyTask::LANGUAGE as $option)
                            <input type="checkbox" required value="{{ $option }}" name="language[]"
                                {{ (is_array(old('language')) and in_array($option, old('language'))) ? ' checked' : '' }}> {{  __('companytask.'.$option) }}
                        @endforeach

                        @error('language')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                    <div class="form-group col-xs-12 @error('willTakeCertificate') has-error @enderror">
                        <select class="form-control certificateOptionSelect" name="willTakeCertificate" required="">
                            <option value="" disabled selected>{{ __('companytask.willTakeCertificate') }}</option>
                            @foreach(\App\AppConstants::getYesNoOptions() as $key => $value)
                            <option @if(old('willTakeCertificate') === $key)selected=""@endif value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('willTakeCertificate')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                        <b class="required">*</b>
                    </div>

                    <div class="form-group col-xs-12">
                        <button type="submit" class="btn">{{ __('Create') }} {{ __('companytask.Task') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
