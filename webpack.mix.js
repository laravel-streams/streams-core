const mix = require('laravel-mix');
const path = require('path');


let isProd = mix.inProduction();
let isDev = !mix.inProduction();
const babelConfig = {
    babelrc   : false,
    configFile: false,

    compact   : isProd,
    sourceMaps: isDev,
    comments  : isDev,
    presets   : [
        ['@babel/preset-env', {
            'useBuiltIns': false,
            'targets'    : '> 0.25%, not dead',
        }],
    ],
    plugins   : [
        '@babel/plugin-syntax-dynamic-import'
    ],
};

mix
    .ts('resources/lib/index.ts', '')
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .babelConfig(babelConfig)
    .options({
        terser: {
            terserOptions: {
                keep_classnames:true,
                keep_fnames:true,
            }
        }
    })
    .webpackConfig({
        devtool: 'inline-cheap-module-source-map',
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
    })
    .override((config) => {
        let rule = config.module.rules.find(rule => rule.loader === require.resolve('ts-loader'));
        delete rule.loader
        delete rule.options
        rule.use =[
            {
                loader : 'babel-loader',
                options: babelConfig,
            },
            {
                loader: 'ts-loader',
                options: {
                    transpileOnly        : true,
                    logLevel             : 'INFO',
                    logInfoToStdOut      : true,
                    happyPackMode        : true,
                    compilerOptions      : {
                        target        : 'es6',
                        module        : 'esnext',
                        declaration   : true,
                        declarationDir: path.join(__dirname,'resources/public/types'),
                        emitDeclarationOnly: false,
                        importHelpers : true,
                        sourceMap     : isDev,
                        removeComments: !isDev,

                    },
                }
            }
        ]
    });

if ( !mix.inProduction() ) {
    mix.sourceMaps();
}
