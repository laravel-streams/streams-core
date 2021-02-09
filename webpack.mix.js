let mix = require('laravel-mix');
const path = require('path');

const isDev = process.env.NODE_ENV === 'development';

mix
    .ts('resources/ts/index.ts', '')
    .copyDirectory(
        './node_modules/@fortawesome/fontawesome-free/webfonts',
        './resources/public/fonts/fontawesome'
    )
    .copyDirectory('resources/public', '../../public/vendor/streams/core')
    .webpackConfig(

        /**
         * @return webpack.Configuration
         * */
        function (webpack) {

            return {
                devtool: isDev ? 'hidden-source-map' : null,
                plugins: [
                    //require('@tailwindcss/ui'),
                ],
                output: {
                    path: path.resolve('./resources/public'),
                    filename: 'js/[name].js',
                    chunkFilename: 'js/chunk.[name].js',
                    library: ['streams', 'core'],
                    publicPath: '/vendor/streams/core/',
                    libraryTarget: 'window',
                    devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
                    devtoolModuleFilenameTemplate: info => {
                        var $filename = 'sources://' + info.resourcePath;
                        $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
                        if (info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/)) {
                            $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
                        }
                        return $filename;
                    }
                }
            };
        })
    .sourceMaps();
