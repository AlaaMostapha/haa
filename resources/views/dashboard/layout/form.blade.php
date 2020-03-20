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

                                    @if (in_array($formComponent['type'], array('text', 'date', 'phone', 'url', 'email', 'password', 'time')))
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
                                    <input
                                            name="{{ $formComponentName }}[]"
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
