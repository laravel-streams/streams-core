<?php namespace Anomaly\Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;

class AddonServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    protected $types = [
        'distribution', // Distributions always first
        'module', // Modules always second
        'field_type',
        'extension',
        'block',
        'theme',
        'tag',
    ];

    public function register()
    {

        $this->registerAddonCollections(); // First

        $this->registerAddonClasses();
        $this->registerAddonVendorAutoloaders();

        $this->registerAddonTypes();

        $this->registerAddonServiceProviders();
    }

    protected function registerAddonCollections()
    {
        foreach ($this->types as $type) {

            $studly = studly_case($type);

            $plural = str_plural($type);

            $collection = 'Anomaly\Streams\Platform\Addon\\' . $studly . '\\' . $studly . 'Collection';

            $this->app->singleton(
                "streams.{$plural}",
                function () use ($collection) {

                    return new $collection;
                }
            );
        }
    }

    protected function registerAddonClasses()
    {
        foreach ($this->types as $type) {

            $type = studly_case($type);

            $provider = 'Anomaly\Streams\Platform\Addon\\' . $type . '\\' . $type . 'ServiceProvider';

            $this->app->register($provider);
        }
    }

    protected function registerAddonVendorAutoloaders()
    {
        $loader = new ClassLoader();

        foreach ($this->types as $type) {

            $plural = str_plural($type);

            foreach (app("streams.{$plural}")->all() as $addon) {

                $vendorPath = $addon->getPath() . '/vendor/';
                $vendorFile = 'autoload.php';

                if (is_file($vendorPath . $vendorFile)) {

                    $autoload = require $vendorPath . $vendorFile;

                    if (!empty($autoload['psr-0'])) {

                        foreach ($autoload['psr-0'] as $namespace => $path) {

                            $loader->add($namespace, $this->getVendorPsrPath($vendorPath, $path));
                        }
                    }

                    if (!empty($autoload['psr-4'])) {

                        foreach ($autoload['psr-4'] as $namespace => $path) {

                            $loader->addPsr4($namespace, $this->getVendorPsrPath($vendorPath, $path));
                        }
                    }
                }
            }
        }

        $loader->register();
    }

    protected function getVendorPsrPath($vendorPath, $path)
    {
        if (is_array($path)) {
            foreach ($path as &$p) {
                $p = $vendorPath . $p;
            }
        } else {
            $path = $vendorPath . $path;
        }

        return $path;
    }

    protected function registerAddonTypes()
    {
        $this->app->singleton(
            'streams.addon_types',
            function () {

                return $this->types;
            }
        );
    }

    protected function registerAddonServiceProviders()
    {
        foreach ($this->types as $type) {

            $plural = str_plural($type);

            foreach (app("streams.{$plural}")->all() as $addon) {

                $provider = get_class($addon).'ServiceProvider';

                if (class_exists($provider)) {

                    $app      = $this->app;
                    $provider = $this->app->make($provider, [$app]);

                    $this->app->register($provider);

                    $provider->register();
                }
            }
        }
    }
}
