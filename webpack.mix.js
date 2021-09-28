let mix = require('laravel-mix');
const path = require('path');

mix
    .ts('resources/lib/index.ts', '')
    .extract(['inversify', 'reflect-metadata', 'wtfetch'])
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .webpackConfig(function (webpack) {
        return {
            devtool: 'inline-source-map',
            resolve: {
                alias: {
                    '@': path.resolve(__dirname, 'resources/lib')
                }
            },
            output : {
                path                                 : path.resolve('./resources/public'),
                filename                             : 'js/[name].js',
                chunkFilename                        : 'js/chunk.[name].js',
                library                              : ['streams', 'core'],
                publicPath                           : '/vendor/streams/core/',
                libraryTarget                        : 'window',
                devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
                devtoolModuleFilenameTemplate        : info => {
                    var $filename = 'sources://' + info.resourcePath;
                    $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
                    if ( info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/) ) {
                        $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
                    }
                    return $filename;
                }
            }
        };
    });

if ( !mix.inProduction() ) {
    mix.sourceMaps();
}
