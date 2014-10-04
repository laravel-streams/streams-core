<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Addon\AddonTypeClassResolver;

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
        $resolver = new AddonTypeClassResolver();

        foreach (config('streams::addons.types') as $type) {
            $this->app->register($resolver->resolveServiceProvider($type));
        }
    }
}
