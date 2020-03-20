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
                <dl class="dl-horizontal">
                    @foreach ($displayData as $displayName => $displayOptions)
                    <dt style="white-space: normal;">{{ __($pageData['translationPrefix'] . $displayOptions['accessor']) }}</dt>
                    <dd class="@isset($displayOptions['class']){{ $displayOptions['class'] }}@endisset @if(isset($displayOptions['type']) && in_array($displayOptions['type'], ['phone', 'url'])) left-text @endif">
                        @if(isset($displayOptions['type']) && $displayOptions['type'] == 'file' && data_get($data, $displayOptions['accessor']))
                        <a target="_blank" href="{{ asset(Storage::disk('public')->url(data_get($data, $displayOptions['accessor']))) }}">{{ __('Download') }}</a>
                        @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'reference')
                        {{ data_get($data, $displayOptions['displayColumn']) }}
                        @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'textarea')
                        <pre><?php echo $pageData['translationPrefix'] . data_get($data, $displayOptions['accessor'] ) ?></pre>
                        @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'translated')
                    {{ __( $pageData['translationPrefix'] . data_get($data, $displayOptions['accessor'] )) }}
                    @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'image' && Storage::disk('public')->exists( data_get($data, $displayOptions['accessor']) )    )
                    <a target="_blank" href="{{ asset(Storage::disk('public')->url(data_get($data, $displayOptions['accessor']))) }}">
                        <img src="{{ asset(Storage::disk('public')->url(data_get($data, $displayOptions['accessor']))) }}" style="height:100px; width: 100px">
                    </a>
                    @else
                    {{ data_get($data, $displayOptions['accessor']) }}
                    @endif


                            @if(isset($displayOptions['hasOther']) && $displayOptions['hasOther'] == 'true' && data_get($data, $displayOptions['accessor'].'Other' ))
                                <span style="padding : 20px;">( {{ data_get($data, $displayOptions['accessor'].'Other') }} )</span>
                            @endif

                            @if($displayName == 'pastProjects')
                                <div id="user-projects" style="width: 80%;padding: 20px;">
                                    @if(optional($data->projects) != null)
                                        @foreach($data->projects as $project)
                                            <div class="col-md-2">
                                                <a style="width:0px; height:0px; color:red;margin-bottom: 10px;"class="delete" id="deleteFile" href="{{route('user.file.delete',$project->id)}}"><i class="fa fa-close "></i></a>
                                                <a href="{{ asset(Storage::disk('public')->url($project->image)) }}" download><img style="width:100px;" src="{{ \App\AppConstants::getIconForFile(basename($project->image))}}"/></a>
                                                {{--   <img src="{{ asset(Storage::disk('public')->url($project->image)) }}" alt="image"> --}}
                                            </div>
                                        @endforeach
                                    @endif

                                </div>
                            @endif

                    </dd>
                    @endforeach
                    
                <dt style="white-space: normal;"> {{ __('user.language') }}</dt>
                    <dd class="">
                        @if(count($userLanguages) > 0)
                        <table class="table table-bordered">
                                <thead>
                                        <tr>
                                            <th scope="col">{{__('user.lang')}}</th>
                                            <th scope="col">{{ __("user.language_leval") }}</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                                @foreach ($userLanguages as $lang)
                                                        <tr>
                                                            
                                                        @if($lang->language_name == 'other')
                                                            <td>{{$lang->language_other}}</td>
                                                        @else
                                                            <td> {{$lang->user_languages}}</td>
                                                        @endif
                                                        <td> {{$lang->language_level}}</td>
                                                        </tr>    
                                                @endforeach
                                        </tbody>
                        </table>
                        @else
                            {{__('user.no_Lang_found')}}
                        @endif

                    </dd>    

                    <dt style="white-space: normal;"> {{ __('user.certificates') }}</dt>
                    <dd class="">
                        @if(count($userCertificates) > 0)
                        <table class="table table-bordered">
                                <thead>
                                        <tr>
                                            <th scope="col">{{__('user.certificates_name')}}</th>
                                            <th scope="col">{{ __("user.certificate_from") }}</th>
                                            <th scope="col">{{__('user.certificate_date')}}</th>
                                            <th scope="col">{{ __("user.certificate_description") }}</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                                @foreach ($userCertificates as $certificate)
                                                        <tr>
                                                            
                                                            <td>{{$certificate->certificate_name}}</td>
                                                            <td>{{$certificate->certificate_from}}</td>
                                                            <td> {{$certificate->certificate_date}}</td>
                                                            <td> {{$certificate->certificate_description}}</td>
                                                        </tr>    
                                                @endforeach
                                        </tbody>
                        </table>
                        @else
                            {{__('user.no_certificate_found')}}
                        @endif

                    </dd> 

                    <dt style="white-space: normal;"> {{ __('user.experinces') }}</dt>
                    <dd class="">
                        @if(count($userExperiences) > 0)
                        <table class="table table-bordered">
                                <thead>
                                        <tr>
                                            <th scope="col">{{__('user.experience_name')}}</th>
                                            <th scope="col">{{ __("user.experience_from") }}</th>
                                            <th scope="col">{{__('user.experience_date')}}</th>
                                            <th scope="col">{{ __("user.experience_description") }}</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                                @foreach ($userExperiences as $experience)
                                                        <tr>
                                                            
                                                            <td>{{$experience->experience_name}}</td>
                                                            <td>{{$experience->experience_from}}</td>
                                                            <td> {{$experience->experience_date}}</td>
                                                            <td> {{$experience->experience_description}}</td>
                                                        </tr>    
                                                @endforeach
                                        </tbody>
                        </table>
                        @else
                            {{__('user.no_experience_found')}}
                        @endif
                    </dd> 




                </dl>


            </div>
        </div>
    </div>
</div>
@endsection