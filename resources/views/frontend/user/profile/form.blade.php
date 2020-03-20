<form class="dev-validate-form" method="POST" action="{{ $submitUrl }}" enctype="multipart/form-data">
    @csrf
    @if (!$signupPage)
    <input type="hidden" name="_method" value="PUT">
    @endif
    <div class="form-group col-md-6 col-xs-12 @error('firstName') has-error @enderror">
        <input type="text" class="form-control" placeholder="{{ __('user.firstName') }}" name="firstName"
            value="{{ old('firstName') }}" required="" autocomplete="firstName" minlength="3" maxlength="255"
            autofocus="">
        @error('firstName')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('lastName') has-error @enderror">
        <input type="text" class="form-control" placeholder="{{ __('user.lastName') }}" name="lastName"
            value="{{ old('lastName') }}" required="" autocomplete="lastName" minlength="3" maxlength="255">
        @error('lastName')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('username') has-error @enderror">
        <input type="text" pattern="^\S*$" title="{{__('user.not_space_allow')}}" class="form-control"
            placeholder="{{ __('user.username') }}" name="username" value="{{ old('username') }}" required=""
            autocomplete="username" minlength="3" maxlength="170">
        @error('username')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('university_email') has-error @enderror">
        <input type="email" id="university_email" class="form-control" placeholder="{{ __('user.university_email') }}"
            name="university_email" value="{{ old('university_email') }}" required="" autocomplete="email"
            maxlength="170">
        @error('university_email')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-xs-12 @error('email') has-error @enderror">
        <input type="email" class="form-control" placeholder="{{ __('user.email') }}" name="email"
            value="{{ old('email') }}" required="" autocomplete="email" maxlength="170">
        @error('email')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>

    <div class="form-group col-md-6 col-xs-12 @error('password') has-error @enderror">
        <input type="password" class="form-control" placeholder="{{ __('user.password') }}" name="password"
            @if($signupPage)required="" @endif autocomplete="new-password" minlength="6" maxlength="255">
        @error('password')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('password_confirmation') has-error @enderror">
        <input type="password" class="form-control" placeholder="{{ __('user.password_confirmation') }}"
            name="password_confirmation" @if($signupPage)required="" @endif autocomplete="new-password" minlength="6"
            maxlength="255">
        @error('password_confirmation')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group  col-xs-12 @error('mobile') has-error @enderror">
        <input type="text" class="form-control english-text" placeholder="{{ __('company.mobile') }}" maxlength="13"
            minlength="13" name="mobile" value="{{ old('mobile') }}" required="" autocomplete="mobile">
        <span class="english-text">Ex: +966 5X XXX XXXX</span>
        @error('mobile')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    @if(!$signupPage)
    <div class="form-group-select col-md-12 col-xs-12  @error('city_id') has-error @enderror">
        <select class="form-control select-city" name="city_id" size="10">
            {{-- <option value="" disabled selected>{{__('user.city')}}</option> --}}
            @foreach (\App\Models\City::all(['id' ,'name']) as $city)
            <option @if(old('city_id')==$city->id)selected=""@endif value="{{ $city->id }}">{{ $city->name }}</option>
            @endforeach
        </select>
        @error('city_id')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    @endif


    {{-- <div class="form-group col-md-6 col-xs-12 @error('bankAccountNumber') has-error @enderror">
            <input type="text" class="form-control" placeholder="{{ __('user.bankAccountNumber') }}"
    name="bankAccountNumber" value="{{ old('bankAccountNumber') }}" required="" autocomplete="bankAccountNumber"
    minlength="3" maxlength="255">
    @error('bankAccountNumber')
    <span class="help-block" role="alert">
        {{ $message }}
    </span>
    @enderror
    <b class="required">*</b>
    </div>--}}

    <div @if(!$signupPage)class="form-group-select d-flex col-md-6 col-xs-12 @error('university_id') has-error @enderror"
        @else class="form-group-select col-md-12 col-xs-12 @error('university_id') has-error @enderror" @endif>
        <select class="form-control select-university" name="university_id" required="">
            <option value="" disabled selected>{{ __('user.university_id') }}</option>
            @foreach(\App\Models\University::all(['id' ,'name']) as $university)
            <option @if(old('university_id')==$university->id)selected=""@endif
                value="{{ $university->id }}">{{ $university->name }}</option>
            @endforeach

        </select>
        @error('university_id')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    @if (!$signupPage)
    <div class="form-group-select col-md-6 col-xs-12 @error('academicYear') has-error @enderror">
        <select class="form-control select-academicYear" name="academicYear">
            <option value="" disabled selected>{{ __('user.academicYear') }}</option>
            @foreach(\App\AppConstants::academicYear() as $key => $year)
            <option @if(old('academicYear')==$key)selected="" @endif value="{{ $key }}">{{ $year }}</option>
            @endforeach
        </select>
    </div>
    @endif
    <!-- <div class="form-group col-md-12"> -->
    <div class="form-group-select col-md-6 col-xs-12 @error('major_id') has-error @enderror">
        <select class="form-control select-major" name="major_id" required="">
            <option value="" disabled selected>{{__('major.majors')}}</option>
            @foreach (\App\Models\Major::all(['id' ,'name']) as $major)
            <option @if(old('major_id')==$major->id)selected=""@endif value="{{ $major->id }}">{{ $major->name }}
            </option>
            @endforeach
        </select>
        @error('major_id')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group-select col-md-6 col-xs-12 @error('yearOfStudy') has-error @enderror">
        {{-- <input type="text" class="form-control" placeholder="{{ __('user.yearOfStudy') }}" name="yearOfStudy"
        value="{{ old('yearOfStudy') }}" autocomplete="yearOfStudy" data-rule-digits="" minlength="4" maxlength="4">
        --}}
        <select class="form-control select-yearOfStudy" name="yearOfStudy" required="">
            <option value="" disabled selected>{{ __('user.yearOfStudy') }}</option>
            @for ($year = 2020; $year <=2030; $year++) <option @if(old('yearOfStudy')==$year)selected="" @endif
                value="{{ $year }}">{{ $year }}</option>
                @endfor
        </select>
        @error('yearOfStudy')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <!-- </div> -->
    @if (!$signupPage)

    <div class="form-group-select col-md-6 col-xs-12 @error('gpaType') has-error @enderror">
        <select class="form-control select-gpatype" name="gpaType">
            {{-- <option disabled selected>{{ __('user.GPA Type') }}</option> --}}
            @foreach (\App\Services\UserService::getGpaType() as $gpatype)
            <option @if(old('gpaType')==$gpatype)selected="" @endif value="{{ $gpatype }}">{{ $gpatype }}</option>
            @endforeach
        </select>
        @error('gpaType')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('gpa') has-error @enderror">
        <input type="number" class="form-control" placeholder="{{ __('user.gpa') }}" name="gpa" value="{{ old('gpa') }}"
            autocomplete="gpa" maxlength="255">
        @error('gpa')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>

    @if (session('failMessage_certificate'))
        <div class="col-xs-12 form-group">
            <div class="alert alert-danger" role="alert">
                {{ session('failMessage_certificate') }}
            </div>
        </div>
    @endif
    <div class="form-group col-md-12 col-xs-12 @error('certificates') has-error @enderror" id="wrapper_certificates"
        @if(old('id')!==null) countraw="{{count(old('id'))}}" @endif>
        <div class="row mb-3">
            <div class="col-lg-7">
                <h3 class="lHight-2"> {{ __('user.certificates') }}</h3>
            </div>
            <div class="col-lg-5 text-center">
                <input type="button" value="{{__("add")}}" style="margin:0;background-color:#980771;color:white"
                    id="addRaw" class="btn-sm m-0 btn certificate-btn add-btn-certificate" />
            </div>
        </div>
        @if(count(old('certificate_name')) >= 1)
        @for ($i = 0; $i < count(old('certificate_name')); $i++) <div
            class="form-group row">
            <div class="certificate-width mx-1">
                <input type="hidden" name="certificate_id[]" value="{{old('id')[$i]}}" />
                <input type="text" value="{{old('certificate_name')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.certificate_name') }}" name="certificate_name[]" minlength="3"
                    maxlength="80" required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('certificate_from')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.certificate_from') }}" name="certificate_from[]" minlength="3"
                    maxlength="80" required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('certificate_date')[$i]}}"
                    class="form-control dev-date-current-input-certificate is-required"
                    placeholder="{{ __('user.certificate_date') }}" name="certificate_date[]" required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('certificate_description')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.certificate_description') }}" name="certificate_description[]"
                    minlength="3" maxlength="80" required>
            </div>

            <div class="certificate-width mx-1 align-self-center text-center" id="{{old('id')[$i]}}"
                @if(isset(old('id')[$i])) route-link="{{route('user.certificate.delete' ,old('id')[$i])}}" @endif>
                <input type="button" style="margin:0;max-width:100%" value="{{__('remove')}}"
                    class=" btn-sm btn-danger remove-btn certificate-btn btn" />
            </div>
    </div>
    @endfor
    @else
    <div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive">
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.certificate_name') }}"
                name="certificate_name[]" minlength="3" maxlength="80">
            @error('certificate_name.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.certificate_from') }}"
                name="certificate_from[]" minlength="3" maxlength="80">
            @error('certificate_from.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control dev-date-current-input-certificate is-required"
                placeholder="{{ __('user.certificate_date') }}" name="certificate_date[]" minlength="3" maxlength="80">
            @error('certificate_date.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required"
                placeholder="{{ __('user.certificate_description') }}" name="certificate_description[]" minlength="3"
                maxlength="80">
            @error('certificate_description.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        {{-- <div class="certificate-width mx-1  text-center" id="{{old('id')[$i]}}"
        route="{{url('certificate/'.old('id')[$i] .'/delete')}}">
        <input type="button" style="margin:0;max-width:100%" value="remove"
            class="btn btn-danger btn-sm remove-btn certificate-btn" />
    </div> --}}
    </div>
    @endif

    {{-- <textarea class="form-control" placeholder="{{ __('user.certificates') }}" name="certificates" minlength="3"
    maxlength="1000">{{ old('certificates') }}</textarea>
    @error('certificates')
    <span class="help-block" role="alert">
        {{ $message }}
    </span>
    @enderror --}}
    </div>

    <!-- -->
    {{-- <div class="form-group col-md-12 col-xs-12 @error('experiences') has-error @enderror">
                <textarea class="form-control" placeholder="{{ __('user.experiences') }}" name="experiences"
    minlength="3" maxlength="1000">{{ old('experiences') }}</textarea>
    @error('experiences')
    <span class="help-block" role="alert">
        {{ $message }}
    </span>
    @enderror
    </div> --}}

    <!-- -->
    @if (session('failMessage_experience'))
    <div class="col-xs-12 form-group">
        <div class="alert alert-danger" role="alert">
            {{ session('failMessage_experience') }}
        </div>
    </div>
    @endif
    <div class="form-group col-md-12 col-xs-12 @error('experiences') has-error @enderror" id="wrapper_experiences"
        @if(old('experience_id')!==null) countraw-experience="{{count(old('experience_id'))}}" @endif>

        <div class="row mb-3">
            <div class="col-lg-7">
                <h3 class="lHight-2"> {{ __('user.experiences') }}</h3>
            </div>
            <div class="col-lg-5 text-center">
                <input type="button" value="{{__("add")}}" style="margin:0;background-color:#980771;color:white"
                    id="addRawExperience" class="btn-sm m-0 btn certificate-btn add-btn-certificate" />
            </div>
        </div>
        @if(count(old('experience_name')) >= 1)
        @for ($i = 0; $i < count(old('experience_name')); $i++) <div
            class="form-group row">
            <div class="certificate-width mx-1">
                <input type="hidden" name="experience_id[]" value="{{old('experience_id')[$i]}}" />
                <input type="text" value="{{old('experience_name')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.experience_name') }}" name="experience_name[]" minlength="3" maxlength="80"
                    required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('experience_from')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.experience_from') }}" name="experience_from[]" minlength="3" maxlength="80"
                    required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('experience_date')[$i]}}"
                    class="form-control dev-date-current-input-experience is-required"
                    placeholder="{{ __('user.experience_date') }}" name="experience_date[]" required>
            </div>
            <div class="certificate-width mx-1">
                <input type="text" value="{{old('experience_description')[$i]}}" class="form-control is-required"
                    placeholder="{{ __('user.experience_description') }}" name="experience_description[]" minlength="3"
                    maxlength="80" required>
            </div>

            <div class="certificate-width mx-1 align-self-center text-center" id="{{old('experience_id')[$i]}}"
                @if(isset(old('id')[$i])) route-link="{{route('user.experience.delete' ,old('experience_id')[$i])}}"
                @endif>
                <input type="button" style="margin:0;max-width:100%" value="{{__('remove')}}"
                    class=" btn-sm btn-danger remove-btn-experience certificate-btn btn" />
            </div>
    </div>
    @endfor
    @else
    <div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive">
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.experience_name') }}"
                name="experience_name[]" minlength="3" maxlength="80">
            @error('experience_name.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.experience_from') }}"
                name="experience_from[]" minlength="3" maxlength="80">
            @error('experience_from.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control dev-date-current-input-experience is-required"
                placeholder="{{ __('user.experience_date') }}" name="experience_date[]" minlength="3" maxlength="80">
            @error('experience_date.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        <div class="certificate-width mx-1">
            <input type="text" value="" class="form-control is-required"
                placeholder="{{ __('user.experience_description') }}" name="experience_description[]" minlength="3"
                maxlength="80">
            @error('experience_description.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

    </div>
    @endif
    </div>

    <!-- -->
    @if (session('failMessage_language'))
        <div class="col-xs-12 form-group">
            <div class="alert alert-danger" role="alert">
                {{ session('failMessage_language') }}
            </div>
        </div>
    @endif
    <div class="col-md-12 col-xs-12" id="wrapperlang"
        @if(old('language_id')!==null)countraw="{{count(old('language_id'))}}@endif">

        <div class="row mb-3">
            <div class="col-lg-7">
                <h3 class="lHight-2"> {{ __('user.language') }}</h3>
            </div>
            <div class="col-lg-5 text-center">
                <input type="button" value="{{__("add")}}" style="margin:0; background-color:#980771;color:white"
                    id="addRawLanguage" class="btn-sm btn-pure m-0 certificate-btn btn add-btn-certificate" />
            </div>
        </div>

        @if(count(old('language_name')) >= 1)
        @for ($i = 0; $i < count(old('language_name')); $i++) <div
            class="form-group row">
            <div class="form-group col-md-3 ">

                <input type="hidden" name="language_id[]" , value="{{old('language_id')[$i]}}">

                <select class="form-control lang-name" name="language_name[]" required>
                    <option selected disabled>{{ __("choose_language") }}</option>
                    @foreach (\App\Services\UserService::languages() as $key => $lang)
                    <option @if(old('language_name')[$i]==$key)selected="" @endif value="{{ $key }}">{{ $lang }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3 ">
                <select class="form-control lang-level" name="language_level[]" required>
                    <option selected disabled>{{__("choose_language_level")}}</option>
                    @foreach (\App\Services\UserService::languagesLevel() as $key => $lang)
                    <option @if(old('language_level')[$i]==$key)selected="" @endif value="{{ $key }}">{{ $lang }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-md-3 other">
                @if(old('language_other')[$i] == null)
                <input type="hidden" name="language_other[]" value="{{old('language_other')[$i]}}">
                @else
                <input type="text" class="form-control lang-other" placeholder="{{__("lang_other")}}"
                    value="{{old('language_other')[$i]}}" name="language_other[]" minlength="3" maxlength="1000"
                    required>
                @endif
            </div>
            <div class="col-md-3 text-right" id="{{old('language_id')[$i]}}"
                @if(isset(old('language_id')[$i]))route="{{route('user.language.delete' ,old('language_id')[$i])}}"
                @endif>
                <input type="button" style="margin:0;max-width:100%" value="{{__('remove')}}"
                    class=" btn-sm btn-danger remove-btn-lang  certificate-btn btn" />
            </div>

    </div>

    @endfor
    @else
    <div class="form-group col-md-12 col-xs-12  d-flex d-flex-responsive">

        <div class="language-width mx-1">
            <select class="form-control lang-name" name="language_name[]">
                <option selected disabled>{{__("choose_language")}}</option>
                @foreach (\App\Services\UserService::languages() as $key => $lang)
                <option value="{{ $key }}">{{ $lang }}</option>
                @endforeach
            </select>
        </div>
        <div class="language-width mx-1">
            <select class="form-control lang-level" name="language_level[]">
                <option selected disabled>{{__("choose_language_level")}}</option>
                @foreach (\App\Services\UserService::languagesLevel() as $key => $lang)
                <option value="{{ $key }}">{{ $lang }}</option>
                @endforeach
            </select>
        </div>

        <div class="language-width mx-1 other">

        </div>
    </div>
    @endif
    </div>





    <div class=" @error('skills') has-error @enderror">
        <div class="form-group col-md-12  col-xs-12">
            <label for="skills">{{ __('user.skills') }}</label>
        </div>
        <div class="form-group col-md-12  col-xs-12">
            <input type="text" class="form-control" value="{{ old('skills') }}" name="skills" data-role="tagsinput" />
            {{-- <input type="text" class="form-control" placeholder="{{ __('user.skills') }}" name="skills"
            value="{{ old('skills') }}" autocomplete="skills" > --}}
            <p class="hint-word">{{ __('user.skillsQuote') }} <span>↵</span></p>
        </div>
        @error('skills')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    @endif
    <div class="form-group-select col-md-12 col-xs-12 @error('howDidYouFindUs') has-error @enderror">
        <select class="form-control select-howDidYouFindUs" name="howDidYouFindUs" id="howDidYouFindUs" required="">
            <option value="" disabled selected>{{ __('user.How did you find us ?') }}</option>
            @foreach(\App\AppConstants::getHowDidYouFindUsOptions() as $key => $option)
            <option @if(old('howDidYouFindUs')==$key)selected="" @endif value="{{ $key }}">{{ $option }}</option>
            @endforeach
        </select>
        @error('howDidYouFindUs')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>

    <div class=" @error('howDidYouFindUsOther') has-error @enderror invisible" id="divHowDidYouFindUsOther">
        <input type="text" id="textHowDidYouFindUsOther" class=" invisible"
            placeholder="{{ __('company.howDidYouFindUsOther') }}" name="howDidYouFindUsOther"
            value="{{ old('howDidYouFindUsOther') }}" autocomplete="howDidYouFindUsOther" minlength="3" maxlength="170">
        @error('howDidYouFindUsOther')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>

    @if (!$signupPage)
    <div class="form-group col-xs-12 @error('summary') has-error @enderror">
        <textarea class="form-control" placeholder="{{ __('user.summary') }}" name="summary" minlength="3"
            maxlength="1000">{{ old('summary') }}</textarea>
        @error('summary')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>



    @if(auth()->user() && optional(auth()->user())->personalPhoto)
    <div class="form-fields-group col-md-12">
        @endif

        <div class="form-group col-md-6 col-xs-12 @error('personalPhoto') has-error @enderror">
            <div class="s-item">
                <div class="file-upload-wrapper">
                    <span class="l-hint">{{ __('user.Personal photo') }}</span>
                    <input type="file" id="input-file-max-fs" class="file-upload" accept="image/jpeg,image/png"
                        data-rule-maxsize="1000000" name="personalPhoto"
                        data-msg-maxsize="يجب أن لا يتجاوز حجم الملف واحد ميجابايت" />
                    <span class="or-hint">{{ __('site.Or Choose photo from your device') }}</span>
                </div>
            </div>
            @error('personalPhoto')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>
        @if(auth()->user())
        <div class="form-group col-md-6 col-xs-12">
            <div class="profile-pic">
                <img src="{{ asset(Storage::disk('public')->url(optional(auth()->user())->personalPhoto))}}" width="200"
                    height="200" />
            </div>
        </div>
        @endif

        @if(auth()->user() && optional(auth()->user())->personalPhoto)
    </div>
    @endif

    @if(auth()->user() && count(optional(auth()->user())->projects) > 0 )
    <div class="form-fields-group col-md-12">
        @endif

        <div class="form-group  col-md-6 col-xs-12 @error('pastProjects.*') has-error @enderror">
            <div class="s-item">
                <div class="file-upload-wrapper" style="border: none;">
                    <div id="myDropzone" class="dropzone" data-url="{{route('user.dropzone.store')}}">

                        <span id="dropSpan">
                            <i class="fa fa-cloud-upload"></i>
                            <p class="dragAndDrop">Drag and drop</p>
                        </span>

                    </div>
                    <span class="l-hint">{{ __('user.Past projects') }} {{ __('user.(up to 5)') }}</span>
                    <!-- <br> -->

                    <span class="or-hint">{{ __('site.Or Choose file from your device') }}</span>
                </div>
                <input name="project_ids" id="project_ids" type="hidden" />
            </div>
            @error('pastProjects.*')
            <span class="help-block" role="alert">
                {{ $message }}
            </span>
            @enderror
        </div>

        @if(auth()->user())
        <div class="form-group col-md-6 col-xs-12">
            <div class="it-body col-xs-12">
                @if(count(optional(auth()->user())->projects) > 0 )
                @foreach(optional(auth()->user())->projects as $project)
                <div class="pp-item col-md-2 col-sm-6 col-xs-12">
                    <a style="width:0px; height:0px; color:red;margin-left:90px; margin-bottom: 18px;" class="delete"
                        id="deleteFile" href="{{route('user.file.delete',$project->id)}}"><i
                            class="fa fa-close "></i></a>
                    <a href="{{ asset(Storage::disk('public')->url($project->image)) }}" download><img
                            style="width: 80px;"
                            src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}" /></a>
                    {{--   <img src="{{ asset(Storage::disk('public')->url($project->image)) }}" alt="image"> --}}
                </div>
                @endforeach
                @else
                <h3 class="l-hint" style=" color:#b4c1ce; margin-right: 33%; margin-top: 70px;">
                    {{__('user.not_found_project')}}</h3>
                @endif
            </div>
        </div>
        @endif

        @if(auth()->user() && count(optional(auth()->user())->projects) > 0 )
    </div>
    @endif
    @endif


    @if($signupPage)
    <div class="form-group col-xs-12 @error('accept') has-error @enderror">
        <label class="rem">
            <input type="checkbox" name="accept" required="" {{ old('accept') ? 'checked' : '' }}>
            <span class="l-txt">{{ __('I have read and I accept the') }} <a
                    href="{{ route('terms-and-conditions') }}">{{ __('Terms and Conditions') }}</a> {{ __('and the') }}
                <a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a> ( يتم التفعيل من خلال الإيميل
                الجامعي )</span>
        </label>
        @error('accept')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    @endif
    <div class="form-group col-xs-12">
        <button type="submit" class="btn">{{ $submitButtonText }}</button>
    </div>
</form>
{{-- {{dd(\App\Services\UserService::getAllUniversityEmails())}} --}}
<script>
    let user_languages = {!!json_encode(\App\ Services\ UserService::languages()) !!}
    console.log(user_languages);
    let user_languages_level = {!!json_encode(\App\ Services\ UserService::languagesLevel()) !!}
    console.log(user_languages_level);
    let listEmail  =   {!! json_encode(\App\Services\UserService::getAllUniversityEmails())!!}
    console.log(listEmail);

</script>
