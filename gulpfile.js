const elixir = require('laravel-elixir');

require('laravel-elixir-vue');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir(mix => {
    mix.sass('app.scss');


        // jQuery
        mix.copy('node_modules/jquery/dist/jquery.js', 'public/vendor/jquery');

        // Bootstrap
        mix.copy('node_modules/bootstrap/dist/css/bootstrap.css', 'public/vendor/bootstrap');
        mix.copy('node_modules/bootstrap/dist/js/bootstrap.js', 'public/vendor/bootstrap');

        // Select2
        mix.copy('node_modules/select2/dist/css/select2.css', 'public/vendor/select2');
        mix.copy('node_modules/select2/dist/js/select2.js', 'public/vendor/select2');

        // Bootstrap Datepicker
        mix.copy('node_modules/bootstrap-datepicker/dist/css/bootstrap-datepicker.css', 'public/vendor/bootstrap-datepicker');
        mix.copy('node_modules/bootstrap-datepicker/dist/js/bootstrap-datepicker.js', 'public/vendor/bootstrap-datepicker');

        // AdminLTE
        mix.copy('node_modules/admin-lte/dist/css/AdminLTE.css', 'public/vendor/admin-lte');
        mix.copy('node_modules/admin-lte/dist/js/app.js', 'public/vendor/admin-lte');
        mix.copy('node_modules/admin-lte/dist/css/skins/*.css', 'public/vendor/admin-lte/skins');

        // Vue
        mix.copy('node_modules/vue/dist/vue.js', 'public/vendor/vue');

        mix.copy('resources/assets/css/styles.css', 'public/css');
        mix.copy('resources/assets/css/style_v1.css', 'public/css');
        mix.copy('resources/assets/js/devoops.js', 'public/js');
        mix.copy('resources/assets/img', 'public/img');
});
