<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonClassServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register all the addon classes.
     */
    public function register()
    {
        foreach (config('streams::addons.types') as $type) {

            $type = studly_case($type);
            
            $provider = 'Streams\Platform\Addon\\' . $type . '\\' . $type . 'ServiceProvider';

            $this->app->register($provider);

        }
    }
}
