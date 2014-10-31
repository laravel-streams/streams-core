<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonServiceProvider extends ServiceProvider
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

        $this->registerAddonNamespaceHints(); // Last

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
        foreach ($this->types as $type) {

            $plural = str_plural($type);

            foreach (app("streams.{$plural}")->all() as $addon) {

                $vendorPath = $addon->getPath() . '/vendor/';
                $vendorFile = 'streams.vendor.autoload.php';

                if (is_file($vendorPath . $vendorFile)) {

                    $autoload = require $vendorPath . $vendorFile;

                    if (!empty($autoload['psr-0'])) {

                        foreach ($autoload['psr-0'] as $namespace => $path) {

                            app('streams.loader')->add($namespace, $this->getVendorPsrPath($vendorPath, $path));
                        }
                    }

                    if (!empty($autoload['psr-4'])) {

                        foreach ($autoload['psr-4'] as $namespace => $path) {

                            app('streams.loader')->addPsr4($namespace, $this->getVendorPsrPath($vendorPath, $path));
                        }
                    }
                }
            }
        }
    }

    protected function registerAddonNamespaceHints()
    {
        foreach ($this->types as $type) {

            $plural = str_plural($type);

            foreach (app("streams.{$plural}")->all() as $addon) {

                $abstract = str_replace('streams.', null, $addon->getAbstract());

                app('view')->addNamespace($abstract, $addon->getPath('resources/views'));
                app('config')->addNamespace($abstract, $addon->getPath('resources/config'));
                app('translator')->addNamespace($abstract, $addon->getPath('resources/lang'));

                app('streams.asset')->addNamespace($abstract, $addon->getPath('resources'));
                app('streams.image')->addNamespace($abstract, $addon->getPath('resources'));
            }
        }
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
}
