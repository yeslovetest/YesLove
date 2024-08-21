const mix = require('laravel-mix');
mix.options({
    terser: {
        extractComments: false,
    },
    processCssUrls: false
});
mix.js('src/app.js', 'assets/js/app.bundle.js')
    .react();