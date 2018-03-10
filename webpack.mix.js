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

mix.js([
    'node_modules/flot/jquery.flot.js',
    'node_modules/flot/jquery.flot.time.js',
    'node_modules/flot/jquery.flot.categories.js'
], 
'public/vendor/flot/flot.bundle.js');
