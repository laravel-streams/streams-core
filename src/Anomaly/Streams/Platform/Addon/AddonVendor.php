<?php namespace Anomaly\Streams\Platform\Addon;

use Composer\Autoload\ClassLoader;

class AddonVendor extends ClassLoader
{
    public function load($path)
    {
        $vendorPath = $path . '/vendor/';
        $vendorFile = 'autoload.php';

        if (is_file($vendorPath . $vendorFile)) {

            $autoload = require_once $vendorPath . $vendorFile;

            if (!empty($autoload['psr-0'])) {
                foreach ($autoload['psr-0'] as $namespace => $path) {
                    $this->add($namespace, $this->vendorPaths($vendorPath, $path));
                }
            }

            if (!empty($autoload['psr-4'])) {
                foreach ($autoload['psr-4'] as $namespace => $path) {
                    $this->addPsr4($namespace, $this->vendorPaths($vendorPath, $path));
                }
            }
        }

        $this->register();
    }

    protected function vendorPaths($vendorPath, $path)
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
