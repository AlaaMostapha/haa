@if (isset($rowActions) && is_array($rowActions) && count($rowActions) > 0)
    <td class="hidden-print">
        @if(count($rowActions) == 1)
            @foreach ($rowActions as $actionName => $actionOptions)
                <?php
                    $route = '#';
                    $attr = '';
                    $data = '';
                    $is_visible = true ;
                    
                    if(isset($actionOptions['route']) ){
                        $params = [] ;
                        if(
                            isset($actionOptions['route-params']) &&
                            is_array($actionOptions['route-params']) &&
                            count($actionOptions['route-params']) > 0
                        ){
                            foreach($actionOptions['route-params'] as $param => $val){
                                $params[$param] = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                            }
                        }
                        $route = route($actionOptions['route'], $params);
                        if(
                            isset($actionOptions['route-get-params']) &&
                            is_array($actionOptions['route-get-params']) &&
                            count($actionOptions['route-get-params']) > 0
                        ){
                            $get_params = "?";
                            foreach($actionOptions['route-get-params'] as $param => $val){
                                $val = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                                $get_params .= "$param=$val" ;
                            }
                            $route .= $get_params;

                        }
                    }elseif(isset($actionOptions['custom-show-route']) && isset($actionOptions['custom-show-route-attr']) && $dataRow->request_id !== null && object_get($dataRow, $actionOptions['custom-show-route-attr']) !== ''){
                        $params = [] ;
                        if(
                            isset($actionOptions['route-params']) &&
                            is_array($actionOptions['route-params']) &&
                            count($actionOptions['route-params']) > 0
                        ){
                            foreach($actionOptions['route-params'] as $param => $val){
                                $params[$param] = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                            }
                        }

                        $route = route(ucfirst(object_get($dataRow, $actionOptions['custom-show-route-attr'])) .'Request.show' , $params);
                        if(
                            isset($actionOptions['route-get-params']) &&
                            is_array($actionOptions['route-get-params']) &&
                            count($actionOptions['route-get-params']) > 0
                        ){
                            $get_params = "?";
                            foreach($actionOptions['route-get-params'] as $param => $val){
                                $val = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                                $get_params .= "$param=$val" ;
                            }
                            $route .= $get_params;

                        }
                    }

                    if(
                        isset($actionOptions['attr']) &&
                        is_array($actionOptions['attr']) &&
                        count($actionOptions['attr']) > 0
                    ){
                        foreach($actionOptions['attr'] as $attrname => $val){
                            $attr .= ' '.$attrname.' = "'.$val.'" ';
                        }
                    }
                    if(
                        isset($actionOptions['data']) &&
                        is_array($actionOptions['data']) &&
                        count($actionOptions['data']) > 0
                    ){
                        foreach($actionOptions['data'] as $dataname => $dataVal){
                            $val = $dataVal === false? object_get($dataRow, $dataname)  : object_get($dataRow, $dataVal)? object_get($dataRow, $dataVal) : $dataVal;
                            $data .= ' data-'.$dataname.' = "'.$val.'" ';
                        }
                    }

                    if(isset($actionOptions['if'])){
                        $is_visible = ($actionOptions['if'])? object_get($dataRow, $actionOptions['if'])? object_get($dataRow, $actionOptions['if']) : object_get($dataRow, $actionOptions['if']): false;
                    }
                    ?>
                @if($is_visible)
                    <button
                        data-url ="{{ $route }}"
                        class="drop-btn {{ isset($actionOptions['class'])? $actionOptions['class'] : '' }}"
                        {{  $attr }}
                        {!! $data !!}
                        >
                        @if(isset($actionOptions['icon']))
                            <i class="{{ $actionOptions['icon'] }}">&nbsp;</i>
                        @endif
                            {{ isset($actionOptions['label'])? __($actionOptions['label']) : __($actionName) }}
                    </button>
                @endif
            @endforeach
        @else
        <div class="btn-group"  >
                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                        {{ __('Actions') }}
                        <i class="fa fa-caret-down"></i>
                            </button>
                <ul class="dropdown-menu" role="menu" style="min-width:auto; margin: 0 -20px;position: inherit;">
                    @foreach ($rowActions as $actionName => $actionOptions)
                        <li>
                                <?php
                                $route = '#';
                                $attr = '';
                                $data = '';
                                $is_visible = true ;
                                if(isset($actionOptions['route']) ){
                                    $params = [] ;
                                    if(
                                        isset($actionOptions['route-params']) &&
                                        is_array($actionOptions['route-params']) &&
                                        count($actionOptions['route-params']) > 0
                                    ){
                                        foreach($actionOptions['route-params'] as $param => $val){
                                            $params[$param] = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                                        }
                                    }
                                    $route = route($actionOptions['route'], $params);
                                    if(
                                        isset($actionOptions['route-get-params']) &&
                                        is_array($actionOptions['route-get-params']) &&
                                        count($actionOptions['route-get-params']) > 0
                                    ){
                                        $get_params = "?";
                                        foreach($actionOptions['route-get-params'] as $param => $val){
                                            $val = $val === false? object_get($dataRow, $param) : object_get($dataRow, $val)? object_get($dataRow, $val) : $val ;
                                            $get_params .= "$param=$val" ;
                                        }
                                        $route .= $get_params;

                                    }
                                }
                                if(
                                    isset($actionOptions['attr']) &&
                                    is_array($actionOptions['attr']) &&
                                    count($actionOptions['attr']) > 0
                                ){
                                    foreach($actionOptions['attr'] as $attrname => $val){
                                        $attr .= ' '.$attrname.' = "'.$val.'" ';
                                    }
                                }
                                if(
                                    isset($actionOptions['data']) &&
                                    is_array($actionOptions['data']) &&
                                    count($actionOptions['data']) > 0
                                ){
                                    foreach($actionOptions['data'] as $dataname => $dataVal){
                                        $val = $dataVal === false? object_get($dataRow, $dataname)  : object_get($dataRow, $dataVal)? object_get($dataRow, $dataVal) : $dataVal;
                                        $data .= ' data-'.$dataname.' = "'.$val.'" ';
                                    }
                                }

                                if(isset($actionOptions['if'])){
                                    $is_visible = ($actionOptions['if'])? object_get($dataRow, $actionOptions['if'])? object_get($dataRow, $actionOptions['if']) : object_get($dataRow, $actionOptions['if']): false;
                                }
                            ?>
                            @if($is_visible)
                                <button
                                    data-url ="{{ $route }}"
                                    class="drop-btn {{ isset($actionOptions['class'])? $actionOptions['class'] : '' }}"
                                    {{ $attr }}
                                    {!! $data !!}
                                    >
                                    @if(isset($actionOptions['icon']))
                                        <i class="{{ $actionOptions['icon'] }}">&nbsp;</i>
                                    @endif
                                        {{ isset($actionOptions['label'])? __($actionOptions['label']) : __($actionName) }}
                                </button>
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    <td>
@endif
