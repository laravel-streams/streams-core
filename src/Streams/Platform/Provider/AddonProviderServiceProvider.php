<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Addon\AddonTranslator;

class AddonProviderServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register each addon's service provider.
     */
    public function register()
    {
        foreach (config('streams::addons.types') as $type) {
            foreach (app("streams.{$type}.loaded") as $abstract) {
                if ($provider = app($abstract)->newServiceProvider()) {
                    $this->app->register($provider);
                }
            }
        }
    }
}
