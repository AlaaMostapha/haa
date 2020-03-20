const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

//mix.js('resources/assets/js/firebase-messaging.js', '/js/firebase-messaging.min.js');
//mix.js('resources/assets/js/firebase-messaging-sw.js', '/firebase-messaging-sw.js');

mix.copy('resources/assets/frontend/fonts', 'public/frontend/fonts');
mix.copy('resources/assets/frontend/images', 'public/frontend/images');

mix.styles([
    'resources/assets/frontend/css/fonts.css',
    'resources/assets/frontend/css/bootstrap.min.css',
    'resources/assets/frontend/css/bootstrap-grid.min.css',
    'resources/assets/frontend/css/font-awesome.min.css',
    'resources/assets/frontend/css/jquery.fancybox.min.css',
    'resources/assets/frontend/css/owl.carousel.min.css',
    'resources/assets/frontend/css/aos.css',
    'resources/assets/frontend/css/nice-select.css',
    'resources/assets/frontend/css/responsive.dataTables.min.css',
    'resources/assets/frontend/css/jquery.dataTables.min.css',
    'resources/assets/frontend/css/bootstrap-datepicker.min.css',
    'resources/assets/frontend/css/style.css',
    'resources/assets/frontend/css/bootstrap-rtl.min.css',
    'resources/assets/frontend/css/style-ar.css',
    'resources/assets/frontend/css/style-res.css',
    
    'resources/assets/common/css/developer-style.css',
    'node_modules/dropzone/dist/dropzone.css',
    'resources/assets/frontend/css/custom_style.css',
    'node_modules/jquery-toast-plugin/dist/jquery.toast.min.css',
    'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.css',
    'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput-typeahead.css',
    'resources/assets/frontend/css/select2.min.css',
    'resources/assets/frontend/css/select2-bootstrap-theme.min.css',
    'resources/assets/dashboard/css/plugins/clockpicker/clockpicker.css',
    'resources/assets/frontend/css/general.css',
    // 'resources/assets/frontend/css/select2.min.css',
    // 'node_modules/select2/dist/css/select2.min.css',
], 'public/frontend/css/app.min.css').sourceMaps();

mix.scripts([
    'resources/assets/frontend/js/jquery-2.2.2.min.js',
    'resources/assets/frontend/js/bootstrap.min.js',
    'resources/assets/frontend/js/jquery.fancybox.min.js',
    'resources/assets/frontend/js/owl.carousel.min.js',
    'resources/assets/frontend/js/aos.js',
    'resources/assets/frontend/js/jquery.nice-select.min.js',
    'resources/assets/frontend/js/amir-upload-files.js',
    'resources/assets/frontend/js/moment-with-locales.js',
    'resources/assets/frontend/js/bootstrap-datetimepicker.js',
    'resources/assets/frontend/js/jquery.dataTables.min.js',
    'resources/assets/frontend/js/dataTables.responsive.min.js',
    // 'resources/assets/frontend/js/select2.min.js',
    // 'node_modules/select2/dist/js/select2.full.min.js',
    'resources/assets/frontend/js/script.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/jquery-validation/dist/additional-methods.min.js',
    'node_modules/jquery-validation/dist/localization/messages_ar.js',
    'resources/assets/common/js/developer-js.js',
    'node_modules/sweetalert/dist/sweetalert.min.js',
    'node_modules/dropzone/dist/dropzone.js',
    'node_modules/jquery-toast-plugin/dist/jquery.toast.min.js',
    'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.js',
    'resources/assets/frontend/js/select2.min.js',
    'resources/assets/dashboard/js/plugins/clockpicker/clockpicker.js',

], 'public/frontend/js/app.min.js', './').sourceMaps();


mix.sass('resources/assets/dashboard/sass/app.scss', 'public/dashboard/css/app.css').sourceMaps();
mix.copy('resources/assets/dashboard/css/pdf-export.css', 'public/dashboard/css/pdf-export.css').sourceMaps();
mix.copy('resources/assets/dashboard/vendor/bootstrap/fonts', 'public/dashboard/fonts');
mix.copy('resources/assets/dashboard/vendor/unisharp', 'public/vendor/unisharp');
mix.copy('resources/assets/dashboard/fonts', 'public/dashboard/fonts');

