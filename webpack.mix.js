const mix = require('laravel-mix');


mix.js('resources/js/app.js', 'public/js').vue();
mix.sass('resources/sass/app.scss', 'public/css')
	.sass('resources/sass/dashboard.scss', 'public/css')
	.options({
		processCssUrls: false
});

// mix.copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts');
// mix.copy([
//  	'node_modules/overlayscrollbars/css/OverlayScrollbars.css',
//  	'node_modules/overlayscrollbars/css/OverlayScrollbars.min.css'
// ], 'public/css/overlayscrollbars');