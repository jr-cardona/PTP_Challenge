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
    .js('resources/js/import-invoices-modal', 'public/js')
    .js('resources/js/import-clients-modal', 'public/js')
    .js('resources/js/import-products-modal', 'public/js')
    .js('resources/js/import-sellers-modal', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .extract();
