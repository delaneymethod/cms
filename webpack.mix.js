const del = require('del');
const { mix } = require('laravel-mix');

del(['public/assets/**', '!public/assets']);

mix.setPublicPath('public');

if (mix.inProduction) {
    mix.disableNotifications();
}

if (!mix.inProduction) {
	mix.sourceMaps();
}

mix.options({
	processCssUrls: false
});

// Frontend Assets
mix.sass('resources/assets/sass/global.scss', 'public/assets/css/global.css');

mix.js('resources/assets/js/global.js', 'public/assets/js/global.js');

mix.copy('resources/assets/fonts', 'public/assets/fonts');

mix.copy('node_modules/font-awesome/fonts', 'public/assets/fonts');

mix.copy('resources/assets/img', 'public/assets/img');

// Dashboard Assets
mix.sass('resources/assets/dashboard/sass/global.scss', 'public/assets/dashboard/css/global.css');

mix.js('resources/assets/dashboard/js/global.js', 'public/assets/dashboard/js/global.js');

mix.version();
