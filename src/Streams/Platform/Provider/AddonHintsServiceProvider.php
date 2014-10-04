<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonHintsServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register namespace hints for addons.
     */
    public function register()
    {
        foreach (config('streams.addons.types') as $type) {
            foreach (app("streams.{$type}.loaded") as $abstract) {
                $this->registerNamespaceHints(app($abstract));
            }
        }
    }

    /**
     * Register namespace hints for an addon.
     *
     * @param $addon
     */
    protected function registerNamespaceHints($addon)
    {
        $abstract = str_replace('streams.', null, $addon->getAbstract());

        app('view')->addNamespace($abstract, $addon->getPath('resources/views'));
        app('config')->addNamespace($abstract, $addon->getPath('resources/config'));
        app('translator')->addNamespace($abstract, $addon->getPath('resources/lang'));

        app('streams.asset')->addNamespace($abstract, $addon->getPath('resources'));
        app('streams.image')->addNamespace($abstract, $addon->getPath('resources'));
    }
}
