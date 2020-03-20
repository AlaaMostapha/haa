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
                            @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'translated')
                            <td>{{ __( $pageData['translationPrefix'] . data_get($data, $displayOptions['accessor'] )) }}</td>
                            @elseif(isset($displayOptions['type']) && $displayOptions['type'] === 'boolean')
                            @if(object_get($data, $displayOptions['accessor'])) <i class="fa fa-check text-navy"></i>   
                            @else<i class="fa fa-close text-danger"></i> @endif 
                            @elseif(isset($displayOptions['details-type']) && $displayOptions['details-type'] ===
                            'multi-data')
                                    @php $arrLang= json_decode($data->language, true)@endphp
                                    <span>{{ (count($arrLang)>1)?implode(",",$arrLang): $arrLang[0]}}</span>
                            @elseif(isset($displayOptions['details-type']) && $displayOptions['details-type'] ===
                                    'multi-data-majors')
                                    <span>{{ (count($data->majors)>1)?implode(",",$data->majors): __('no_found_majors')}}</span>
                            @else
                            {{ data_get($data, $displayOptions['accessor']) }}
                            @endif
                        </dd>
                        @endforeach
                    </dl>
                    <hr>
                </div>
            </div>
        </div>
    </div>

    <div>
    <h3 style="color: #18a689 ;font-weight:500; display:inline; margin-left:20px"> {{__("user.total_of_student")}}  </h3> <span style="color:black;font-weight:700;">{{$usersTask->total()}}</span>  
    </div>
    @if(count($usersTask) > 0)
    <div class="row">
        <div class="col-lg-12">
                <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th> {{__("user.firstName")}}</th>
                                    <th> {{__("user.lastName")}}</th>
                                    <th> {{__("user.email")}}</th>
                                    <th> {{__('Actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($usersTask as $usertask)
                                    <tr>
                                        <td>{{optional($usertask->user)->firstName }}</td>
                                        <td>{{optional($usertask->user)->lastName }}</td>
                                        <td>{{optional($usertask->user)->email }}</td>
                                        <td> 
                                        <a href="{{route('dashboard.user.show' ,optional($usertask->user)->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> عرض</a>
                                        {{-- <a href="{{url('/user/'.optional($usertask->user)->id.'/'.optional($data)->id)}}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> {{__('View')}}</a> --}}

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                                {{$usersTask->links()}}
                        </div>

                    </div>
        </div>    
    </div>   
    @endif     
@endsection