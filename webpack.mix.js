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
mix.webpackConfig({
    externals: {
        "@anomaly/streams-platform": "streams"
    },
    plugins: [
        require('@tailwindcss/ui'),
    ],
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
    //.js('./resources/js/app.js', './assets/js')
    .js('./resources/assets/js/index.js', './resources/dist/js')
    .sass('./resources/scss/theme.scss', './resources/dist/css')
    .sass('./resources/scss/login.scss', './resources/dist/css')
    .copyDirectory(
        './node_modules/@fortawesome/fontawesome-free/webfonts',
        './resources/dist/fonts/fontawesome'
    )
    .copyDirectory('resources/dist', '../../../public/vendor/anomaly/streams/core')
    .options({
        processCssUrls: false,
        postCss: [
            tailwindcss('./tailwind.config.js'),
        ],
    })
    .sourceMaps();


   // We need to use purge css later

//    if (mix.inProduction()) {
//     mix.purgeCss({
//         enabled: true,

//         whitelist: [
//             'o-navbar--shadow',
//             'o-navbar--white-bg',
//             'pm--toggle',
//             'pm--open',
//             'pm--open-menu',
//             'in-viewport'
//         ],

//         globs: [
//             path.join(__dirname, 'addons/stengarde/pixney/stengarde-theme/resources/**/*.twig'),
//             path.join(__dirname, 'addons/stengarde/pixney/stengarde-theme/resources/**/*.vue'),
//         ],

//         extensions: ['html', 'js', 'php', 'vue', 'twig'],

//     })
//         .version();
// }

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
