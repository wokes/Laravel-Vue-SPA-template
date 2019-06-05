const mix = require('laravel-mix');

mix.webpackConfig({
    resolve: {
        modules: [
            path.resolve(__dirname, 'resources/assets/js'),
            'node_modules'
        ],
        extensions: ['.js', '.json', '.vue']
    }
})

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
    .sass('resources/sass/app.scss', 'public/css')
    .version();
