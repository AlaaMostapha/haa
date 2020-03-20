$.validator.setDefaults({
    highlight: function (element) {
        $(element).closest('.form-group').addClass('has-error');
    },
    unhighlight: function (element) {
        $(element).closest('.form-group').removeClass('has-error');
        $(element).closest('.form-group').find('.dev-help-error').remove();
    },
    errorElement: 'span',
    errorClass: 'help-block m-b-none dev-help-error',
    errorPlacement: function (error, element) {
//        if (element.parent('.form-group').length) {
        if (element.parent('.input-group').length) {
            error.insertAfter(element.parent());
        } else if (element.prop('type') === 'checkbox') {
            error.appendTo(element.parent().parent().parent());
        } else if (element.prop('type') === 'radio') {
            error.appendTo(element.parent().parent().parent());
        } else {
            error.appendTo(element.parent());
        }
    },
});

var errorMessages = {
    inputRequired: 'Please enter %label%',
    selectRequired: 'Please choose %label%',
    mobile: 'Mobile must have 10 numbers',
    email: 'email must be like xxx@xx.xxx'
};

var placeholderTranslation = 'Nothing selected';
if ($('html').attr('lang') === 'ar') {
    placeholderTranslation = 'لا شىء';
    /*
     * Translated default messages for the jQuery validation plugin.
     * Locale: AR (Arabic; العربية)
     */
    $.extend($.validator.messages, {
        required: "هذا الحقل إلزامي",
        remote: "يرجى تصحيح هذا الحقل للمتابعة",
        email: "رجاء إدخال عنوان بريد إلكتروني صحيح",
        url: "رجاء إدخال عنوان موقع إلكتروني صحيح",
        date: "رجاء إدخال تاريخ صحيح",
        dateISO: "رجاء إدخال تاريخ صحيح (ISO)",
        number: "رجاء إدخال عدد بطريقة صحيحة",
        digits: "رجاء إدخال أرقام فقط",
        creditcard: "رجاء إدخال رقم بطاقة ائتمان صحيح",
        equalTo: "رجاء إدخال نفس القيمة",
        extension: "رجاء إدخال ملف بامتداد موافق عليه",
        maxlength: $.validator.format("الحد الأقصى لعدد الحروف هو {0}"),
        minlength: $.validator.format("الحد الأدنى لعدد الحروف هو {0}"),
        rangelength: $.validator.format("عدد الحروف يجب أن يكون بين {0} و {1}"),
        range: $.validator.format("رجاء إدخال عدد قيمته بين {0} و {1}"),
        max: $.validator.format("رجاء إدخال عدد أقل من أو يساوي {0}"),
        min: $.validator.format("رجاء إدخال عدد أكبر من أو يساوي {0}")
    });
    errorMessages = {
        inputRequired: 'من فضلك قم بإدخال %label%',
        selectRequired: 'من فضلك قم بإختيار %label%',
        mobile: 'يجب أن يتكون رقم الهاتف من 10 ارقام ',
        email: 'يجب أن يكون البريد الإلكتروني بهذه الصيغة xxx@xx.xxx'
    };
}

function correctCheckAllView() {
    console.log("hererererererrerer");
    console.log(".dev-select-all");
    console.log($('.dev-select-all'));
    console.log(".dev-select-row");
    console.log($('.dev-select-row'));


    var selectAllChecked = $('.dev-select-all').length > 0;
    var anyOneChecked = false;
    $('.dev-select-row').each(function () {
        if ($(this).prop('checked')) {
            anyOneChecked = true;
        } else {
            selectAllChecked = false;
        }
    });
    if (selectAllChecked) {
        $('.dev-select-all').prop('checked', true);
        $('.dev-multiple-rows-actions').show();
    } else {
        $('.dev-select-all').prop('checked', false);
        if (anyOneChecked) {
            $('.dev-multiple-rows-actions').show();
        } else {
            $('.dev-multiple-rows-actions').hide();
        }
    }

}

