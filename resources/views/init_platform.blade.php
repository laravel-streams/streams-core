{!! assets('platform.js', 'streams::js/vue.js') !!}
{!! assets('platform.js', 'streams::js/lodash.js') !!}
{!! assets('platform.js', 'streams::js/streams_platform.js') !!}
{!! assets()->script("platform.js") !!}

<script>
(function () {
    var app = window.anomaly.streams_platform.app;

    app.bootstrap({
            providers: [
                window.anomaly.streams_platform.PlatformServiceProvider
            ],
            config   : {},
            data     : {},
        })
        .then(app.boot)
        .then(function (app) {
            console.log('app start')
            return app.start('#app');
        })
        .catch(app.error);
}());
</script>
