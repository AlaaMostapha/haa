/*global $,owl,smoothScroll,AOS,alert*/
$(document).ready(function () {
    "use strict";

    /* ---------------------------------------------
     Loader Screen
     --------------------------------------------- */
    $(window).load(function () {
        $("body").css('overflow-y', 'auto');
        $('#loading').fadeOut(1000);
    });

    $('[data-tool="tooltip"]').tooltip({
        trigger: 'hover',
        animate: true,
        delay: 50,
        container: 'body'
    });

    /* ---------------------------------------------
     Scrool To Top Button Function
     --------------------------------------------- */
    $(window).scroll(function () {
        if ($(this).scrollTop() > 500) {
            $(".toTop").css("right", "20px");
        } else {
            $(".toTop").css("right", "-60px");
        }
    });

    $(".toTop").click(function () {
        $("html,body").animate({
            scrollTop: 0
        }, 500);
        return false;
    });

    //customize the header
    $(window).scroll(function () {
        if ($(this).scrollTop() > 30) {
            $('.main-head').addClass('sticky');
        } else {
            $('.main-head').removeClass('sticky');
        }
    });

    $('[data-fancybox]').fancybox();

    $('.videos-slider').owlCarousel({
        center: true,
        items: 1.7,
        loop: true,
        dots: true,
        navText: ["<i class='fa fa-caret-left'></i>", "<i class='fa fa-caret-right'></i>"],
        nav: true,
        autoplay: 4000,
        autoplayHoverPause: true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 1
            },
            1000: {
                items: 1.7
            }
        }
    });


    $(".h-slider").owlCarousel({
        nav: true,
        loop: true,
        navText: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: false,
        autoplay: 4000,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        items: 1
    });

    var windowWidth = $(window).width();
    if (windowWidth <= 1024) {

    }

    AOS.init({
        once: true
    });

    var loadFile = function (event) {
        var output = document.getElementById('output');
        output.src = URL.createObjectURL(event.target.files[0]);
    };

    $('.open-menu').on('click', function () {
        $('.sidebar').toggleClass('opened');
        $('.overlay_gen').fadeIn();
        $('body').addClass('sided');
    });

    $('.overlay_gen').on('click', function () {
        $('.sidebar').toggleClass('opened');
        $('.overlay_gen').fadeOut();
        $('body').removeClass('sided');
    });

    $('.form-group select').niceSelect();

    if ($('.file-upload').length) {
        $('.file-upload').file_upload();
    }

    if ($('.select-2').length > 0)
        $(".select-2").select2({
            closeOnSelect: false,
            placeholder: "أختر",
            allowHtml: true,
            allowClear: true,
            tags: true
        });

    $('.op-filter').on('click', function () {
        $('.filter-area').slideToggle();
        $('.search-area').slideUp();
        $(this).toggleClass('active');
        $('.op-search').removeClass('active');
    });
    $('.op-search').on('click', function () {
        $('.search-area').slideToggle();
        $('.filter-area').slideUp();
        $(this).toggleClass('active');
        $('.op-filter').removeClass('active');
    });

    if ($('#myDropzone').length) {

        $(document).ready(function () {
            var myDropzone = new Dropzone("#myDropzone", {
                url: $("#myDropzone").attr('data-url'),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                paramName: "pastProjects",
                autoProcessQueue: true,
                uploadMultiple: true, // uplaod files in a single request
                parallelUploads: 10, // use it with uploadMultiple
                maxFilesize: 2, // MB
                maxFiles: 10,
                acceptedFiles: ".jpeg, .jpg, .png, .pdf, .xlsx, .xls, .doc, .docx, .ppt",
                addRemoveLinks: false,
                dictFileTooBig: 'يمكن رفع ملف بحجم حتى 2 ميجا فقط',
                dictInvalidFileType: 'ملف بصيغة غير مناسبة',
                dictMaxFilesExceeded: 'يمكن رفع حتى 10ملفات ',
//            dictFileTooBig: "{{ __('user.(up to 2 MB)') }}",
//            dictInvalidFileType: "{{ __('user.(Invalid File Type)') }}",
//            dictMaxFilesExceeded: "{{ __('user.(up to 5)') }}",
                dictDefaultMessage: ""
            });
        });


        Dropzone.autoDiscover = false;
        Dropzone.options.myDropzone = {
            init: function () {
                //        // on error
//            this.on("error", function (file, response) {
////                 console.log(response);
//            });
this.on("addedfile", function (file, response) {
   
  $("#dropSpan").hide();
});
                // on success
                this.on("successmultiple", function (file, response) {

//                alert(response['project_ids']);

                    var old_vals = $('#project_ids').val();
                    if (old_vals != '') {
                        $('#project_ids').val(old_vals + ',' + response['project_ids']);
                    } else {
                        $('#project_ids').val(response['project_ids']);
                    }
                });
            }
        };

    }
});

$(window).on('resize',function() {
    $('#data-table-th').destroy();
    if ($('#data-table-th').length > 0)
        $('#data-table-th').DataTable({
            searching: false,
            paging: false,
            info: false,
            responsive: true,
            "language": {
                "decimal": "",
                "emptyTable": "لا توجد بيانات",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "جاري التحميل...",
                "processing": "جاري...",
                "search": "بحث:",
                "zeroRecords": "لا توجد نتائج مطابقة",
                "paginate": {
                    "first": "الاول",
                    "last": "الاخير",
                    "next": "",
                    "previous": ""
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });
});
