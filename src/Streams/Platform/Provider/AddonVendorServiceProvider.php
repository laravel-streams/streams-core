<?php namespace Streams\Platform\Provider;

use Illuminate\Support\ServiceProvider;

class AddonVendorServiceProvider extends ServiceProvider
{
    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the vendor autoloaders for addons.
     */
    public function register()
    {
        foreach (config('streams::addons.types') as $type) {
            foreach (app("streams.{$type}.loaded") as $abstract) {
                $this->registerAddonVendors(app($abstract));
            }
        }
    }

    /**
     * Register addon vendors.
     *
     * @param $addon
     */
    protected function registerAddonVendors($addon)
    {
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

    /**
     * Get the external vendor PSR path.
     *
     * @param $vendorPath
     * @param $path
     * @return string
     */
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
