var elixir = require('laravel-elixir');

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

elixir(function (mix) {
    mix.sass('app.scss');

    
    // Vendor
    mix.copy('resources/assets/vendor/bower_components/jquery/dist/jquery.js', 'public/vendor/jquery');
    mix.copy('resources/assets/vendor/bower_components/bootstrap/dist/css/bootstrap.css', 'public/vendor/bootstrap');
    mix.copy('resources/assets/vendor/bower_components/bootstrap/dist/js/bootstrap.js', 'public/vendor/bootstrap');
    mix.copy('resources/assets/vendor/bower_components/select2/dist/css/select2.css', 'public/vendor/select2');
    mix.copy('resources/assets/vendor/bower_components/select2/dist/js/select2.js', 'public/vendor/select2');
    mix.copy('resources/assets/vendor/bower_components/AdminLTE/dist/css/AdminLTE.css', 'public/vendor/admin-lte');
    mix.copy('resources/assets/vendor/bower_components/AdminLTE/dist/js/app.js', 'public/vendor/admin-lte');
    mix.copy('resources/assets/vendor/bower_components/AdminLTE/dist/css/skins/*.css', 'public/vendor/admin-lte/skins');

    mix.copy('resources/assets/css/styles.css', 'public/css');
    mix.copy('resources/assets/css/style_v1.css', 'public/css');
    mix.copy('resources/assets/js/devoops.js', 'public/js');
    mix.copy('resources/assets/img', 'public/img');
});
