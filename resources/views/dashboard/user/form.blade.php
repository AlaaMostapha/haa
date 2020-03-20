@extends('dashboard.layout.dashboard')

@section('title', $pageData['title'])

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $pageData['title'] }}</h5>
                </div>
                <div class="ibox-content">
                    <form method="POST" novalidate="" class="form-horizontal dev-form-validate" action="{{ $formData['action'] }}" enctype="multipart/form-data">
                        @if (isset($formData['method']) && $formData['method'] === 'PUT')
                        <input type="hidden" name="_method" value="PUT">
                        @endif

                        @csrf

                        @php $textType = 'text';@endphp
                        @foreach ($formComponents as $formComponentName => $formComponent)
                            @if ($formComponent['type'] !== 'hidden' &&  $formComponent['type'] !== 'section')
                            <div class="form-group{{ $errors->has($formComponent['accessor']) ? ' has-error' : '' }}">
                                @if (!isset($formComponent['type']) || (isset($formComponent['type']) && $formComponent['type'] !== 'link'))
                                <label for="{{ $formComponentName }}" class="col-sm-2 control-label">{{ __($pageData['translationPrefix'] . $formComponent['accessor']) }}@if (isset($formComponent['attr']) && isset($formComponent['attr']['required']) && $formComponent['attr']['required']) *@endif</label>
                                @else
                                <label for="{{ $formComponentName }}" class="col-sm-2 control-label"></label>
                                @endif

                                <div class="col-sm-10">

                                    @if ($formComponent['type'] === 'time')
                                    <div class="input-group clockpicker" data-autoclose="true">
                                    @endif

                                    @if (in_array($formComponent['type'], array('text','number', 'date', 'phone', 'url', 'email', 'password', 'time')))
                                    <input id="{{ $formComponentName }}" @if($formComponent['type'] == 'password') autocomplete="off" @endif type="@if (in_array($formComponent['type'], ['time', 'date', 'phone'])){{ $textType }}@else{{ $formComponent['type'] }}@endif" class="form-control dev-{{ $formComponent['type'] }}-input @if(in_array($formComponent['type'], ['url', 'phone']))left-text @endif @isset($formComponent['class']){{ $formComponent['class'] }}@endif"@if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif name="{{ $formComponentName }}" @if($formComponent['type'] !== 'password') value="{{ old($formComponent['accessor']) }}"@endif @if ($loop->first) autofocus=""@endif>
                                    @endif

                                    @if ($formComponent['type'] === 'time')
                                        <span class="input-group-addon">
                                            <span class="fa fa-clock-o"></span>
                                        </span>
                                    </div>
                                    @endif

                                    @if (isset($formComponent['type']) && $formComponent['type'] == 'file')
                                        <input
                                                name="{{ $formComponentName }}"
                                                class="dev-upload"
                                                type="file"
                                                data-rule-maxSize="2000000"
                                                data-msg-maxSize="{{ __('max-size-error') }}"
                                                @if(old($formComponentName))
                                                    @unset($formComponent['attr']['required']);
                                                @endif;
                                                @if (isset($formComponent['attr']))
                                                    @foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue)
                                                        {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"
                                                    @endforeach
                                                @endif
                                        >
                                        @if(old($formComponentName))
                                            <a href="{{ env('UPLOAD_URL').old($formComponentName) }}" > {{ basename(old($formComponentName)) }} </a>
                                        @endif
                                    @endif

                                    @if (isset($formComponent['type']) && $formComponent['type'] == 'file-multi')


                                        <div class="s-item">
                                             <div class="file-upload-wrapper" style="border: none;">
                                                 <div id="myDropzone" class="dropzone" data-url="{{route('dashboard.dropzone.store')}}"></div>
                                                 <span class="l-hint">{{ __('user.(up to 5)') }}</span>
                                                 <br>
                                                 <span class="or-hint">{{ __('site.Or Choose file from your device') }}</span>
                                             </div>
                                             <input name="project_ids" id="project_ids" type="hidden" />
                                         </div>


                                @endif

                                    @if (isset($formComponent['type']) && $formComponent['type'] == 'image')

                                        <input
                                                class="dev-upload"
                                                name="{{ $formComponentName }}"
                                                type="file"
                                                data-rule-maxSize="2000000" data-msg-maxSize="{{ __('max-size-error') }}"
                                                @if(old($formComponentName))
                                                    @unset($formComponent['attr']['required']);
                                                @endif;
                                                @if (isset($formComponent['attr']))
                                                    @foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue)
                                                        {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"
                                                    @endforeach
                                                @endif
                                        >
                                        @if(old($formComponentName))
                                            <img src="{{ asset(Storage::disk('public')->url(old($formComponentName))) }}" height="50px" />
                                        @endif
                                    @endif

                                    @if(isset($formComponent['type']) && $formComponent['type'] == 'multi-file')
                                    <input
                                        type="hidden"
                                        id="multi-file"
                                        name="{{ $formComponentName }}"
                                        value="{{ old($formComponentName)? old($formComponentName) : '[]' }}"
                                    />
                                    <div class="form-group">
                                        <div class="col-lg-12">
                                        <input id="multi-file-input" type="file"  class="from-control">
                                        </div>
                                        <div class="col-lg-12 text-success" id='multi-file-while-uploading' style="display: none;font-size: medium;padding-top: 10px;"> {{ __('Your file is being uploaded') }}
                                        </div>
                                        <div class="col-lg-12 text-danger" id='multi-file-error'>
                                        </div>
                                    </div>

                                    <div id="multi-file-data">
                                    </div
                                @endif

                                    @if ($formComponent['type'] === 'textarea')
                                    <textarea id="{{ $formComponentName }}" class="form-control dev-auto-size @isset($formComponent['class']){{ $formComponent['class'] }}@endif"@if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif name="{{ $formComponentName }}" @if ($loop->first) autofocus=""@endif>{{ old($formComponentName) }}</textarea>
                                    @endif
                                    @if ($formComponent['type'] === 'multi-tag')
                                    {{-- <textarea id="{{ $formComponentName }}" class="form-control dev-auto-size @isset($formComponent['class']){{ $formComponent['class'] }}@endif"@if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif name="{{ $formComponentName }}" @if ($loop->first) autofocus=""@endif>{{ old($formComponentName) }}</textarea> --}}
                                    <input type="text"  id="{{ $formComponentName }}" class="form-control  @isset($formComponent['class']){{ $formComponent['class'] }}@endif" @if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif name="{{ $formComponentName }}" @if ($loop->first) autofocus=""@endif  value="{{ old($formComponentName) }}" name="skills" data-role="tagsinput" />

                                    @endif

                                    @if (isset($formComponent['type']) && $formComponent['type'] == 'radio')
                                    @foreach($formComponent['options'] as $selectOption)
                                    <div class="radio">
                                        <label><input type="radio" value="{{ $selectOption['value'] }}" name="{{ $formComponentName }}" @if(old($formComponentName) == $selectOption['value']) checked="" @endif>&nbsp; {{ $selectOption['label'] }}</label>
                                    </div>
                                    @endforeach
                                    @endif

                                    @if (isset($formComponent['type']) && in_array($formComponent['type'], ['select', 'select-other']))
                                    <select id="{{ $formComponentName }}"
                                            style="width: 100%;"
                                            class="form-control select2 @if($formComponent['type'] === 'select-other') dev-select-other @endif"
                                            @if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif
                                            name="{{ $formComponentName }}@if(isset($formComponent['attr']) && isset($formComponent['attr']['multiple']))[]@endif"
                                            @if ($loop->first) autofocus=""@endif>
                                        @if(!isset($formComponent['attr']) || !isset($formComponent['attr']['required']) || $formComponent['attr']['required'] == false)
                                        <option></option>
                                        @endif
                                        @foreach($formComponent['options'] as $selectOption)
                                        <option
                                            @if(isset($formComponent['attr']) && isset($formComponent['attr']['multiple']))
                                            @if(in_array($selectOption['value'], old($formComponentName) ? old($formComponentName) : []))selected=""@endif
                                            @else
                                            @if(old($formComponentName) == $selectOption['value'])selected=""@endif
                                            @endif
                                            @if (isset($selectOption['data']))@foreach ($selectOption['data'] as $selectOptionDataName => $selectOptionDataValue) data-{{ $selectOptionDataName }}="{{ $selectOptionDataValue }}"@endforeach
                                            @endif value="{{ $selectOption['value'] }}">{{ $selectOption['label'] }}</option>
                                        @endforeach
                                        @if($formComponent['type'] === 'select-other')
                                        <option @if(old($formComponentName) == 'other')selected=""@endif value="other">{{ __('Other') }}</option>
                                        @endif
                                    </select>
                                    @if($formComponent['type'] === 'select-other')
                                    <input type="text" value="{{ old($formComponentName . '-other') }}" name="{{ $formComponentName }}-other" class="form-control" placeholder="{{ __('Other') }}" @if(isset($formComponent['attr']) && isset($formComponent['attr']['required']) && $formComponent['attr']['required']) required="" @endif>
                                    @endif
                                    @endif

                                    @if ($errors->has($formComponent['accessor']))
                                    <span class="help-block m-b-none dev-help-error">{{ $errors->first($formComponent['accessor']) }}</span>
                                    @endif

                                    @if ($errors->has($formComponentName . '-other'))
                                    <div class="invalid-feedback">{{ $errors->first($formComponentName . '-other') }}</div>
                                    @endif

                                    @if (isset($formComponent['help']))
                                    <span class="help-block m-b-none" style="color:#676a6c !important;">{{ $formComponent['help'] }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="hr-line-dashed"></div>
                            @elseif($formComponent['type'] == 'section')
                                <h4 style="text-align: center;"> {{ __($pageData['translationPrefix'] . $formComponentName) }} </h4>
                                <hr>
                            @else
                            <input id="{{ $formComponentName }}" type="hidden" class="form-control"@if (isset($formComponent['attr']))@foreach ($formComponent['attr'] as $formComponentAttrName => $formComponentAttrValue) {{ $formComponentAttrName }}="{{ $formComponentAttrValue }}"@endforeach @endif name="{{ $formComponentName }}" value="{{ old($formComponent['accessor']) }}">
                            @endif
                        @endforeach
                        <hr/>
                    <div class="form-group">
                        <div id="user-projects" style="width: 30%;">
                                @if(isset($data) && isset($data->projects))
                                    @if(optional($data->projects) != null)
                                            @foreach($data->projects as $project)
                                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                                            <a style="width:0px; height:0px; color:red;margin-bottom: 10px;"class="delete" id="deleteFile" href="{{route('user.file.delete',$project->id)}}"><i class="fa fa-close "></i></a>
                                                            <a href="{{ asset(Storage::disk('public')->url($project->image)) }}" download><img style="width:92%;" src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}"/></a>
                                                            {{--   <img src="{{ asset(Storage::disk('public')->url($project->image)) }}" alt="image"> --}}
                                                        </div>
                                            @endforeach
                                    @endif
                                @endif
                        </div>
                    </div>
                    <br/><br/>
                    <hr/>
                    <br/>




                    <script>
                        let user_languages = {!!  json_encode(\App\Services\UserService::languages())  !!}
                        console.log(user_languages);
                        let user_languages_level = {!!  json_encode(\App\Services\UserService::languagesLevel())  !!}
                        console.log(user_languages_level);
                    </script>





<div class="col-md-12 col-xs-12" id="wrapperlang" @if(old('language_id')!== null)countraw= "{{count(old('language_id'))}}@endif">
    @if (session('failMessage_language'))
    <div class="col-xs-12 form-group">
        <div class="alert alert-danger" role="alert">
            {{ session('failMessage_language') }}
        </div>
    </div>
    @endif
    <div class="col-md-10">
                <h5> {{ __('user.language') }}</h5>
    </div>
    <div class="col-md-2">
                    <input type="button" value="{{__("add")}}" style="margin:0;background-color:#980771;color:white"id="addRawLanguage"class="btn-sm btn-pure m-0 "/>
    </div>
        @if(old('language_id')!== null && count(old('language_name')) >= 1)
            @for ($i = 0; $i < count(old('language_name')); $i++)
            <div class="form-group col-md-12 col-xs-12">
                    <div class="form-group col-md-3 col-xs-4">

                            <input type="hidden" name="language_id[]" , value="{{old('language_id')[$i]}}">

                            <select class="form-control lang-name" name="language_name[]" required>
                                        <option selected disabled>{{ __("choose_language") }}</option>
                                        @foreach (\App\Services\UserService::languages() as $key => $lang)
                                            <option  @if(old('language_name')[$i] == $key)selected=""@endif value="{{ $key }}">{{ $lang }}</option>
                                        @endforeach
                            </select>
                    </div>
                    <div class="form-group col-md-3 col-xs-4">
                            <select class="form-control lang-level" name="language_level[]" required>
                                        <option selected disabled>{{__("choose_language_level")}}</option>
                                        @foreach (\App\Services\UserService::languagesLevel() as $key => $lang)
                                            <option  @if(old('language_level')[$i] == $key)selected=""@endif value="{{ $key }}">{{ $lang }}</option>
                                        @endforeach
                            </select>
                    </div>

                    <div class="form-group col-md-3 other">
                        @if(old('language_other')[$i] == null)
                        <input type="hidden" name="language_other[]" value="{{old('language_other')[$i]}}">
                        @else 
                        <input type="text" class="form-control lang-other" placeholder="{{__("lang_other")}}" value="{{old('language_other')[$i]}}" name="language_other[]" minlength="3" maxlength="1000"  required>
                        @endif
                    </div>


                    <div class="col-md-2" id="{{old('language_id')[$i]}}" @if(isset(old('language_id')[$i]))route="{{route('dashboard.language.delete' ,['languageId'=>old('language_id')[$i] ,'userId'=>$data->id])}}"@endif>
                            <input type="button"  style="margin:0;" value="remove" class=" btn-sm btn-danger remove-btn-lang"/>
                    </div>

                </div>

            @endfor        
        @else
            <div class="form-group col-md-12 col-xs-12">

                <div class="form-group col-md-3 col-xs-4">
                        <select class="form-control lang-name" name="language_name[]">
                            <option selected disabled>{{__("choose_language")}}</option>
                                    @foreach (\App\Services\UserService::languages() as $key => $lang)
                                        <option  value="{{ $key }}">{{ $lang }}</option>
                                    @endforeach
                        </select>
                </div>
                <div class="form-group col-md-3 col-xs-4">
                            <select class="form-control lang-level" name="language_level[]">
                            <option selected disabled>{{__("choose_language_level")}}</option>
                                    @foreach (\App\Services\UserService::languagesLevel() as $key => $lang)
                                        <option  value="{{ $key }}">{{ $lang }}</option>
                                    @endforeach
                        </select>
                </div>

                <div class="form-group col-md-3 other">

                </div>
            </div>
        @endif
</div>


                        <br/><br/>
                        <hr/>

                        <!-- start -->
                        <div class="form-group col-md-12 col-xs-12 @error('certificates') has-error @enderror" id="wrapper_certificates"  @if(old('id')!== null) countraw= "{{count(old('id'))}}"@endif>
                            @if (session('failMessage_certificate'))
                            <div class="col-xs-12 form-group">
                                <div class="alert alert-danger" role="alert">
                                    {{ session('failMessage_certificate') }}
                                </div>
                            </div>
                            @endif
                            <div class="col-md-10">
                                <h5> {{ __('user.certificates') }}</h5>
                            </div>
                            <div class="col-md-2">
                                    <input type="button" value="{{__("add")}}" style="margin:0;background-color:#980771;color:white"id="addRaw"class="btn-sm m-0 "/>
                            </div>
                            @if(old('certificate_name')!== null && count(old('certificate_name')) >= 1)
                                @for ($i = 0; $i < count(old('certificate_name')); $i++)
                                    <div class="form-group col-md-12 col-xs-12">
                                        <div class="col-md-2">
                                        <input type="hidden" name="certificate_id[]" value="{{old('id')[$i]}}" />
                                        <input type="text" value="{{old('certificate_name')[$i]}}" class="form-control is-required"   placeholder="{{ __('user.certificate_name') }}" name="certificate_name[]" minlength="3" maxlength="1000" required>
                                        </div>
                                        <div class="col-md-2">
                                            <input type="text" value="{{old('certificate_from')[$i]}}" class="form-control is-required" placeholder="{{ __('user.certificate_from') }}" name="certificate_from[]" minlength="3" maxlength="1000" required>
                                        </div> 
                                        <div class="col-md-2">
                                                <input type="text" value="{{old('certificate_date')[$i]}}" class="form-control dev-date-current-input is-required" placeholder="{{ __('user.certificate_date') }}" name="certificate_date[]"  required>
                                        </div>   
                                        <div class="col-md-2">    
                                            <input type="text" value="{{old('certificate_description')[$i]}}" class="form-control is-required" placeholder="{{ __('user.certificate_description') }}" name="certificate_description[]" minlength="3" maxlength="1000" required>
                                        </div>
        
                                    <div class="col-md-2" id="{{old('id')[$i]}}" @if(isset(old('id')[$i])) route-link="{{route('dashboard.certificate.delete' ,['certificateId'=>old('id')[$i] ,'userId' =>$data->id])}}"@endif>
                                                <input type="button"  style="margin:0;" value="remove" class=" btn-sm btn-danger remove-btn"/>
                                        </div>
                                    </div>  
                            @endfor
                        @else
                            <div class="form-group col-md-12 col-xs-12">
                                <div class="col-md-2">
                                <input type="text" value="" class="form-control is-required"   placeholder="{{ __('user.certificate_name') }}" name="certificate_name[]" minlength="3" maxlength="1000">
                                @error('certificate_name.*')
                                <span class="help-block" role="alert">
                                    {{ $message }}
                                </span>
                                @enderror
                                </div>
                                <div class="col-md-2">
                                    <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.certificate_from') }}" name="certificate_from[]" minlength="3" maxlength="1000">
                                    @error('certificate_from.*')
                                    <span class="help-block" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div> 
                                <div class="col-md-2">
                                        <input type="text" value="" class="form-control dev-date-current-input is-required" placeholder="{{ __('user.certificate_date') }}" name="certificate_date[]">
                                        @error('certificate_date.*')
                                        <span class="help-block" role="alert">
                                            {{ $message }}
                                        </span>
                                        @enderror
                                </div>   
                                <div class="col-md-2">    
                                    <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.certificate_description') }}" name="certificate_description[]" minlength="3" maxlength="1000">
                                    @error('certificate_description.*')
                                    <span class="help-block" role="alert">
                                        {{ $message }}
                                    </span>
                                    @enderror
                                </div>
                                {{-- <div class="col-md-2" id="{{old('id')[$i]}}" route="{{url('certificate/'.old('id')[$i] .'/delete')}}">
                                        <input type="button"  style="margin:0;" value="remove" class="btn btn-danger btn-sm remove-btn"/>
                                </div> --}}
                            </div>
                        @endif 
        
                        {{-- <textarea class="form-control" placeholder="{{ __('user.certificates') }}" name="certificates" minlength="3" maxlength="1000">{{ old('certificates') }}</textarea>
                        @error('certificates')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror --}}
                    </div>
                        <!-- end -->


                        <!--  START EXPERINCE -->


            <!-- -->
            <div class="form-group col-md-12 col-xs-12 @error('experiences') has-error @enderror" id="wrapper_experiences"  @if(old('experience_id')!== null) countraw-experience = "{{count(old('experience_id'))}}"@endif>
                @if (session('failMessage_certificate'))
                <div class="col-xs-12 form-group">
                    <div class="alert alert-danger" role="alert">
                        {{ session('failMessage_experience') }}
                    </div>
                </div>
                @endif
                    <div class="d-flex d-flex-responsive mb-3">
                    <div class="col-md-10">
                    <h3 class="lHight-2"> {{ __('user.experiences') }}</h3>
                </div>
                <div class="col-md-2 text-center">
                        <input type="button" value="{{__("add")}}" style="margin:0;background-color:#980771;color:white"id="addRawExperience"class="btn-sm m-0 btn certificate-btn "/>
                </div>
                </div>
                @if(old('experience_name')!== null &&  count(old('experience_name')) >= 1)
                    @for ($i = 0; $i < count(old('experience_name')); $i++)
                        <div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive">
                            <div class="col-md-2">
                                <input type="hidden" name="experience_id[]" value="{{old('experience_id')[$i]}}" />
                                <input type="text" value="{{old('experience_name')[$i]}}" class="form-control is-required"   placeholder="{{ __('user.experience_name') }}" name="experience_name[]" minlength="3" maxlength="80" required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" value="{{old('experience_from')[$i]}}" class="form-control is-required" placeholder="{{ __('user.experience_from') }}" name="experience_from[]" minlength="3" maxlength="80" required>
                            </div>
                            <div class="col-md-2">
                                    <input type="text" value="{{old('experience_date')[$i]}}" class="form-control dev-date-current-input is-required" placeholder="{{ __('user.experience_date') }}" name="experience_date[]"  required>
                            </div>
                            <div class="col-md-2">
                                <input type="text" value="{{old('experience_description')[$i]}}" class="form-control is-required" placeholder="{{ __('user.experience_description') }}" name="experience_description[]" minlength="3" maxlength="80" required>
                            </div>

                        <div class="certificate-width mx-1 align-self-center text-center" id="{{old('experience_id')[$i]}}" @if(isset(old('experience_id')[$i])) route-link="{{route('user.experience.delete' ,old('experience_id')[$i])}}"@endif>
                                    <input type="button"  style="margin:0;" value="{{__('remove')}}" class=" btn-sm btn-danger remove-btn-experience certificate-btn btn"/>
                            </div>
                        </div>
                @endfor
            @else
                <div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive">
                    <div class="col-md-2">
                    <input type="text" value="" class="form-control is-required"   placeholder="{{ __('user.experience_name') }}" name="experience_name[]" minlength="3" maxlength="80">
                    @error('experience_name.*')
                    <span class="help-block" role="alert">
                        {{ $message }}
                    </span>
                    @enderror
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.experience_from') }}" name="experience_from[]" minlength="3" maxlength="80">
                        @error('experience_from.*')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>
                    <div class="col-md-2">
                            <input type="text" value="" class="form-control dev-date-current-input is-required" placeholder="{{ __('user.experience_date') }}" name="experience_date[]" minlength="3" maxlength="80">
                            @error('experience_date.*')
                            <span class="help-block" role="alert">
                                {{ $message }}
                            </span>
                            @enderror
                    </div>
                    <div class="col-md-2">
                        <input type="text" value="" class="form-control is-required" placeholder="{{ __('user.experience_description') }}" name="experience_description[]" minlength="3" maxlength="80">
                        @error('experience_description.*')
                        <span class="help-block" role="alert">
                            {{ $message }}
                        </span>
                        @enderror
                    </div>

                </div>
            @endif
        </div>
        <!--  END EXPERINCE -->












                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" id="submit" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
