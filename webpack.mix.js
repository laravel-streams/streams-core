const mix = require('laravel-mix');
require('@laravel-streams/mix-extension');

mix
    .ts('resources/lib/index.ts', '')
    .copy('resources/lib/global.d.ts', 'resources/public/types/global.d.ts')
    .copyDirectory('resources/public', '../../../public/vendor/streams/core')
    .options({
        sourcemaps: false,
        clearConsole:false,
        notifications:true
    })
    .streams({
        name: ['streams', 'core']
    });
if ( !mix.inProduction() ) {
    mix.sourceMaps();
}




