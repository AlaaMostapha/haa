@component('mail::message')
#{{$data->subject}}

{{$data->description}}
@component('mail::button', ['url' => url('/join-haa')])
    {{__('Haa')}}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
