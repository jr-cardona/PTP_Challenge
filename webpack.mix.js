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

mix.js('resources/js/app.js', 'public/js')
    .js('resources/js/delete-modal', 'public/js')
    .js('resources/js/annul-modal', 'public/js')
    .js('resources/js/import-modal', 'public/js')
    .js('resources/js/export-modal', 'public/js')
    .js('resources/js/assign-format', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sass('resources/sass/auth.scss', 'public/css')
    .sass('resources/sass/error.scss', 'public/css')
    .sass('resources/sass/custom.scss', 'public/css')
    .extract();
