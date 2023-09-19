let mix = require('laravel-mix');

mix.js('src/resources/js/tid.js', 'public/js')
    .sass('src/resources/sass/tid.scss', 'public/css')
	.copyDirectory('src/resources/img', 'public/img/tid');

    
if (mix.inProduction()) {
    mix.version();
}