mix.styles([
    'resources/assets/dashboard/css/plugins/bootstrap-rtl/bootstrap-rtl.min.css',
    'resources/assets/dashboard/css/rtl.css',
], 'public/dashboard/css/rtl.min.css', './').sourceMaps();
mix.copy('node_modules/jquery-validation/dist/localization/messages_ar.js', 'public/dashboard/js/plugins/jquery-validation/dist/localization/messages_ar.js').sourceMaps();
mix.copy('resources/assets/dashboard/img', 'public/dashboard/img');
mix.copy('resources/assets/dashboard/images', 'public/dashboard/images');
mix.copy('resources/assets/dashboard/vendor/font-awesome/fonts', 'public/dashboard/fonts');
mix.styles([
    'resources/assets/dashboard/vendor/bootstrap/css/bootstrap.css',
    'resources/assets/dashboard/vendor/font-awesome/css/font-awesome.css',
    'resources/assets/dashboard/css/plugins/ladda/ladda-themeless.min.css',
    'resources/assets/dashboard/css/plugins/clockpicker/clockpicker.css',
    // 'resources/assets/dashboard/css/plugins/datapicker/datepicker3.css',
    'resources/assets/frontend/css/bootstrap-datepicker.min.css',
    'resources/assets/dashboard/vendor/animate/animate.css',
    'resources/assets/dashboard/css/plugins/colorpicker/bootstrap-colorpicker.min.css',
    'node_modules/select2/dist/css/select2.min.css',
    'resources/assets/pusher/css/toastr.min.css',
    'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.css',
    'node_modules/dropzone/dist/dropzone.css',
], 'public/dashboard/css/vendor.css', './').sourceMaps();
mix.scripts([
    'resources/assets/dashboard/vendor/jquery/jquery-3.1.1.min.js',
    'resources/assets/dashboard/vendor/bootstrap/js/bootstrap.js',
    'resources/assets/dashboard/vendor/metisMenu/jquery.metisMenu.js',
    'resources/assets/dashboard/vendor/slimscroll/jquery.slimscroll.min.js',
    'resources/assets/dashboard/vendor/pace/pace.min.js',
    'resources/assets/dashboard/js/plugins/ladda/spin.min.js',
    'resources/assets/dashboard/js/plugins/ladda/ladda.min.js',
    'resources/assets/dashboard/js/plugins/ladda/ladda.jquery.min.js',
    'node_modules/jquery-validation/dist/jquery.validate.min.js',
    'node_modules/autosize/dist/autosize.min.js',
    'resources/assets/dashboard/js/plugins/clockpicker/clockpicker.js',


    'resources/assets/dashboard/js/plugins/colorpicker/bootstrap-colorpicker.min.js',
    'node_modules/select2/dist/js/select2.full.min.js',
    'node_modules/select2/dist/js/i18n/ar.js',
    'resources/assets/pusher/js/toastr.min.js',
    'resources/assets/pusher/js/pusher.min.js',
    'resources/assets/pusher/js/pusher-dev.js',
    'node_modules/sweetalert/dist/sweetalert.min.js',
    'node_modules/bootstrap-tagsinput/src/bootstrap-tagsinput.js',
    'node_modules/dropzone/dist/dropzone.js',
    'resources/assets/dashboard/js/dashboard.js',
    'resources/assets/dashboard/js/app.js',
    'resources/assets/frontend/js/jquery.nice-select.min.js',
    
    'resources/assets/frontend/js/moment-with-locales.js',
    'resources/assets/frontend/js/bootstrap-datetimepicker.js',
    'resources/assets/dashboard/js/plugins/datapicker/bootstrap-datepicker.js',

    'resources/assets/common/js/developer-js.js',
], 'public/dashboard/js/app.js', './').sourceMaps();


if (mix.inProduction()) {
    mix.version();
}
