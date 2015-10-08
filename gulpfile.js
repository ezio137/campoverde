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

    mix.styles([
        'bootstrap/dist/css/bootstrap.css',
        'select2/dist/css/select2.css'
    ], 'public/css/vendor.css', 'resources/assets/vendor/bower_components');

    mix.scripts([
        'jquery/dist/jquery.js',
        'bootstrap/dist/js/bootstrap.js',
        'select2/dist/js/select2.js'
    ], 'public/js/vendor.js', 'resources/assets/vendor/bower_components');

    mix.copy('resources/assets/css/style_v1.css', 'public/css');
    mix.copy('resources/assets/js/devoops.js', 'public/js');
    mix.copy('resources/assets/img', 'public/img');
});
