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
        foreach (config('streams.addons.types') as $type) {
            $class         = studly_case($type);
            $namespace     = $class . '\\';
            $baseNamespace = 'Streams\Platform\Addon\\';

            $serviceProvider = $baseNamespace . $namespace . $class . 'ServiceProvider';

            $this->app->register($serviceProvider);
        }
    }
}
