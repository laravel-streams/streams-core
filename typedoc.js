let argv = process.argv;


const config = {
    entryPoints: ['./resources/lib/index.ts'],
    exclude    : 'test/**/*.ts',
    out        : './client-api',
    tsconfig   : './typedoc.tsconfig.json',
    theme      : 'default',
    //https://marked.js.org/using_advanced#options
    markedOptions : {
        'mangle': false
    },
    plugin        : [
        // 'typedoc-plugin-custom-tags',
        // 'typedoc-plugin-external-module-name',
        'typedoc-plugin-extras',
        // 'typedoc-plugin-inline-sources',
        //'typedoc-plugin-markdown',
        'typedoc-plugin-merge-modules',
        // 'typedoc-plugin-mermaid',
    ],
    hideGenerator : true,
    readme        : './resources/lib/README.md',
    includeVersion: true,
    name          : 'Streams Platform Client Api',
};

if ( argv.includes('--neo-theme') ) {
    config.theme = './node_modules/typedoc-neo-theme/bin/default';
    config.plugins.push('typedoc-neo-theme');
}
if ( argv.includes('--markdown') ) {
    config.plugins.push('typedoc-plugin-markdown');
}


module.exports = config;
