let mix = require('laravel-mix');

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

mix.copy('resources/assets/css/bootstrap.css', 'public/assets/css')
    .copy('resources/assets/js/bootstrap.min.js', 'public/assets/js')
    .copy('resources/assets/js/jquery-3.3.1.min.js', 'public/assets/js')
    .copy('resources/assets/js/poppers.min.js', 'public/assets/js')
    .js('resources/assets/js/app.js', 'public/assets/js')
    .sass('resources/assets/sass/app.sass', 'public/assets/css');
