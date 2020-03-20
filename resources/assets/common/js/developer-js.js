"use strict";

$(document).ready(function () {
    $.validator.setDefaults({
        errorElement: 'span',
        errorClass: 'help-block',
        highlight: function (element, errorClass, validClass) {
            // Only validation controls
            if (!$(element).hasClass('novalidation')) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            }
        },
        unhighlight: function (element, errorClass, validClass) {
            // Only validation controls
            if (!$(element).hasClass('novalidation')) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            }
        },
        errorPlacement: function (error, element) {
            if (element.parent('.file-upload').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.parent('.form-group').length) {
                error.appendTo(element.parent());
            } else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
                error.insertAfter(element.parent().parent());
            } else if (element.prop('type') === 'select') {
                error.appendTo(element.parent().parent());
            } else if (element.prop('type') === 'tel') {
                error.appendTo(element.parent().parent());
            } else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                error.appendTo(element.parent().parent());
            } else {
                error.insertAfter(element);
            }
        }
    });

    $.validator.addMethod("validateUsername", function name(value, element) {
        return this.optional(element) || '/^\S*$/'.test(value);
    }, 'لايسمح بترك مسافات ');

    $.validator.addMethod("validateUniversityEmail", function name(value, element) {
        console.log("inside validation");
        console.log(listEmail);
        listEmail = (typeof listEmail !== 'undefined')? listEmail : [];
        // listEmail = [
        //     'student.riyadh.edu.sa',
        //     'st.uqu.edu.sa',
        //     'sm.imamu.edu.sa',
        //     'stu.kau.edu.sa',
        //     'student.ksu.edu.sa',
        //     'kfupm.edu.sa',
        //     'nauss.edu.sa',
        //     'student.kfu.edu',
        //     'kku.edu.sa',
        //     'qu.edu.sa',
        //     'taibahu.edu.sa',
        //     'students.tu.edu.sa',
        //     'stu.jazanu.edu.sa',
        //     'example.com',
        //     'stu.bu.edu.sa',
        //     'stu.ut.edu.sa',
        //     'nu.edu.sa',
        //     'pnu.edu.sa',
        //     'ksau-hs.edu.sa',
        //     'iau.edu.sa',
        //     'kaust.edu.sa',
        //     'std.psau.edu.sa',
        //     'std.su.edu.sa',
        //     's.mu.edu.sa',
        //     'eu.edu.sa',
        //     'uj.edu.sa',
        //     'ttcollege.edu.sa',
        //     'uhb.edu.sa',
        //     'mbsc.edu.sa',
        //     'sr.edu.sa',
        //     'Ibnsina.edu.sa',
        //     'bmc.edu.sa',
        //     'alfaisal.edu',
        //     'alfarabi.edu.sa',
        //     'mcst.edu.sa',
        //     'riyadh.edu.sa',
        //     'dah.edu.sa',
        //     'upm.edu.sa',
        //     'dau.edu.sa',
        //     'psu.edu.sa',
        //     'aou.edu.om',
        //     'yu.edu.sa',
        //     'fbsu.edu.sa',
        //     'pmu.edu.sa',
        //     'ubt.edu.sa',
        //     'jicollege.edu.sa',
        //     'tctc.gov.sa',
        //     'amc.edu.sa',
        //     'tendegrees.sa'
        // ];
        fullUniversityEmail = document.getElementById("university_email").value;
        console.log(fullUniversityEmail);
        var arrUniversityEmail = fullUniversityEmail.split("@");
        console.log(arrUniversityEmail);
        emailValid = listEmail.includes(arrUniversityEmail[1]);
        console.log(emailValid);
        return emailValid
    }, ' لايتوافق مع صيغه البريد الجامعى ');

    $('form.dev-validate-form').each(function () {
        $(this).validate({
            rules: {
                gpa:{
                    number: true
                },
                university_email: {
                    validateUniversityEmail: true,
                    required: true
                }
            }
            , ignore: '.novalidation'
        });
    });

    $('a.dev-logout').each(function () {
        $(this).on('click', function (e) {
            e.preventDefault();
            document.getElementById('logout-form').submit();
        });
    });

    $('.dev-date-current-input').each(function () {
        dashboardMode = document.baseURI.includes("dashboard");
        if(dashboardMode){
            console.log("datepicker => dashboardMode => " + dashboardMode);
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                endDate:new Date()
            });
        }else{
            console.log("datepicker => dashboardMode => " + dashboardMode);
        $(this).datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD',
            minDate: moment(),
//            inline: true
        });
    }
    });

    $('select.dev-filter-select').on('change', function () {
        $('.dev-search-form').submit();
    });

    $('.dev-status-filters-container li').each(function () {
        $(this).on('click', function (e) {
            e.preventDefault();
            $('.dev-status-filters-container li').each(function () {
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $('#status').val($(this).attr('data-status'));
            $('.dev-search-form').submit();
        });
    });


    $("#howDidYouFindUs").on('change', function (event) {
        console.log($(this).find('option:selected').val());
        $("#divHowDidYouFindUsOther").removeClass("form-group col-xs-12 visible");
        $("#textHowDidYouFindUsOther").removeClass("form-control visible");
        $("#textHowDidYouFindUsOther-error").removeClass("help-block");
        $("#divHowDidYouFindUsOther").addClass("invisible");
        $("#textHowDidYouFindUsOther").addClass("invisible");
        $("#textHowDidYouFindUsOther").removeAttr("required");
        $("#textHowDidYouFindUsOther").prop("value", "");
        $("#textHowDidYouFindUsOther").attr("value", "");
        if ($(this).find('option:selected').val() === 'other') {

            $("#divHowDidYouFindUsOther").removeClass("form-group col-xs-12 invisible");
            $("#textHowDidYouFindUsOther").removeClass("invisible");
            $("#divHowDidYouFindUsOther").addClass("form-group col-xs-12 visible");
            $("#textHowDidYouFindUsOther").addClass("form-control visible");
            $("#textHowDidYouFindUsOther-error").addClass("help-block");
            $("#textHowDidYouFindUsOther").prop("required", 'required');
        }

    });

    if ($("select[name=howDidYouFindUs] option:selected").val() == 'other') {
        $("#divHowDidYouFindUsOther").removeClass("form-group col-xs-12 invisible");
        $("#textHowDidYouFindUsOther").removeClass("invisible");
        $("#divHowDidYouFindUsOther").addClass("form-group col-xs-12 visible");
        $("#textHowDidYouFindUsOther").addClass("form-control visible");
        // $("#textHowDidYouFindUsOther-error").addClass("help-block");
        // $("#textHowDidYouFindUsOther").prop("required", 'required');
    }

    $("#workType").on('change', function (event) {
//        $(this).find('option[value=""]').attr('disabled', true);
//        $(this).niceSelect('update');
        $(this).valid();

        $("#workHoursFromDiv").hide();
        $("#workHoursToDiv").hide();

        $("#workHoursFrom").val('');
        $("#workHoursFrom").prop('required', false);
        $("#workHoursTo").val('');
        $("#workHoursTo").prop('required', false);

        $("#workLocationDiv").hide();
        $("#workLocation").val('');
        $("#workLocation").prop('required', false);

        $("#workDaysCountDiv").hide();
        $("#workDaysCount").val('');
        $('#workDaysCount').niceSelect('update');
        $("#workDaysCount").prop('required', false);

//        console.log($(this).find('option:selected').val());

        if ($(this).find('option:selected').val() == 'part_time') {
            $("#workHoursFromDiv").show();
            $("#workHoursToDiv").show();

            $("#workHoursFrom").prop('required', true);
            $("#workHoursTo").prop('required', true);

            $("#workDaysCountDiv").show();
            $("#workDaysCount").prop('required', true);

            $("#workLocationDiv").show();
            $("#workLocation").prop('required', true);
        }
    });

    $(document).on("click", '.delete', function (event) {
        event.preventDefault();
        console.log("Delete Image");
        url = $(this).attr('href');
        console.log(url);
        console.log($(this));
        divParent = $(this).parent();
        console.log(divParent);
        swal({
            title: "هل تريد مسح الملف  ؟",
            text: "فى حاله تم مسح الملف سوف تكون غير قادر على استراجاعه مره اخرى",
            icon: "warning",
            buttons: ['الغاء', 'حذف'],
            dangerMode: true,
        })
                .then((willDelete) => {
                    console.log(willDelete);
                    if (willDelete) {
                        fetch(url).then(data => {
                            console.log(data);
                            if (data.status == 201) {
                                console.log("status code  request => " + 201);
                                divParent.remove();
                                console.log(data);
                            } else {

                                swal(data.message);
                            }

                        });
                    } else {

                    }
                });
    });

    $(document).on("click", '.delete-front', function (event) {
        console.log(".... Delete Front  Project ....");
        event.preventDefault();
        console.log("Delete Image");
        url = $(this).attr('href');
        console.log(url);
        console.log($(this));
        divParent = $(this).parent().parent();
        console.log(divParent);
        swal({
            title: "هل تريد مسح الملف  ؟",
            text: "فى حاله تم مسح الملف سوف تكون غير قادر على استراجاعه مره اخرى",
            icon: "warning",
            buttons: ['الغاء', 'حذف'],
            dangerMode: true,
        })
                .then((willDelete) => {
                    console.log(willDelete);
                    if (willDelete) {
                        fetch(url).then(data => {
                            console.log(data);
                            if (data.status == 201) {
                                console.log("status code  request => " + 201);
                                divParent.remove();
                                console.log(data);
                                return data.json();
                            } else {

                                swal(data.message);
                            }

                        }).then(data =>{
                            console.log("Then Again To Fetch Count");
                            console.log("DATA" , data);
                            console.log(data.userProjectsCount);
                            userProjectsCountEL= document.getElementById("userProjectsCount");
                            console.log(userProjectsCountEL);
                            userProjectsCountEL.innerHTML = `(${data.userProjectsCount})` ;
                            $("#post_data_projects").append(data.userProjects);
                            $("#load_more_projects_button").attr("task-user-apply-id" ,data.taskUserApplyId);

                        });
                    } else {

                    }
                });
    });






    $('.dev-validate-form select').on('change', function (event) {
        $(this).valid();
    });

    $("#Subscriber-form").submit(function(event) {
        event.preventDefault();
        console.log($("#Subscriber-form"));

        url = $("#Subscriber-form").attr('action');
        console.log(url);
        token = $('input[name ="_token"]').val();
        console.log(token);
        data ={email: $("#email").val() , token:token} ;
        console.log(data);

        fetch(url, {
            method: 'post',
            headers:{
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
            },
            dataType: 'json',
            body: JSON.stringify(data),
        })
        .then(response =>{
            console.log("... response ...");
            console.log(response);
            if(response.status == 201){
                console.log("status == 201");
                console.log(response);
                return response.json().then((data)=>{
                    return  data.message;
                });
            }else{
                console.log("status != 201");
                return response.json().then((responseData)=>{
                    console.log("resposeData");
                    console.log(responseData);
                    return responseData.message.email[0];
                })
            }

        })
        .then(data =>{
            console.log("... data ...");
            console.log(data);
            $.toast({
                text: data,
                icon: 'info',
                bgColor: '#fff',
                textColor: '#2E1126'

            })
            // $.toast({
            //     text: data.message,
            //     icon: 'info',
            //     bgColor: '#fff',
            //     textColor: '#2E1126'

            // })
        });

    });

    maxField = 10;
    wrapper = $("#wrapper_certificates");
    console.log(wrapper);
    console.log(document.baseURI);
    countRawGlobal = undefined ;
    dashboardMode = document.baseURI.includes("dashboard");
    $('.dev-date-current-input-certificate').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
        maxDate:moment()

        // minDate: moment(),
//            inline: true
    });

    contentHTML = `<div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive ">
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder="اسم الشهاده" name="certificate_name[]" minlength="3" maxlength="80" required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder="جهة الصدور" name="certificate_from[]" minlength="3" maxlength="80" required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control dev-date-current-input is-required" placeholder="تاريخ الصدور" name="certificate_date[]"  required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder="الشرح" name="certificate_description[]" minlength="3" maxlength="80" required>
    </div>

    <div class=" certificate-width mx-1 align-self-center text-center">
        <input type="button"  style="margin:0;max-width:100%" value="حذف" class="btn-sm btn-danger  remove-btn certificate-btn btn" />
    </div>
</div>`;
var x = 1; //Initial field counter is 1

    $(document).on('click' ,'#addRaw' , function(event) {
        event.preventDefault();

        if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(contentHTML); //Add field htmlhelp-block

                dashboardMode = document.baseURI.includes("dashboard");
                if(dashboardMode){
                    console.log("datepicker => dashboardMode => " + dashboardMode);
                    $('.dev-date-current-input').datepicker({
                        format: 'yyyy-mm-dd',
                        endDate:new Date()
                    });
                }else{
                    console.log("datepicker => dashboardMode => " + dashboardMode);
                $('.dev-date-current-input').datetimepicker({
                    useCurrent: false,
                    format: 'YYYY-MM-DD',
                    maxDate:moment()

                });
            }

                // $('.dev-date-current-input').datetimepicker({useCurrent:false,format:'YYYY-MM-DD',minDate:moment()//inline: true
                // });
        }
    });

    $(wrapper).on('click' , '.remove-btn' ,function(event){
            event.preventDefault();
            console.dir($(this));
            console.dir($(this).parent('div').parent('div')); //Remove field html
            div = $(this).parent('div');

            countRaw = wrapper.attr('countraw');
            console.log("countRaw =>" ,countRaw);
            id = div.attr('id');
            console.log("id =>" ,id);
            url = div.attr('route-link');
            console.log("url =>" ,url);
            console.log(url);
            if( url != undefined && id !=undefined){
                console.log("Sending Request");
                fetch(url).then(response => {
                    if(response.status == 200){
                        return response.json();
                    }
                }).then(data=>{
                        console.log(data);
                        wrapper.attr('countraw' ,data.certificateCount );
                        countRaw = data.certificateCount;
                        $(this).parent('div').parent('div').remove();
                        if(countRaw == 0){
                            contentHTMLDefault = `<div class="form-group col-md-12 col-xs-12">
                            <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                                <input type="text" class="form-control is-required" placeholder="اسم الشهاده" name="certificate_name[]" minlength="3" maxlength="80" >
                            </div>
                            <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                                <input type="text" class="form-control is-required" placeholder="جهة الصدور" name="certificate_from[]" minlength="3" maxlength="80" >
                            </div>
                            <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                                <input type="text" class="form-control dev-date-current-input is-required" placeholder="تاريخ الصدور" name="certificate_date[]"  >
                            </div>
                            <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                                <input type="text" class="form-control is-required" placeholder="الشرح" name="certificate_description[]" minlength="3" maxlength="80" >
                            </div>
                        </div>`;
                            $(wrapper).append(contentHTMLDefault); //Add field htmlhelp-block
                            $('.dev-date-current-input').datetimepicker({useCurrent:false,format:'YYYY-MM-DD',maxDate:moment()
                        }).end().on('keypress paste', function (e) {
                            e.preventDefault();
                            return false;
                        });

                        }

                });

            }else{
                console.log("Delete Dom");
                $(this).parent('div').parent('div').remove();
            }

    });


    $(document).on('keyup' ,'.is-required', function(event) {
        div = $(this).parent('div').parent('div');
        if($(this).val().length > 0) {
            console.log("Condition1");
            console.log($(this).val());
            div.find('input[type=text]').prop("required" , true);
            div.find('input[type=text]').prop("minlength" , 3);
            div.find('input[type=text]').prop("maxlength" , 80);


        }else if($(this).text()==""){
            console.log("condition2");
            console.log("This text equal  0");
            div.find('input[type=text]').prop("required" , true);
            div.find('input[type=text]').prop("minlength" , 3);
            div.find('input[type=text]').prop("maxlength" , 80);
            console.log( "value => " + $(this).val());
        }
        // else{
        //     div.find('input[type=text]').removeAttr("required");
        //     div.find('.help-block').remove();
        // }
    });
    ///
    if (typeof user_languages !== 'undefined') {
    contentHTMLLanguages = `
    <div ${(dashboardMode) ? 'class="form-group col-md-12 col-xs-12"':'class="col-md-12 col-xs-12 d-flex d-flex-responsive"'}>

            <div ${(dashboardMode) ? 'class="form-group col-md-3 col-xs-4"':'class="form-group language-width ml-1"'}>
                    <select class="form-control lang-name" name="language_name[]" required>
                                    <option selected disabled> اختر اللغه المطلوبه</option>
                                    <option  value="english">${user_languages.english}</option>
                                    <option  value="arabic">${user_languages.arabic}</option>
                                    <option  value="other">${user_languages.other}</option>
                    </select>
            </div>
            <div ${(dashboardMode) ? 'class="form-group col-md-3 col-xs-4"':'class="form-group language-width ml-1"'}>
                    <select class="form-control lang-level nice-select" name="language_level[]" required>
                                    <option selected disabled> اختر مستوى اللغه </option>
                                    <option   class="nice-select option" value="beginner">${user_languages_level.beginner}</option>
                                    <option   class="nice-select option" value="intermediate">${user_languages_level.intermediate}</option>
                                    <option   class="nice-select option" value="professional">${user_languages_level.professional}</option>
                                    <option   class="nice-select option" value="fluent">${user_languages_level.fluent}</option>
                    </select>
            </div>
            <div ${(dashboardMode) ? 'class="col-md-3 form-group other"':'class="form-group language-width ml-1 other"'}></div>
            <div class="certificate-width ml-1 text-center">
                <input type="button"  style="margin:0;max-width:100%" value="حذف" class="text-right btn-sm btn-danger remove-btn-lang  certificate-btn btn"/>
            </div>
    </div>
    `;
    }

    y = 0 ;
    maxFieldLanguage = 10;
    wrapperLang = $("#wrapperlang");
    $(document).on('click' ,'#addRawLanguage' , function (event) {
        console.log("ADD NEW Raw");

        if(x < maxFieldLanguage){
            x++; //Increment field counter
            $(wrapperLang).append(contentHTMLLanguages); //Add field htmlhelp-block
            dashboardMode = document.baseURI.includes("dashboard");
            console.log("dashboardMode => " + dashboardMode);
            if(dashboardMode){
                $('select').select2();

            }
            $('select').niceSelect();
    }
    });

    $(wrapperLang).on('click' , '.remove-btn-lang' ,function(event){
        console.log("Removing Lang");
        event.preventDefault();
        div = $(this).parent('div');
        id = div.attr('id');
        url = div.attr('route');
        countRaw = $("#wrapperlang").attr('countraw');
        console.log(url);
        if(url != "" && url != undefined){

            fetch(url).then(response => {
                        if(response.status == 200){
                                return response.json()
                        }
                    }).then( data=>{

                    $("#wrapperlang").attr('countraw' ,data.languageCount);
                    countRaw = data.languageCount;
                    $(this).parent('div').parent('div').remove();
                    if(countRaw == 0){
                        contentHTMLDefault = ` <div class="col-md-12 col-xs-12">
                        <div class="form-group col-md-2 col-xs-4">
                                <select class="form-control lang-name" name="language_name[]">
                                                <option selected disabled> اختر اللغه المطلوبه</option>
                                                <option  value="english">${user_languages.english}</option>
                                                <option  value="arabic">${user_languages.arabic}</option>
                                                <option  value="other">${user_languages.other}</option>
                                </select>
                        </div>
                        <div class="form-group col-md-2 col-xs-4">
                                <select class="form-control lang-level nice-select " name="language_level[]">
                                                <option selected disabled> اختر مستوى اللغه </option>
                                                <option  class="nice-select option" value="beginner">${user_languages_level.beginner}</option>
                                                <option  class="nice-select option" value="intermediate">${user_languages_level.intermediate}</option>
                                                <option  class="nice-select option" value="professional">${user_languages_level.professional}</option>
                                                <option   class="nice-select option"value="fluent">${user_languages_level.fluent}</option>
                                </select>
                        </div>
                        <div class="form-group col-md-2 other"></div>
                </div>`;
                        $(wrapperLang).append(contentHTMLDefault); //Add field htmlhelp-block
                    }
            });

        }else{
            console.log("Removing without ajax");
            $(this).parent('div').parent('div').remove();
        }

    });
    $(wrapperLang).on('change' ,'.lang-name',function(event) {
        console.log($(this).val());
        console.log($(this).parent('div').parent('div').find('.other').has('input[type=text]'));

        if ($(this).val() == 'other') {
            $(this).parent('div').parent('div').find('.other').find('input[type=hidden]').remove();
            $(this).parent('div').parent('div').find('select').prop("required" ,true);

            // console.log($(this).parent('div').parent('div').find('.other').find('input[type=text]').length );
            if($(this).parent('div').parent('div').find('.other').find('input[type=text]').length <= 0){
                inputOtherLanguage = `<input type="text" class="form-control lang-other" placeholder="ادخل اللغه الاخرى " name="language_other[]" minlength="3" maxlength="1000"  required>`;
                $(this).parent('div').parent('div').find('.other').append(inputOtherLanguage);
            }
        }else{
            $(this).parent('div').parent('div').find('.other').find('input[type=text]').remove();
            $(this).parent('div').parent('div').find('.other').find('span').remove();
            inputOtherLanguage = `<input type="hidden" class="form-control lang-other" name="language_other[]" minlength="3" maxlength="1000" >`;
            $(this).parent('div').parent('div').find('.other').append(inputOtherLanguage);
            $(this).parent('div').parent('div').find('select').prop("required" ,true);
        }

    });
    $(wrapperLang).on('change' ,'.lang-level',function(event) {
        $(this).parent('div').parent('div').find('select').prop("required" ,true);
    });

    /** ADD experience */

    $('.dev-date-current-input-experience').datetimepicker({
        useCurrent: false,
        format: 'YYYY-MM-DD',
        maxDate:moment()
        // minDate: moment(),
//            inline: true
    });
    maxFieldExperience = 10;
    wrapper_experiences = $("#wrapper_experiences");
    console.log("wrapper_experiences");
    console.log(wrapper_experiences);
    console.log("wrapper_baseURL");
    dashboardMode = document.baseURI.includes("dashboard");
    console.log("dashboardMode => " + dashboardMode);
    countRawGlobalExperience = undefined ;

    contentHTMLExperience = `<div class="form-group col-md-12 col-xs-12 d-flex d-flex-responsive ">
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder="اسم الخبره" name="experience_name[]" minlength="3" maxlength="80" required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder=" جهه صدور الخبره" name="experience_from[]" minlength="3" maxlength="80" required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control dev-date-current-input is-required" placeholder="تاريخ الصدور" name="experience_date[]"  required>
    </div>
    <div ${(dashboardMode) ? 'class="col-md-2"':'class=" certificate-width mx-1"'}>
        <input type="text" class="form-control is-required" placeholder="تفاصيل الخبره" name="experience_description[]" minlength="3" maxlength="80" required>
    </div>

    <div class=" certificate-width mx-1 align-self-center text-center">
        <input type="button"  style="margin:0;max-width:100%" value="حذف" class="btn-sm btn-danger  remove-btn-experience certificate-btn btn"/>
    </div>
</div>`;
var z = 1; //Initial field counter is 1

