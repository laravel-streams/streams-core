
let argv = process.argv



const plugins = [
    // 'typedoc-plugin-custom-tags',
    // 'typedoc-plugin-external-module-name',
    'typedoc-plugin-extras',
    // 'typedoc-plugin-inline-sources',
    //'typedoc-plugin-markdown',
    'typedoc-plugin-merge-modules',
    // 'typedoc-plugin-mermaid',
];

if(argv.includes('--markdown')){
    plugins.push('typedoc-plugin-markdown')
}

module.exports = {
    entryPoints: ['./resources/lib/index.ts'],
    exclude: 'test/**/*.ts',
    out        : './client-api',
    tsconfig   : './typedoc.tsconfig.json',
    theme      : 'default',
    //https://marked.js.org/using_advanced#options
    markedOptions: {
        'mangle': false
    },
    plugin       : plugins
};
