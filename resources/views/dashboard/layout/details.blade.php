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

                    </dd>
                    @endforeach
                </dl>
                <hr>
            </div>
        </div>
    </div>
</div>
@endsection