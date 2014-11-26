<?php namespace Anomaly\Streams\Platform\Provider;

use Anomaly\Streams\Platform\Support\Transformer;

/**
 * Class TransformerServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class TransformerServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->app->singleton(
            'streams.transformer',
            function () {

                return new Transformer();
            }
        );
    }
}
