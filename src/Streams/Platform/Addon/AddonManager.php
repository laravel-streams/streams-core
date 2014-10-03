<?php namespace Streams\Platform\Addon;

use Composer\Autoload\ClassLoader;
use Illuminate\Container\Container;
use Illuminate\Filesystem\Filesystem;
use Streams\Platform\Addon\AddonAbstract;
use Streams\Platform\Traits\CallableTrait;

class AddonManager
{
    use CallableTrait;

    /**
     * The folder within addons locations to scan.
     *
     * @var null
     */
    protected $folder = null;

    /**
     * Enable storage?
     *
     * @var bool
     */
    protected $storage = true;

    /**
     * The registration method used for this type of addon.
     *
     * @var string
     */
    protected $method = 'bind';

    /**
     * A runtime cache of registered addons.
     *
     * @var array
     */
    protected $registered = [];

    /**
     * The container object.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app;

    /**
     * The class loader object.
     *
     * @var \Composer\Autoload\ClassLoader
     */
    protected $loader;

    /**
     * The files object.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new AddonManager instance.
     *
     * @param ClassLoader $loader
     */
    public function __construct(Container $app, ClassLoader $loader, Filesystem $files)
    {
        $this->app    = $app;
        $this->files  = $files;
        $this->loader = $loader;
    }

    /**
     * Register an addon's path and structure.
     */
    public function register()
    {
        $this->fire('before_register', [$this->app]);

        foreach ($this->allAddonPaths() as $path) {

            $slug = basename($path);
            $type = strtolower(str_singular(basename(dirname($path))));

            $abstract = $type . '.' . $slug;

            $namespace = 'Streams\Addon\\' . studly_case(basename($type)) . '\\' . studly_case($slug);

            $this->registered[$slug] = $info = compact('slug', 'type', 'abstract', 'namespace', 'path');

            $this->registerSrcPath($info);
            $this->registerVendorAutoload($info);
            $this->registerToContainer($info);

            $this->addNamespaceHints($info);
        }

        $this->loader->register();

        $this->fire('after_register', [$this->app]);

        return $this;
    }

    /**
     * Register the addons src path.
     *
     * @param $info
     */
    protected function registerSrcPath($info)
    {
        $this->loader->addPsr4(
            $info['namespace'] . '\\',
            $info['path'] . '/src'
        );
    }

    /**
     * Register the vendor autoloader for an addon.
     *
     * @param $info
     */
    public function registerVendorAutoload($info)
    {
        $vendorPath = $info['path'] . '/vendor/';
        $vendorFile = 'streams.vendor.autoload.php';

        if (is_file($vendorPath . $vendorFile)) {
            $autoload = require $vendorPath . $vendorFile;

            if (!empty($autoload['psr-0'])) {
                foreach ($autoload['psr-0'] as $namespace => $path) {
                    $this->loader->add($namespace, $this->makeVendorPsrPath($vendorPath, $path));
                }
            }

            if (!empty($autoload['psr-4'])) {
                foreach ($autoload['psr-4'] as $namespace => $path) {
                    $this->loader->addPsr4($namespace, $this->makeVendorPsrPath($vendorPath, $path));
                }
            }
        }
    }

    /**
     * Return the external PSR path for an addon.
     *
     * @param $vendorPath
     * @param $path
     * @return string
     */
    public function makeVendorPsrPath($vendorPath, $path)
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

    /**
     * Add namespace hints for other services.
     *
     * @param $info
     */
    public function addNamespaceHints($info)
    {
        app('view')->addNamespace($info['abstract'], $info['path'] . '/resources/views');
        app('config')->addNamespace($info['abstract'], $info['path'] . '/resources/config');

        app('streams.asset')->addNamespace($info['abstract'], $info['path'] . '/resources');
        app('streams.image')->addNamespace($info['abstract'], $info['path'] . '/resources');
    }

    /**
     * Register addon
     *
     * @param array $info
     * @return void
     */
    public function registerToContainer($info)
    {
        $this->app->{$this->method}(
            'streams.' . $info['abstract'],
            function () use ($info) {
                $class = $info['namespace'] . '\\' . studly_case($info['slug']) . studly_case($info['type']);

                $addon = new $class;

                $addon->setType($info['type']);
                $addon->setPath($info['path']);
                $addon->setSlug($info['slug']);
                $addon->setAbstract($info['abstract']);

                $addon->setInstalled(true);
                $addon->setEnabled(true);

                app('translator')->addNamespace($info['abstract'], $info['path'] . '/resources/lang');

                app('events')->fire($info['slug'] . '.' . $info['slug'] . 'make', [$addon]);

                return app('streams.decorator')->decorate($addon);
            }
        );
    }

    /**
     * Make an addon.
     *
     * @param $slug
     * @return mixed
     */
    public function make($slug)
    {
        return app('streams.' . str_singular($this->folder) . '.' . $slug);
    }

    /**
     * Get all addons.
     *
     * @return array
     */
    public function all()
    {
        return $this->newCollection(
            array_map(
                function ($info) {
                    return $this->make($info['slug']);
                },
                $this->registered
            )
        );
    }

    /**
     * Check if an addon exists.
     *
     * @param $slug
     */
    public function exists($slug)
    {
        return (isset($this->registered[$slug]));
    }

    /**
     * Return all addon paths.
     *
     * @return array
     */
    public function allAddonPaths()
    {
        $corePaths        = $this->coreAddonPaths();
        $sharedPaths      = $this->sharedAddonPaths();
        $applicationPaths = $this->applicationAddonPaths();

        return array_merge($corePaths, $sharedPaths, $applicationPaths);
    }

    /**
     * Return all core addon paths.
     *
     * @return array
     */
    public function coreAddonPaths()
    {
        $path = base_path('app/addons/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Return all shared addon paths.
     *
     * @return array
     */
    public function sharedAddonPaths()
    {
        $path = base_path('addons/shared/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Return all application addon paths.
     *
     * @return array
     */
    public function applicationAddonPaths()
    {
        $reference = app('streams.application')->getReference();
        $path      = base_path('addons/' . $reference . '/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Return a new addon collection.
     *
     * @param array $addons
     * @return AddonCollection
     */
    protected function newCollection(array $addons)
    {
        return new AddonCollection($addons);
    }
}