$(document).on('click' ,'#addRawExperience' , function(event) {
    event.preventDefault();

    if(x < maxFieldExperience){
            x++; //Increment field counter
            $(wrapper_experiences).append(contentHTMLExperience); //Add field htmlhelp-block

            dashboardMode = document.baseURI.includes("dashboard");
            if(dashboardMode){
                console.log("datepicker => dashboardMode => " + dashboardMode);
                $('.dev-date-current-input').datepicker({
                    format: 'yyyy-mm-dd',
                    endDate:new Date()
                });
            }else{
                console.log("datepicker => dashboardMode => " + dashboardMode);
            $('.dev-date-current-input').datetimepicker({
                useCurrent: false,
                format: 'YYYY-MM-DD',
                maxDate:moment()

                // minDate: moment(),
    //            inline: true
            });
        }

            // $('.dev-date-current-input').datetimepicker({useCurrent:false,format:'YYYY-MM-DD',minDate:moment()//inline: true
            // });
    }
});


$(wrapper_experiences).on('click' , '.remove-btn-experience' ,function(event){
    console.log("Remove experience");
    event.preventDefault();
    console.dir($(this));
    console.dir($(this).parent('div').parent('div')); //Remove field html
    div = $(this).parent('div');

    countRawExperience = wrapper_experiences.attr('countraw-experience');
    console.log("countRaw =>" ,countRawExperience);
    id = div.attr('id');
    console.log("id =>" ,id);
    url = div.attr('route-link');
    console.log("url =>" ,url);
    if( url != undefined && id !=undefined){
        console.log("Sending Request");
        fetch(url).then(response => {
            if(response.status == 200){
                return response.json();
            }
        }).then(data=>{
            console.log("response success")
                console.log(data);
                wrapper_experiences.attr('countraw-experience' ,data.experienceCount);
                countRawExperience = data.experienceCount;
                $(this).parent('div').parent('div').remove();
                if(countRawExperience == 0){
                    contentHTMLDefaultExperience = `<div class="form-group col-md-12 col-xs-12">
                    <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                        <input type="text" class="form-control is-required" placeholder="اسم الخبره" name="experience_name[]" minlength="3" maxlength="80" >
                    </div>
                    <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                        <input type="text" class="form-control is-required" placeholder="جهه صدور الخبره" name="experience_from[]" minlength="3" maxlength="80" >
                    </div>
                    <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                        <input type="text" class="form-control dev-date-current-input is-required" placeholder="تاريخ صدور الخبره" name="experience_date[]"  >
                    </div>
                    <div ${(dashboardMode) ? 'class="col-md-2"':'class="col-md-3"'}>
                        <input type="text" class="form-control is-required" placeholder="تفاصيل الخبره" name="experience_description[]" minlength="3" maxlength="80" >
                    </div>
                </div>`;
                    $(wrapper_experiences).append(contentHTMLDefaultExperience); //Add field htmlhelp-block
                    $('.dev-date-current-input').datetimepicker({useCurrent:false,format:'YYYY-MM-DD',maxDate:moment()

                }).end().on('keypress paste', function (e) {
                    e.preventDefault();
                    return false;
                });

                }

        });

    }else{
        console.log("Delete Dom");
        $(this).parent('div').parent('div').remove();
    }

});

















 $(".select-city").select2({
    // tags: true,
    placeholder: "المدينة",
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }
  });

  $(".select-university").select2({
    placeholder: "أسم الجامعة ",
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });

  $(".select-academicYear").select2({
    // tags: true,
    placeholder: " السنه الدراسيه ",
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });

  $(".select-major").select2({
    placeholder:" تخصص الدراسة " ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });

  $(".select-yearOfStudy").select2({
    placeholder:"سنة التخرج" ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });

  $(".select-gpatype").select2({
    // tags: true,
    placeholder:" نوع المعدل التراكمي " ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });


