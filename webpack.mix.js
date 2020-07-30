const mix = require('laravel-mix');
require('laravel-mix-icomoon');
mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .icomoon();
