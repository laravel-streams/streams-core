{{ assets('platform.js', 'streams::js/vue.js') }}
{{ assets('platform.js', 'streams::js/lodash.js') }}
{{ assets('platform.js', 'streams::js/streams_platform.js') }}
{!! assets()->script("platform.js") !!}

<script>
(function () {
    
    var app = window.streams.core.app;

    app.bootstrap({
            providers: [
                window.streams.core.PlatformServiceProvider
            ],
            config   : {},
            data     : {},
        })
        .then(app.boot)
        .then(function (app) {
            console.log('App Start')
            return app.start('#app');
        })
        .catch(app.error);
}());
</script>
