@foreach($userFinishedCompanyTasks as $task)
    <tr>
        <td data-th="{{ __('companytask.title') }}">
            <div class="it-info">
                {{-- @if($task->company->logo)
                <img src="{{ optional($task->company)->logo }}" alt="{{ $task->name }}" />
                @endif --}}
                @if($task->company->company_logo)
                <a href="{{route('company.company.detail' ,[optional($task->company)->id])}}">
                    <img src="{{ $task->company->company_logo }}"
                        alt="{{ $task->company->name }}" />
                    <span>{{optional($task->company)->name }}</span>
                </a>            
                @else 
                <a href="{{route('company.company.detail' ,[optional($task->company)->id])}}">
                    <img src="{{ asset('/frontend/images/company-default.jfif') }}"
                    alt="{{ optional($task->company)->name }}" />
                    <span>{{ optional($task->company)->name }}</span>
                </a>    
                @endif
                <div class="data">
                    <h4>{{ $task->title }}</h4>
                    <span>{{ optional($task->major)->name }}</span>
                </div>
            </div>
        </td>
        <td data-th="{{ __('companytask.price') }}">
            <div class="it-price">
                <h4>{{ $task->price }}</h4>
                <p>{{ __('companytask.SAR') }}</p>
            </div>
        </td>
        <td data-th="{{ __('companytask.startDate') }}/{{ __('companytask.endDate') }}">
            <div class="it-date">
                <p>{{ $task->startDate->format('F d') }} - {{ $task->endDate->format('J d') }}</p>
            </div>
        </td>
    </tr>
@endforeach
