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

elixir(function(mix) {
    mix.sass('app.scss', 'resources/assets/css/app.css');
    mix.stylesIn('resources/assets/css', 'public/css/vendor.css');
    mix.browserify('main.js');
    mix.scriptsIn('resources/assets/js/vendor', 'public/js/vendor.js');
});
