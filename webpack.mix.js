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

// MDC JavaScript.
mix.copy('./node_modules/material-components-web/dist/material-components-web.js', 'public/js/material-components-web.js') 
// JavaScript bundle.
mix.js('resources/assets/vint.js', 'public/js/vint.js')
// CSS bundle.
mix.sass('resources/assets/vint.scss', 'public/css/vint.css', {
  includePaths: [
    'node_modules',
  ],
})
