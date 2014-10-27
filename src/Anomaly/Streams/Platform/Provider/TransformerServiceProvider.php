<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\Transformer;
use Illuminate\Support\ServiceProvider;

class TransformerServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->bind(
            'streams.transformer',
            function () {

                return new Transformer();

            }
        );
    }
}