//   $('.select-gpatype').on('select2:opening select2:closing', function( event ) {
//       console.log("this" ,$(this));
//     var $searchfield = $(this).parent().find('.select2-search__field');
//     console.log("opening and closing");
//     console.log($searchfield);
//     $( $searchfield.selector).on('keypress',function(event) {
//         console.log("Key Presssss");
//         $(this).val($(this).val().replace(/[^\d].+/, ""));
//         console.log( $(this).val($(this).val().replace(/[^\d].+/, "")));
//         console.log("event ....");
//         console.log(event);
//         if ((event.which < 48 || event.which > 57)) {
//             event.preventDefault();
//         }
//     })
//     // $searchfield.prop('disabled', true);
// });






  $(".select-howDidYouFindUs").select2({
    // tags: true,
    placeholder:'كيف وجدتنا ؟' ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }

  });

$("#pricePaymentType").select2({
    placeholder:'قيمة المكافئة أعلاه عبارة عن' ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }
});


$("#cityExistImportance").select2({
    placeholder:'مدى أهمية تواجد الطالب في نفس المدينة' ,
    theme: "bootstrap",
    language: {
        "noResults": function(){
            return "لايوجد نتائج للبحث";
        }
    }
});


    // console.log( $('.select2'));
    $('.select-multi-major').select2({
        placeholder: "مجال الطالب" ,
        allowClear: false
    });




