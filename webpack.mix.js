let mix = require('laravel-mix');
const tailwindcss = require('tailwindcss');
require('laravel-mix-purgecss');

/*
 |--------------------------------------------------------------------------
 | Webpack Configuration
 |--------------------------------------------------------------------------
 |
 | Configure webpack...
 |
 */
mix.webpackConfig(
    
    /**
     * @return webpack.Configuration
     * */
    function (webpack) {

        return {
            plugins: [
                require('@tailwindcss/ui'),
            ],
            output: {
                library: ['streams', 'core'],
                libraryTarget: 'window'
            }
        };
    });

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

mix
    .ts('./resources/ts/index.ts', './resources/public/js')
    .copyDirectory(
        './node_modules/@fortawesome/fontawesome-free/webfonts',
        './resources/public/fonts/fontawesome'
    )
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.config.js'),
        ],
    })
    .sourceMaps();
