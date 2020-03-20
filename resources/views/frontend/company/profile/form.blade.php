<form class="dev-validate-form" method="POST" action="{{ $submitUrl }}" enctype="multipart/form-data">
    @csrf
    @if (!$signupPage)
    <input type="hidden" name="_method" value="PUT">
    @endif
    <div class="form-group col-md-6 col-xs-12 @error('username') has-error @enderror">
        <input type="text" class="form-control" pattern="^\S*$" title="{{__('company.not_space_allow')}}" placeholder="{{ __('company.username') }}" name="username" value="{{ old('username') }}" required="" autofocus="" autocomplete="username" minlength="3" maxlength="170">
        @error('username')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('email') has-error @enderror">
        <input type="email" class="form-control" placeholder="{{ __('company.email') }}" name="email" value="{{ old('email') }}" required="" autocomplete="email" maxlength="170">
        @error('email')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-xs-12 @error('name') has-error @enderror">
        <input type="text" class="form-control" placeholder="{{ __('company.name') }}" name="name" value="{{ old('name') }}" required="" autocomplete="name" minlength="3" maxlength="170">
        @error('name')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('password') has-error @enderror">
        <input type="password" class="form-control" placeholder="{{ __('company.password') }}" name="password" @if($signupPage)required=""@endif autocomplete="new-password" minlength="6" maxlength="255">
               @error('password')
               <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-md-6 col-xs-12 @error('password_confirmation') has-error @enderror">
        <input type="password" class="form-control" placeholder="{{ __('company.password_confirmation') }}" name="password_confirmation" @if($signupPage)required=""@endif autocomplete="new-password" minlength="6" maxlength="255">
               @error('password_confirmation')
               <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <div class="form-group col-xs-12 @error('mobile') has-error @enderror">
        <input type="text" class="form-control english-text" placeholder="{{ __('company.mobile') }}"  maxlength="13" minlength="13" name="mobile" value="{{ old('mobile') }}" required="" autocomplete="mobile">
        <span class="english-text">Ex: +966 5X XXX XXXX</span>
        @error('mobile')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    {{-- <div class="form-group col-md-6 col-xs-12 @error('bankAccountNumber') has-error @enderror">
        <input type="text" class="form-control" placeholder="{{ __('company.bankAccountNumber') }}" name="bankAccountNumber" value="{{ old('bankAccountNumber') }}" required="" autocomplete="bankAccountNumber" minlength="3" maxlength="255">
        @error('bankAccountNumber')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div> --}}
    <div class="form-group col-md-12 col-xs-12 @error('commercialRegistrationNumber') has-error @enderror">
        <input type="text" class="form-control" placeholder="{{ __('company.commercialRegistrationNumber') }}" name="commercialRegistrationNumber" value="{{ old('commercialRegistrationNumber') }}" required="" autocomplete="commercialRegistrationNumber"  title="{{__('company.must_be_number')}}" pattern="\d*" minlength="3" maxlength="10">
        @error('commercialRegistrationNumber')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>

    <div class="form-group  col-xs-12 @error('commercialRegistrationExpiryDate') has-error @enderror">
        <input type="text" class="form-control dev-date-current-input" placeholder="{{ __('company.commercialRegistrationExpiryDate') }}" name="commercialRegistrationExpiryDate" value="{{ old('commercialRegistrationExpiryDate') }}" required="" autocomplete="commercialRegistrationExpiryDate">
        @error('commercialRegistrationExpiryDate')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>





    <div class="form-group  col-xs-12 @error('howDidYouFindUs') has-error @enderror">
        <select class="form-control" name="howDidYouFindUs" id="howDidYouFindUs" required="">
            <option value="" disabled selected>{{ __('user.How did you find us ?') }}</option>
            @foreach(\App\AppConstants::getHowDidYouFindUsOptions()   as $key => $option)
            <option @if(old('howDidYouFindUs') === $key)selected=""@endif value="{{ $key }}">{{ $option }}</option>
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
        <input type="text"  id="textHowDidYouFindUsOther"class=" invisible" placeholder="{{ __('company.howDidYouFindUsOther') }}" name="howDidYouFindUsOther" value="{{ old('howDidYouFindUsOther') }}"  autocomplete="howDidYouFindUsOther" minlength="3" maxlength="170">
        @error('howDidYouFindUsOther')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
        <b class="required">*</b>
    </div>
    <!--  Display only mandatory fields  -->
    @if(!$signupPage)
    <div class="form-group  col-md-12 col-xs-12 @error('summary') has-error @enderror">
        <textarea class="form-control" placeholder="{{ __('company.summary') }}" name="summary" minlength="3" maxlength="1000">{{ old('summary') }}</textarea>
        @error('summary')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    <div class="form-group @if(auth()->user()) col-md-6 @else col-md-12 @endif col-xs-12 @error('logo') has-error @enderror">
        <div class="s-item">
            <div class="file-upload-wrapper">
                <span class="l-hint">{{ __('company.Logo') }}</span>
                <input type="file" id="input-file-max-fs" class="file-upload" accept="image/jpeg,image/png" data-rule-maxsize="1000000" name="logo" data-msg-maxsize="يجب أن لا يتجاوز حجم الملف واحد ميجابايت" />
                <span class="or-hint">{{ __('site.Or Choose photo from your device') }}</span>
            </div>
        </div>
        @error('logo')
        <span class="help-block" role="alert">
            {{ $message }}
        </span>
        @enderror
    </div>
    @if (auth()->user())
        <div class="form-group col-md-6 col-xs-12">
                <a href="{{ asset(Storage::disk('public')->url(optional(auth()->user())->logo)) }}" download><img src="{{ asset(Storage::disk('public')->url(optional(auth()->user())->logo))}}"/></a>
        </div>
    @endif

    @endif

    @if ($signupPage)
    <div class="form-group col-xs-12 @error('accept') has-error @enderror">
        <label class="rem">
            <input type="checkbox" name="accept" required="" {{ old('accept') ? 'checked' : '' }}>
                   <span class="l-txt">{{ __('I have read and I accept the') }} <a href="{{ route('terms-and-conditions') }}">{{ __('Terms and Conditions') }}</a> {{ __('and the') }} <a href="{{ route('privacy-policy') }}">{{ __('Privacy Policy') }}</a></span>
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