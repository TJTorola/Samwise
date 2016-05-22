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
	mix.sass('adminLTE.scss', 'resources/assets/css/adminLTE.css');
	mix.sass('bootstrap.scss', 'resources/assets/css/_bootstrap.css');
	mix.sass('font-awesome.scss', 'resources/assets/css/font-awesome.css');
	mix.sass('main.scss', 'resources/assets/css/main.css');
	mix.sass('skin-blue.scss', 'resources/assets/css/skin-blue.css');
	mix.stylesIn('resources/assets/css', 'public/css/vendor.min.css');
	mix.browserify('main.js', 'public/js/main.min.js');
	mix.scriptsIn('resources/assets/js/vendor', 'public/js/vendor.min.js');

	mix.browserify('assets/js/main.js','storefront/public/js','storefront');
	mix.browserify('assets/js/page_editor/main.js','storefront/public/js/pageEditor.js','storefront');
});
