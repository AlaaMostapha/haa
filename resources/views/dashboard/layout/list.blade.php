@extends('dashboard.layout.dashboard')

@isset($pageData['title'])
@section('title', $pageData['title'])
@endisset

@section('content')
    @if(isset($pageData['containsFilters']) && $pageData['containsFilters'])
    <div class="ibox-content m-b-sm border-bottom hidden-print">
        <form class="dev-filter-form">
            <div class="row">
                @php $filterIndex = 1;@endphp
                @foreach ($displayedDataInfromation as $filterName => $listFilter)
                @isset($listFilter['filterType'])
                <div class="col-sm-4">
                    <div class="form-group">
                        <label class="control-label" for="filter{{ $filterName }}">{{ __( $pageData['translationPrefix'] . $filterName) }}</label>
                        @if($listFilter['filterType'] == 'date')
                        <div class="input-group date dev-date-filter-container">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        @endif
                        @if(in_array($listFilter['filterType'], ['date', 'text']))
                            <input type="text" id="filter{{ $filterName }}" name="filters[{{ $filterName }}]" value="@isset(request('filters')[$filterName]){{ request('filters')[$filterName] }}@endisset" class="form-control dev-input-filter dev-{{ $listFilter['filterType'] }}-filter @isset($listFilter['class']){{ $listFilter['class'] }}@endif">
                        @elseif($listFilter['filterType'] === 'select')
                            <select id="filter{{ $filterName }}" name="filters[{{ $filterName }}]" class="form-control dev-input-filter dev-select-filter select2 @isset($listFilter['class']){{ $listFilter['class'] }}@endif">
                                <option></option>
                                @foreach($listFilter['options'] as $selectOption)
                                <option @if(isset(request('filters')[$filterName]) && request('filters')[$filterName] == $selectOption['value'])selected=""@endif value="{{ $selectOption['value'] }}">{{ $selectOption['label'] }}</option>
                                @endforeach
                           </select>
                        @elseif($listFilter['filterType'] === 'numberrange')
                            <div class="input-group">
                                <input type="text" id="filter{{ $filterName }}" name="filters[{{ $filterName }}][from]" value="@isset(request('filters')[$filterName]['from']){{ request('filters')[$filterName]['from'] }}@endisset" class="form-control input-sm dev-input-filter @isset($listFilter['class']){{ $listFilter['class'] }}@endif" />
                                <span class="input-group-addon">{{ __('to') }}</span>
                                <input type="text" id="filter{{ $filterName }}To" name="filters[{{ $filterName }}][to]" value="@isset(request('filters')[$filterName]['to']){{ request('filters')[$filterName]['to'] }}@endisset" class="form-control input-sm dev-input-filter @isset($listFilter['class']){{ $listFilter['class'] }}@endif" />
                            </div>
                        @else($listFilter['filterType'] === 'daterange')
                            <div class="input-group date dev-daterange-filter-container">
                                <input type="text" id="filter{{ $filterName }}" name="filters[{{ $filterName }}][from]" value="@isset(request('filters')[$filterName]['from']){{ request('filters')[$filterName]['from'] }}@endisset" class="form-control input-sm dev-input-filter dev-date-filter @isset($listFilter['class']){{ $listFilter['class'] }}@endif" />
                                <span class="input-group-addon">{{ __('to') }}</span>
                                <input type="text" id="filter{{ $filterName }}To" name="filters[{{ $filterName }}][to]" value="@isset(request('filters')[$filterName]['to']){{ request('filters')[$filterName]['to'] }}@endisset" class="form-control input-sm dev-input-filter dev-date-filter @isset($listFilter['class']){{ $listFilter['class'] }}@endif" />
                            </div>
                        @endif
                        @if($listFilter['filterType'] == 'date')
                        </div>
                        @endif
                    </div>
                </div>
                @if(($filterIndex % 3) == 0)
                <div class="clearfix"></div>
                @endif
                @php $filterIndex++;@endphp
                @endisset
                @endforeach
            </div>
            <noscript>
            <button type="submit"></button>
            </noscript>
        </form>
    </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    @isset($pageData['title'])
                    <h5>{{ $pageData['title'] }}</h5>
                    @endisset
                    <div class="ibox-tools hidden-print">
                        <span class="text-center" style="margin: 2px;">{{ __('Total') }} {{ $dataArray->total() }} {{ $pageData['unit'] }}</span>
                        @isset($listActions)

                        @foreach($listActions as $listAction)

                            @if (!isset($listAction['type']) || $listAction['type'] === 'create')
                            <a href="{{ isset($listAction['url']) ? $listAction['url'] : route('dashboard.' .  $pageData['translationPrefix'] . 'create') }}" class="btn btn-white btn-sm">{{ __('Create') }}</a>
                            @elseif(isset($listAction['type']) && $listAction['type'] === 'export-excel')
                            @if($dataArray->total() > 0)
                            <a href="{{ route('dashboard.' .  $pageData['translationPrefix'] . 'export', request()->query()) }}" class="btn btn-primary btn-sm" style="margin: 5px;"><i class="ft-download"></i> {{ __('Export excel') }}</a>
                            @endif
                            @elseif(isset($listAction['type']) && $listAction['type'] === 'export-pdf')
                            @if($dataArray->total() > 0)
                            <a href="{{ route('dashboard.' .  $pageData['translationPrefix'] . 'export', array_merge(request()->query(), ['exportFormat' => 'pdf'])) }}" class="btn btn-primary btn-sm" style="margin: 5px;"><i class="ft-download"></i> {{ __('Export pdf') }}</a>
                            @endif
                            @else
                            <a href="{{ $listAction['url'] }}" class="btn btn-primary btn-sm" style="margin: 5px;">@if(isset($listAction['icon']))<i class="{{ $listAction['icon'] }}"></i>@else<i class="ft-plus"></i>@endif {{ $listAction['label'] }}</a>
                            @endif

                            {{--
                            @isset ($listActions['exportExcel'])
                            <a href="{{ $listActions['exportExcel']['url'] }}" title="{{ __('Export as excel file') }}" class="btn btn-white btn-sm"><i class="fa fa-file-excel-o"></i></a>
                            @endisset
                            @isset ($listActions['exportPDF'])
                            <a href="{{ $listActions['exportPDF']['url'] }}" title="{{ __('Export as pdf file') }}" class="btn btn-white btn-sm"><i class="fa fa-file-pdf-o"></i></a>
                            @endisset
                            @isset ($listActions['importCSV'])
                            <form style="display: inline;" method="POST" enctype="multipart/form-data" class="dev-import-form" action="{{ $listActions['importCSV']['url'] }}">
                                @csrf
                                <input type="file" name="importFile" style="display: none;" class="dev-import-file" />
                                <button type="button" title="{{ __('Import from csv file') }}" class="btn btn-sm btn-white dev-import-button"><i class="fa fa-arrow-circle-up"></i></button>
                            </form>
                            <a href="{{ $listActions['importCSV']['templateUrl'] }}" class="btn btn-white btn-sm">{{ __('CSV template') }}</a>
                            @endisset
                            --}}

                        @endforeach
                        @endisset
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="m-b-lg">
                        <div class="m-t-md dev-multiple-rows-actions" style="display: none;">
                            @if (isset($multipleRowsActions) && count($multipleRowsActions) > 0)
                            @foreach ($multipleRowsActions as $action)
                            @if(isset($action['type']) && $action['type'] === 'reject')
                            <button type="button" data-redirect-to="{{ route('dashboard.' . $pageData['translationPrefix'] . 'index') }}" data-toggle="modal" data-target="#confirmModal" data-confirm-message="{{ __('Are you sure you want to reject the requests ?') }}" data-url="{{ route('dashboard.' .  $pageData['translationPrefix'] . 'reject') }}" class="dev-multiple-action btn btn-danger btn-sm" style="margin: 5px;"><i class="fa fa-close"></i> {{ __('Reject') }}</button>
                            @elseif(isset($action['type']) && $action['type'] === 'accept')
                            <button type="button" data-redirect-to="{{ route('dashboard.' . $pageData['translationPrefix'] . 'index') }}" data-toggle="modal" data-target="#confirmModal" data-confirm-message="{{ __('Are you sure you want to accept the requests ?') }}" data-url="{{ route('dashboard.' .  $pageData['translationPrefix'] . 'accept') }}" class="dev-multiple-action btn btn-success btn-sm" style="margin: 5px;"><i class="fa fa-check"></i> {{ __('Accept') }}</button>
                            @elseif(isset($action['type']) && $action['type'] === 'send_email_user')
                            <button class="dev-multiple-action btn btn-success btn-sm btn-info dev-send-email" style="margin: 5px;" type="button" data-toggle="modal" data-target="#sendEmailUser" 
                                data-url="{{ route($action['route']) }}"  data-ids="">
                                            <i class="fa fa-refresh"></i> {{ __('user.send_email_user') }}
                            </button>
                            @elseif(isset($action['type']) && $action['type'] === 'send_email_company')
                            <button class="dev-multiple-action btn btn-success btn-sm btn-info dev-send-email" style="margin: 5px;" type="button" data-toggle="modal" data-target="#sendEmailUser" 
                                data-url="{{ route($action['route']) }}"  data-ids="">
                                            <i class="fa fa-refresh"></i> {{ __('company.send_email_company') }}
                            </button>

                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                    @if (count($dataArray) > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    @if (isset($multipleRowsActions) && count($multipleRowsActions) > 0)
                                    <th class="hidden-print"><input type="checkbox" class="dev-select-all"></th>
                                    @endif

                                    @foreach ($displayedDataInfromation as $displayRowName => $displayedRowInfromation)
                                    <th>@if (isset($displayedRowInfromation['sortUrl']) && $displayedRowInfromation['sortUrl'])<a href="{{ $displayedRowInfromation['sortUrl'] }}">@endif{{ __($pageData['translationPrefix'] . $displayRowName) }}@if (isset($displayedRowInfromation['sortUrl']) && $displayedRowInfromation['sortUrl']) <i class="@isset ($displayedRowInfromation['sortDirection'])fa fa-sort-{{ $displayedRowInfromation['sortDirection'] }}@else fa fa-sort @endisset"></i></a>@endif</th>
                                    @endforeach

                                    @if (count($rowActions) > 0)
                                    <th class="hidden-print">{{ __('Actions') }}</th>
                                    @endif


                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataArray as $dataRow)
                                <tr>
                                    @if (isset($multipleRowsActions) && count($multipleRowsActions) > 0)
                                    <td class="hidden-print"><input type="checkbox" name="ids[]" class="dev-select-row" value="{{ $dataRow->id }}"></td>
                                    @endif
                                    @foreach ($displayedDataInfromation as $displayRowName => $displayedRowInfromation)
                                        @if(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'reference')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>@if(data_get($dataRow, $displayRowName)){{ data_get($dataRow, $displayedRowInfromation['displayColumn']) }}@endif</td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'boolean')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>@if(data_get($dataRow, $displayRowName))@if(!isset($exportPDF)) <i class="fa fa-check text-navy"></i> @else {{ __('Yes') }} @endif @else @if(!isset($exportPDF))<i class="fa fa-close text-danger"></i> @else {{ __('No') }} @endif @endif</td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'color')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>@if(data_get($dataRow, $displayRowName)) <span class="label" style="background-color: {{ data_get($dataRow, $displayRowName) }};color: black;">{{ data_get($dataRow, $displayRowName) }}</span> @endif</td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'date')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>@if(data_get($dataRow, $displayRowName)){{ data_get($dataRow, $displayRowName)->format('d-m-Y') }}@endif</td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'helper')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>{{ call_user_func($displayedRowInfromation['name'], data_get($dataRow, $displayRowName)) }}</td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'link')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset><a href="{{ route($displayedRowInfromation['route'], ['filters[' . $displayedRowInfromation['searchParameterName'] . ']' => data_get($dataRow, $displayedRowInfromation['searchParameter'] )]) }}">{{ data_get($dataRow, $displayRowName) }}</a></td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'phone')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}"@else class="left-text" @endisset><a href="tel:{{ data_get($dataRow, $displayRowName) }}">{{ data_get($dataRow, $displayRowName) }}</a></td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'email')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset><a href="mailto:{{ data_get($dataRow, $displayRowName) }}">{{ data_get($dataRow, $displayRowName) }}</a></td>
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'translated')
                                            <td>{{ __( $pageData['translationPrefix'] . data_get($dataRow, $displayRowName) ) }}</td>   
                                        @elseif(isset($displayedRowInfromation['type']) && $displayedRowInfromation['type'] === 'image')
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>@if(data_get($dataRow, $displayRowName))<img @isset($displayedRowInfromation['width'])width="{{ $displayedRowInfromation['width'] }}"@else width="80" @endisset @isset($displayedRowInfromation['height'])height="{{ $displayedRowInfromation['height'] }}"@else height="60" @endisset src="{{ asset(Storage::disk('public')->url(data_get($dataRow, $displayRowName))) }}" />@endif</td>
                                        @else
                                            <td @isset($displayedRowInfromation['class']) class="{{ $displayedRowInfromation['class'] }}" @endisset>{{ data_get($dataRow, $displayRowName) }}</td>
                                        @endif
                                    @endforeach

                                    @if (count($rowActions) > 0)
                                    <td class="hidden-print">
                                        @foreach ($rowActions as $rowAction)

                                            @if(!isset($rowAction['type']) || $rowAction['type'] === 'show')
                                                <a href="{{ route(isset($rowAction['route']) ? $rowAction['route'] : 'dashboard.'. $pageData['translationPrefix'] . 'show', ['id' => $dataRow->id]) }}" class="btn btn-white btn-sm"><i class="fa fa-eye"></i> {{ __('Show') }}</a>
                                            @elseIf($rowAction['type'] === 'edit')
                                                <a href="{{ route(isset($rowAction['route']) ? $rowAction['route'] : 'dashboard.'. $pageData['translationPrefix'] . 'edit', ['id' => $dataRow->id]) }}" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i> {{ __('Edit') }}</a>
                                            @elseIf($rowAction['type'] === 'delete')
                                                <button type="button" data-toggle="modal" data-target="#deleteModal" data-url="{{ route($rowAction['route'], ['id' => $dataRow->id]) }}" class="btn btn-sm btn-danger dev-delete-confirm"><i class="fa fa-trash"></i> {{ __('Delete') }}</button>
                                            @elseIf($rowAction['type'] === 'confirmDelete')
                                                <button type="button" data-toggle="modal" data-target="#confirmDeleteModal" data-url="{{ route($rowAction['route'], ['id' => $dataRow->id]) }}" class="btn btn-sm btn-danger dev-delete-confirm"><i class="fa fa-trash"></i> {{ __('Delete') }}</button>
                                            @elseIf($rowAction['type'] === 'activate')
                                                @if(isset($rowAction['displayParameter']) && data_get($dataRow, $rowAction['displayParameter']))
                                                <button type="button" data-toggle="modal" data-target="#confirmActivateModal" data-url="{{ route($rowAction['route'], ['id' => $dataRow->id]) }}" class="btn btn-sm btn-info dev-activate-confirm"><i class="fa fa-check"></i> {{ __('Activate') }}</button>
                                                @endif
                                            @elseIf($rowAction['type'] === 'deactivate')
                                                @if(isset($rowAction['displayParameter']) && !data_get($dataRow, $rowAction['displayParameter']))
                                                <button type="button" data-toggle="modal" data-target="#confirmDeactivateModal" data-url="{{ route($rowAction['route'], ['id' => $dataRow->id]) }}" class="btn btn-sm btn-warning dev-deactivate-confirm"><i class="fa fa-close"></i> {{ __('Deactivate') }}</button>
                                                @endif        
                                            @elseIf($rowAction['type'] === 'link')
                                            @php $routeParameters = isset($rowAction['routeParameters']) ? $rowAction['routeParameters'] : [];@endphp
                                            <a href="{{ route($rowAction['route'], array_merge([$rowAction['searchParameterName'] => data_get($dataRow, $rowAction['searchParameter'] )], $routeParameters)) }}" class="btn btn-primary btn-sm">{{ $rowAction['label'] }}</a>
                                            @endif
                                        @endforeach
                                    </td>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if(!isset($exportPDF))
                    <div class="hr-line-dashed"></div>
                    <div class="text-center hidden-print">
                        {{ $dataArray->links() }}
                    </div>
                    @endif
                    @else
                    {{ __('No data found') }}
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(!isset($exportPDF))
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeleteModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmDeleteModalTitle">{{ __('Delete') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset</h4>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset @if(app()->getLocale() === 'ar')؟@else?@endif {{ __('You will not be able to undo this action !') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                    <button type="button" class="btn btn-primary dev-confirm-delete-ok">{{ __('Yes') }} </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="deleteModalTitle">{{ __('Delete') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset</h4>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset @if(app()->getLocale() === 'ar')؟@else?@endif {{ __('You will not be able to undo this action !') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                    <button type="button" class="btn btn-primary dev-delete-ok" data-style="expand-right">{{ __('Yes') }} </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmDeactivateModal" tabindex="-1" role="dialog" aria-labelledby="confirmDeactivateModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmDeactivateModalTitle">{{ __('Deactivate') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset</h4>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to deactivate this') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset @if(app()->getLocale() === 'ar')؟@else?@endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                    <button type="button" class="btn btn-primary dev-deactivate-ok" data-style="expand-right">{{ __('Yes') }} </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="confirmActivateModal" tabindex="-1" role="dialog" aria-labelledby="confirmActivateModalTitle">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="confirmActivateModalTitle">{{ __('Activate') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset</h4>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to activate this') }}@isset($pageData['unit']) {{ $pageData['unit'] }}@endisset @if(app()->getLocale() === 'ar')؟@else?@endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                    <button type="button" class="btn btn-primary dev-activate-ok" data-style="expand-right">{{ __('Yes') }} </button>
                </div>
            </div>
        </div>
    </div>
    @endif
@endsection