$("#workHoursFrom").clockpicker({
    autoclose: true,
    twelvehour: true,
    donetext: 'Done',
    afterDone: function() {
        console.log("after done");
        console.log($('#workHoursFrom').val());
        checkDates();

    }
});
$("#workHoursTo").clockpicker({
    autoclose: true,
    twelvehour: true,
    donetext: 'Done',
    afterDone: function() {
        console.log("after done");
        console.log($('#workHoursTo').val());
        checkDates();
        x = convertTime12to24($('#workHoursFrom').val());
        date1 = new Date()
        date1.setHours(x.hours);
        date1.setMinutes(x.minutes);
        console.log(date1);
        y = convertTime12to24($('#workHoursTo').val());
        date2 = new Date()
        date2.setHours(y.hours);
        date2.setMinutes(y.minutes);
        console.log(date2);
        if (date2 < date1) {
            date2.setDate(date2.getDate() + 1);
        }
        var diff = date2 - date1;
        console.log("diff");
        console.log(diff);
        console.log(msToTime(diff))

    }
});


    function timeToInt(time) {
        var arr = time.match(/^(0?[1-9]|1[012]):([0-5][0-9])([APap][mM])$/);
        if (arr == null) return -1;

        if (arr[3].toUpperCase() == 'PM') {
        arr[1] = parseInt(arr[1]) + 12;
        }
        return parseInt(arr[1]*100) + parseInt(arr[2]);
    }

    function checkDates() {
        if (($('#workHoursFrom').val() == '') || ($('#workHoursTo').val() == '')) return;

        var workHoursFrom = timeToInt($('#workHoursFrom').val());
        var workHoursTo = timeToInt($('#workHoursTo').val());

        if ((workHoursFrom == -1) || (workHoursTo == -1)) {
        alert("Start or end time it's not valid");
        }

        if (workHoursFrom > workHoursTo) {
            console.log('Start time should be lower than end time');
            $('#workHoursTo').prop('value' ,'');
            $("#error-time").show();

        }else{
            $("#error-time").hide();

        }

    }


    function parseTime(s) {
        var part = s.match(/(\d+):(\d+)(?: )?(am|pm)?/i);
        var hh = parseInt(part[1], 10);
        var mm = parseInt(part[2], 10);
        var ap = part[3] ? part[3].toUpperCase() : null;
        if (ap === "AM") {
            if (hh == 12) {
                hh = 0;
            }
        }
        if (ap === "PM") {
            if (hh != 12) {
                hh += 12;
            }
        }
        //parseTime("01:00 PM"); // {hh: 13, mm: 0}
        return { hh: hh, mm: mm };
        //  return hh+':'+mm;
    }



    function calculate_difreance_two_time( time1, time2) {
        parseTime()
        var date1 = new Date(2000, 0, 1,  9, 0); // 9:00 AM
        var date2 = new Date(2000, 0, 1, 17, 0); // 5:00 PM
    }

    const convertTime12to24 = (time12h) => {
        console.log('convertTime12to24');
        time12h = time12h.replace(/^\s+|\s+$/g, "");
        console.log(time12h);
        console.log("hour");
        console.log(time12h[0] + time12h[1]);
        hours = time12h[0] + time12h[1];
        console.log("min");
        console.log(time12h[3] + time12h[4]);
        minutes = time12h[3] + time12h[4];
        console.log("modifier");
        console.log(time12h[5] + time12h[6]);
        modifier = time12h[5] + time12h[6];

        // const [time, modifier] = time12h.split(' ');
        // let [hours, minutes] = time.split(':');
        // console.log("minutes");
        // console.log(minutes);
        // modifier = minutes[3]+minutes[4];
        // console.log(hours , minutes , time , modifier);

        if (hours === '12') {
          hours = '00';
        }

        if (modifier === 'PM') {
          hours = parseInt(hours, 10) + 12;
        }

       // return `${hours}:${minutes}`;
       return  {hours:hours , minutes:minutes};
      }



    function msToTime(duration) {
        var milliseconds = parseInt((duration % 1000) / 100),
            seconds = Math.floor((duration / 1000) % 60),
          minutes = Math.floor((duration / (1000 * 60)) % 60),
          hours = Math.floor((duration / (1000 * 60 * 60)) % 24);

        hours = (hours < 10) ? "0" + hours : hours;
        minutes = (minutes < 10) ? "0" + minutes : minutes;
        seconds = (seconds < 10) ? "0" + seconds : seconds;

        return hours + ":" + minutes + ":" + seconds + "." + milliseconds;
    }
        /** LoadMore */
        $(document).on("click" ,"#load_more_button" ,function(event) {
            console.log("Ajax Send Request -loadmore");
            url  = $(this).attr("url");
            console.log(url);
            countRaw = $(this).attr("count-raw");
            id = $(this).attr('task-user-apply-id');
            console.log(id);
            _token = $('input[name ="_token"]').val();
            console.log(_token)
            load_more(id , url , _token );


        });

        /** LoadMore project*/
        $(document).on("click" ,"#load_more_projects_button" ,function(event) {
            console.log("Ajax Send Request -loadmore-project");
            url  = $(this).attr("url");
            console.log(url);
            countRaw = $(this).attr("count-raw");
            id = $(this).attr('task-user-apply-id');
            console.log(id);
            _token = $('input[name ="_token"]').val();
                    console.log(_token)
            load_more_projects(id , url , _token );
        });

});
function load_more(id ,url, _token) {
    $.ajax({
        url:url ,
        method:'POST',
        data:{id:id , _token:_token } ,
        success: function (data) {
            console.log(data);
            $("#load_more_button").remove();
            $("#post_data").append(data);
        }
    })
}
function load_more_projects(id ,url, _token) {
    $.ajax({
        url:url ,
        method:'POST',
        data:{id:id , _token:_token } ,
        success: function (data) {
            console.log(data);
            $("#load_more_projects_button").remove();
            $("#post_data_projects").append(data);
        }
    })
}
