const mix = require('laravel-mix');
const path = require('path');
const {execSync} = require('child_process');
const parse = require('yargs-parser');
const webpack = require('webpack')
let isProd = mix.inProduction();
let isDev = !mix.inProduction();

function getTarget() {
    const targets = [
        ['assign', ['streams', 'core'], 'js/[name].js'],
        ['window', ['streams', 'core'], 'js/[name].browser.js'],
        ['module', null, 'js/[name].esm.js'],
        ['umd', ['streams', 'core'], 'js/[name].umd.js'],
        ['commonjs', ['streams', 'core'], 'js/[name].cjs.js'],
        ['commonjs2', ['streams', 'core'], 'js/[name].cjs2.js'],
    ];
    const KEY = 'STREAMS_EXPORT';
    let target = targets[0];
    if ( process.env[KEY] !== undefined ) {
        let index = targets.findIndex(t => t[0] === process.env[KEY]);
        target = targets[index];
    }
    return target;
}

const target = getTarget();
let library = {type: target[0]};
if ( target[1] !== null ) library.name = target[1];

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

const webpackConfig = {

    devtool    : 'inline-cheap-module-source-map',
    resolve    : {
        alias: {
            '@': path.resolve(__dirname, 'resources/lib')
        }
    },
    output     : {
        path                                 : path.resolve('./resources/public'),
        filename                             : target[2], //'js/[name].js',
        chunkFilename                        : 'js/chunk.[name].js',
        library,
        publicPath                           : '/vendor/streams/core/',
        devtoolFallbackModuleFilenameTemplate: 'webpack:///[resource-path]?[hash]',
        devtoolModuleFilenameTemplate        : info => {
            var $filename = 'sources://' + info.resourcePath;
            $filename = 'webpack:///' + info.resourcePath; // +'?' + info.hash;
            if ( info.resourcePath.match(/\.vue$/) && !info.allLoaders.match(/type=script/) && !info.query.match(/type=script/) ) {
                $filename = 'webpack-generated:///' + info.resourcePath; // + '?' + info.hash;
            }
            return $filename;
        }
    },
    optimization:{
        moduleIds:'named',
        chunkIds:'named',
        minimize: true,
    },
    experiments: {}
};
if ( webpackConfig.output.library.type === 'module' ) {
    webpackConfig.experiments.outputModule = true;
}
if(process.env.DISABLE_MINIMIZE){
    webpackConfig.optimization.minimize=false;
}

mix
    .ts('resources/lib/index.ts', '')
    .copy('resources/lib/global.d.ts', 'resources/public/types/global.d.ts')
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .options({
sourcemaps:false,
        terser: {
            terserOptions: {
                keep_classnames: true,
                keep_fnames    : true,
            }
        }
    })
    .babelConfig(babelConfig)
    .webpackConfig(webpackConfig)
    .override((config) => {

        let rule = config.module.rules.find(rule => rule.loader === require.resolve('ts-loader'));
        delete rule.loader;
        delete rule.options;
        rule.use = [
            // {
            //     loader : 'babel-loader',
            //     options: babelConfig,
            // },
            {
                loader : 'ts-loader',
                options: {
                    transpileOnly  : true,
                    logLevel       : 'INFO',
                    logInfoToStdOut: true,
                    happyPackMode  : true,
                    configFile     : path.resolve(__dirname, 'webpack.tsconfig.json'),
                    compilerOptions: {
                        target        : 'es6',
                        module        : 'esnext',
                        declaration   : false,
                        declarationDir: path.resolve(__dirname, 'resources/public/types'),
                        importHelpers : true,
                        sourceMap     : isDev,
                        removeComments: isProd,
                        experimentalWatchApi: true,

                    },
                }
            }
        ];
    });

if ( !mix.inProduction() ) {
    mix.sourceMaps();
}
