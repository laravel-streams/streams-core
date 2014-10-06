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
        foreach (config('streams::addons.types') as $type) {

            $studly = studly_case($type);

            $repository = 'Streams\Platform\Addon\\' . $studly . '\\' . $studly . 'Repository';

            $this->app->singleton(
                'streams.' . str_plural($type),
                function () use ($repository, $type) {
                    return new $repository(app("streams.{$type}.loaded"));
                }
            );
        }
    }
}
