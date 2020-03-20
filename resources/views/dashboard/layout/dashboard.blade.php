<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="google-site-verification" content="Gf-UG-bE6lHqOJmWzG7_pk8Q6o1St84QC6NLYt8lE08" />
        <title>{{ __(config('app.name')) }} | @yield('title')</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="{{ mix('/dashboard/css/vendor.css') }}" rel="stylesheet">
        <link href="{{ mix('/dashboard/css/app.css') }}" rel="stylesheet"> @isset($exportPDF)
        <link href="{{ URL::asset('/css/pdf-export.css') }}" rel="stylesheet"> @endisset @if(app()->getLocale() === 'ar')
        <link href="{{ mix('/dashboard/css/rtl.min.css') }}" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/moment.js/2.5.1/moment.min.js"></script>            

        <style>
        </style>
        @endif
        <style>
            *:not(i) {
                font-family: '29LT Bukra' !important;
            }

            .drop-btn {
                margin: 5px 20px;
            }

            .toast-info {
                background-image: none !important;
            }

            .clockpicker-popover {
                z-index: 2250 !important;
            }

            .clockpicker {
                margin-bottom: 5px;
            }

            .select2 {
                width: 100%;
            }

            .selection {
                width: 100%;
            }

        </style>
    </head>

    <body class="@if(app()->getLocale() === 'ar') rtls @endif @if(!Auth::check()) mini-navbar @endif">

        <!-- Wrapper-->
        <div id="wrapper">
            <form id="logout-form" action="{{ route('dashboard.logout') }}" method="POST" style="display: none;">
                @csrf
            </form>

            @if(!isset($exportPDF) && Auth::check())
            <!-- Navigation -->
            @include('dashboard.layout.navigation') @endif

            <!-- Page wraper -->
            <div id="page-wrapper" class="gray-bg">

                @if(!isset($exportPDF) && Auth::check())
                <!-- Page wrapper -->
                @include('dashboard.layout.topnavbar') @endif

                <div class="wrapper wrapper-content animated fadeInRight">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif @if (session('successMessage'))
                    <div class="alert alert-success">
                        {{ session('successMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif @if (session('errorMessage'))
                    <div class="alert alert-danger">
                        {{ session('errorMessage') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @endif

                    <!-- Main view  -->
                    @yield('content')
                </div>

                <!-- Footer -->
                @include('dashboard.layout.footer')

            </div>
            <!-- End page wrapper-->

        </div>
        <!-- End wrapper-->

        @if(!isset($exportPDF))
        <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="confirmModalTitle">{{ __('Please confirm to continue') }}</h4>
                    </div>
                    <div class="modal-body" id="confirmModalBody"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                        <button type="button" class="btn btn-primary dev-confirm-ok" data-style="expand-right">{{ __('Yes') }} </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- User Send Mail Dashboard  -->
        <div class="modal fade" id="sendEmailUser" tabindex="-1" role="dialog" aria-labelledby="sendEmailExamTitle">
            <div class="modal-dialog" role="document">
                <form role="form" id="sendEmailExamForm">
                    <!--<input type="hidden" name="_method" value="PUT">-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="sendEmailExamTitle">{{ __('user.send_email') }}</h4>
                        </div>
                        <div class="modal-body" id="sendEmailExamBody">
    
                            <div class="form-group">
                                <label class="control-label" for="subject">{{ __("user.subject") }}</label>
                                <input type="text" required id="subject" class="form-control" placeholder="{{ __('user.subject') }}">
                            </div>
    

    

    
                            <div class="form-group">
                                <label class="control-label" for="description">{{ __("user.description") }}</label>
                                <textarea id="description" required class="form-control" placeholder="{{ __('user.description') }}"></textarea>
                            </div>
    

    
                        </div>
                        <input type="hidden" id="request-ids-input" value="" class="form-control">
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary dev-send-email-now">{{ __('Send Email') }} </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('No') }} </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>







        <script src="{{ mix('/dashboard/js/app.js') }}" type="text/javascript"></script>
        <script>
                    // send email exam
            let subject_input = $('#subject');
            let description_input = $('#description');
            let send_email_trigger = $('.dev-send-email');
            var request_ids = [];
            let request_ids_input = $('#request-ids-input');
            let send_email_button = $('.dev-send-email-now');
            send_email_trigger.click(function() {
                console.log("send_email_clicked ...");
                user_url = $(this).attr('data-url');
                request_ids = [];
                $.each($("input[name='ids[]']:checked"), function () {
                    request_ids.push($(this).val());
                });

            });
            send_email_button.click(function(event) {
                event.preventDefault();
                $("#sendEmailExamForm").validate();

                if($("#sendEmailExamForm").valid()){
                    update_data_request(user_url, {
                        'subject': subject_input.val(),
                        'description': description_input.val(),
                        'ids': request_ids
                    });
                }
            });
        

                        //request ajax
                let update_data_request = (url, data_object) => {
                    console.log("update_data_request");
                let data = new FormData();
                Object.entries(data_object).forEach(([key, value]) => data.append(key, value));
                console.log(data);
                console.log(url);

                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    method: 'POST',
                    url: url,
                    data: data,
                    // success: () => location.reload(),
                    success: function(data) {
                        console.log(data);
                    },
                    contentType: false,
                    processData: false
                });
            };
        </script>
        @section('scripts') @show

        @endif

    </body>

</html>
