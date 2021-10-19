Streams Platform Client Api - v1.0.2 / [Exports](modules.md)

# Streams Platform Client Api

@todo intro text

```html
{!! Assets::tag('/vendor/streams/core/js/index.js') !!}
{!! Assets::tag('/vendor/streams/ui/js/index.js') !!}

{!! Assets::tag('/js/app.js') !!}

<script>
(function () {
    var streams = window.streams
    var app = streams.core.app;

    app
        .initialize({
            providers: [
                streams.core.CoreServiceProvider,
                streams.ui.UiServiceProvider,
                window.app.AppServiceProvider
            ],
            config   : {
                streams: {},
                http   : {}
            }
        })
        .then(app.boot.bind(app))
        .then(function (app) {
            app.start();
        })
        .then(function (app) {
            // started
        });
}).call(window);
</script>

```
