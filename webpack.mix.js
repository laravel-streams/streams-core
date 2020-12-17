let mix = require('laravel-mix');

require('laravel-mix-purgecss');

mix
    .ts('./resources/ts/index.ts', './resources/public/js')
    .copyDirectory(
        './node_modules/@fortawesome/fontawesome-free/webfonts',
        './resources/public/fonts/fontawesome'
    )
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .webpackConfig(

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
        })
    .sourceMaps();