$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.dev-select-all').on('click', function () {
        if ($(this).prop('checked')) {
            $('.dev-select-row').prop('checked', true);
            $('.dev-multiple-rows-actions').show();
        } else {
            $('.dev-select-row').prop('checked', false);
            $('.dev-multiple-rows-actions').hide();
        }
    });

    $('.dev-select-row').on('click', correctCheckAllView);

    correctCheckAllView();

    $('.dev-confirm-ok').each(function () {
        $(this).ladda();
    });
    var multipleActionUrl, multipleRedirectTo;
    $('.dev-multiple-action ').on('click', function () {
        multipleActionUrl = $(this).attr('data-url');
        multipleRedirectTo = $(this).attr('data-redirect-to');
        $('#confirmModalBody').html($(this).attr('data-confirm-message')+` (${$("input[name='ids[]']:checked").length}) `);
    });
    $('.dev-confirm-ok').on('click', function () {
        var ids = [];
        $.each($("input[name='ids[]']:checked"), function () {
            ids.push($(this).val());
        });
        var $this = $(this);
        $this.ladda('start');
        $.ajax({
            url: multipleActionUrl,
            data: {'ids': ids},
            type: 'POST',
//            complete: function (data) {
//                console.log(data);
            complete: function () {
                window.location = multipleRedirectTo;
            }
        });
    });

    $('form input[required], form textarea[required]').each(function () {
        var $this = $(this);
        $this.attr('data-msg-required',
                errorMessages.inputRequired.replace('%label%', $this.parents('.form-group').find('label').html() ? $this.parents('.form-group').find('label').html() : $this.attr('placeholder')));
    });
    $('form input[type="email"]').each(function () {
        var $this = $(this);
        $this.attr('data-msg-email', errorMessages.email);
    });
    $('form select[required], form select[data-rule-required]').each(function () {
        var $this = $(this);
        $this.attr('data-msg-required',
                errorMessages.selectRequired.replace('%label%', $this.parents('.form-group').find('label').html() ? $this.parents('.form-group').find('label').html() : $this.attr('placeholder')));
    });
    $(document).on('change', '.select2', 'form.dev-form-validate select.select2', function () {
        $(this).valid();
    });

    $(".dev-form-validate").validate(
    //     {
    //     errorElement: 'div',
    //     errorPlacement: function (error, element) {
    //         error.addClass('invalid-feedback');
    //         element.closest('.form-group').append(error);
    //     },
    //     highlight: function (element, errorClass, validClass) {
    //         $(element).addClass('is-invalid');
    //     },
    //     unhighlight: function (element, errorClass, validClass) {
    //         $(element).removeClass('is-invalid');
    //     }
    // }
    );

    $('form.dev-form-validate').each(function () {
        $(this).validate({
            ignore: ':hidden, .dev-ignore-validation'
        });
    });
    $('select.select2[required]').select2({
        'language': $('html').attr('lang'),
        'dir': $('html').attr('data-textdirection')
    });
    $('select.select2:not([required])').select2({
        'allowClear': true,
        'placeholder': placeholderTranslation,
        'language': $('html').attr('lang'),
        'dir': $('html').attr('data-textdirection')
    });
    if ($('textarea.dev-auto-size').length > 0) {
        autosize($('textarea.dev-auto-size'));
    }

    // list js
    $('.dev-import-button').on('click', function () {
        $('.dev-import-file').click();
    });
    $('.dev-import-file').on('change', function () {
        $('.dev-import-form').submit();
    });
    $('.dev-select-filter').on('change', function () {
        $('form.dev-filter-form').submit();
    });
    $('.dev-date-filter-container, .dev-daterange-filter-container>.dev-date-filter').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    }).on('changeDate', function () {
        $('form.dev-filter-form').submit();
    }).on('clearDate', function () {
        $('form.dev-filter-form').submit();
    });

    $('.dev-date-input-model').datepicker({
        format: 'yyyy-mm-dd',
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        calendarWeeks: true,
        autoclose: true
    });

    $('.dev-input-filter').on('keyup', function (e) {
        if (e.keyCode == 13) {
            $('form.dev-filter-form').submit();
        }
    });
    $('.dev-confirm-delete-ok').on('click', function () {
        $('#confirmDeleteModal').modal('hide');
        setTimeout(function () {
            $('#deleteModal').modal('show');
        }, 500);
    });

    var deleteUrl = '';
    $('.dev-delete-ok').each(function () {
        $(this).ladda();
    });
    $('.dev-delete-confirm').on('click', function () {
        deleteUrl = $(this).attr('data-url');
    });
    $('.dev-delete-ok').on('click', function () {
        var $this = $(this);
        $this.ladda('start');
        $.ajax({
            url: deleteUrl,
            type: 'DELETE',
            complete: function () {
                window.location.reload();
            }
        });
    });

    var deactivateUrl = '';
    $('.dev-deactivate-ok').each(function () {
        $(this).ladda();
    });
    $('.dev-deactivate-confirm').on('click', function () {
        deactivateUrl = $(this).attr('data-url');
    });
    $('.dev-deactivate-ok').on('click', function () {
        var $this = $(this);
        $this.ladda('start');
        $.ajax({
            url: deactivateUrl,
            type: 'POST',
            complete: function () {
                window.location.reload();
            }
        });
    });

    var activateUrl = '';
    $('.dev-activate-ok').each(function () {
        $(this).ladda();
    });
    $('.dev-activate-confirm').on('click', function () {
        activateUrl = $(this).attr('data-url');
    });
    $('.dev-activate-ok').on('click', function () {
        var $this = $(this);
        $this.ladda('start');
        $.ajax({
            url: activateUrl,
            type: 'POST',
            complete: function () {
                window.location.reload();
            }
        });
    });
    $('.dev-date-input').datepicker({format: 'yyyy-mm-dd'});
    $('.clockpicker').clockpicker();


});
