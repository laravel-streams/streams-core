
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

if(process.env.STREAMS_API_MD_DOCS){
    config.plugin.push('typedoc-plugin-markdown');
    config.out = './docs/api'
}


module.exports = config;
