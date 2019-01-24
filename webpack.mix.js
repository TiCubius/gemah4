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

mix.copy('resources/css/bootstrap.css', 'public/assets/css')
	.copy('resources/css/dataTables.bootstrap4.min.css', 'public/assets/css')
    .copy('resources/js/bootstrap.min.js', 'public/assets/js')
    .copy('resources/js/jquery-3.3.1.min.js', 'public/assets/js')
	.copy('resources/js/poppers.min.js', 'public/assets/js')
	.copy('resources/js/dataTables.bootstrap4.min.js', 'public/assets/js')
	.copy('resources/js/jquery.dataTables.min.js', 'public/assets/js')
	.copyDirectory('resources/images', 'public/assets/images')
    .js('resources/js/app.js', 'public/assets/js')
    .sass('resources/sass/app.sass', 'public/assets/css');
