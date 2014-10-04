<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Addon\AddonRepository;

class AddonRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register a repository for each addon type.
     */
    public function register()
    {
        foreach (config('streams.addons.types') as $type) {
            $this->app->singleton(
                'streams.' . str_plural($type),
                function () use ($type) {
                    return new AddonRepository(app("streams.{$type}.loaded"));
                }
            );
        }
    }
}
