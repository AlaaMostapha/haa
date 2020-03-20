/*
 *
 *   INSPINIA - Responsive Admin Theme
 *   version 2.7.1
 *
 */

$(document).ready(function () {


    // Add body-small class if window less than 768px
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }

    // MetsiMenu
    $('#side-menu').metisMenu();

    // Collapse ibox function
    $('.collapse-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        var content = ibox.children('.ibox-content');
        content.slideToggle(200);
        button.toggleClass('fa-chevron-up').toggleClass('fa-chevron-down');
        ibox.toggleClass('').toggleClass('border-bottom');
        setTimeout(function () {
            ibox.resize();
            ibox.find('[id^=map-]').resize();
        }, 50);
    });

    // Close ibox function
    $('.close-link').on('click', function () {
        var content = $(this).closest('div.ibox');
        content.remove();
    });

    // Fullscreen ibox function
    $('.fullscreen-link').on('click', function () {
        var ibox = $(this).closest('div.ibox');
        var button = $(this).find('i');
        $('body').toggleClass('fullscreen-ibox-mode');
        button.toggleClass('fa-expand').toggleClass('fa-compress');
        ibox.toggleClass('fullscreen');
        setTimeout(function () {
            $(window).trigger('resize');
        }, 100);
    });

    // Minimalize menu
    $('.navbar-minimalize').on('click', function (event) {
        event.preventDefault();
        $("body").toggleClass("mini-navbar");
        SmoothlyMenu();

    });

    // Full height of sidebar
    function fix_height() {
        var heightWithoutNavbar = $("body > #wrapper").height() - 61;
        $(".sidebard-panel").css("min-height", heightWithoutNavbar + "px");

        var navbarHeight = $('nav.navbar-default').height();
        var wrapperHeight = $('#page-wrapper').height();

        if (navbarHeight > wrapperHeight) {
            $('#page-wrapper').css("min-height", navbarHeight + "px");
        }

        if (navbarHeight < wrapperHeight) {
            $('#page-wrapper').css("min-height", $(window).height() + "px");
        }

        if ($('body').hasClass('fixed-nav')) {
            if (navbarHeight > wrapperHeight) {
                $('#page-wrapper').css("min-height", navbarHeight + "px");
            } else {
                $('#page-wrapper').css("min-height", $(window).height() - 60 + "px");
            }
        }

    }

    fix_height();

    // Fixed Sidebar
    $(window).bind("load", function () {
        if ($("body").hasClass('fixed-sidebar')) {
            $('.sidebar-collapse').slimScroll({
                height: '100%',
                railOpacity: 0.9
            });
        }
    });

    $(window).bind("load resize scroll", function () {
        if (!$("body").hasClass('body-small')) {
            fix_height();
        }
    });

    // Add slimscroll to element
    $('.full-height-scroll').slimscroll({
        height: '100%'
    })
});


// Minimalize menu when screen is less than 768px
$(window).bind("resize", function () {
    if ($(this).width() < 769) {
        $('body').addClass('body-small')
    } else {
        $('body').removeClass('body-small')
    }
});

function SmoothlyMenu() {
    if (!$('body').hasClass('mini-navbar') || $('body').hasClass('body-small')) {
        // Hide menu in order to smoothly turn on when maximize menu
        $('#side-menu').hide();
        // For smoothly turn on menu
        setTimeout(
                function () {
                    $('#side-menu').fadeIn(400);
                }, 200);
    } else if ($('body').hasClass('fixed-sidebar')) {
        $('#side-menu').hide();
        setTimeout(
                function () {
                    $('#side-menu').fadeIn(400);
                }, 100);
    } else {
        // Remove all inline style from jquery fadeIn function to reset menu state
        $('#side-menu').removeAttr('style');
    }
}

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
    }

}