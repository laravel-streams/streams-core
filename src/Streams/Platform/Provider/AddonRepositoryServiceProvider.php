<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Addon\AddonTypeClassResolver;

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
        $resolver = new AddonTypeClassResolver();

        foreach (config('streams.addons.types') as $type) {

            $repository = $resolver->resolveRepository($type);

            $this->app->singleton(
                'streams.' . str_plural($type),
                function () use ($repository, $type) {
                    return new $repository(app("streams.{$type}.loaded"));
                }
            );
        }
    }
}
