<?php namespace Streams\Platform\Addon\Manager;

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
     * The container method.
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
     * Enable PSR
     *
     * @var bool
     */
    protected $enablePsr = true;

    /**
     * Model data.
     *
     * @var array
     */
    protected $data = [];

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

        $this->loadData();

        foreach ($this->getAllAddonPaths() as $path) {

            $slug = basename($path);
            $type = strtolower(str_singular(basename(dirname($path))));

            $abstract = $type . '.' . $slug;

            $namespace = 'Streams\Addon\\' . studly_case(basename($type)) . '\\' . studly_case($slug);

            $this->registered[$slug] = compact('slug', 'type', 'binding', 'namespace');

            // Register src directory
            $this->registerPsr($slug, $namespace, $path);
            $this->registerVendorAutoload($path);
            $this->registerToContainer($slug, $type, $namespace, $path, $abstract);

            $this->addNamespaceHints($path, $abstract);
        }

        $this->loader->register();

        $this->fire('after_register', [$this->app]);

        return $this;
    }

    /**
     * Load data from the database.
     */
    protected function loadData()
    {
        $this->application = app('streams.application');

        if ($this->storage and $this->application->locate()) {
            $table = $this->application->getReference() . '_addons_' . $this->folder;

            $data = \DB::table($table)->get();

            foreach ($data as $addon) {
                $this->data[$addon->slug] = $addon;
            }
        }
    }

    /**
     * Register PSR
     *
     * @param $type
     * @param $slug
     * @param $path
     */
    public function registerPsr($slug, $namespace, $path)
    {
        if ($this->enablePsr) {
            $this->loader->addPsr4(
                $namespace . '\\',
                $path . '/src'
            );

            $this->registered[$slug]['namespace'] = $namespace;
        }
    }

    /**
     * Register vendor autoload from a addon
     *
     * @param $addonPath
     */
    public function registerVendorAutoload($addonPath)
    {
        if (!$this->enablePsr) {
            return;
        }

        $vendorPath = $addonPath . '/vendor/';
        $vendorFile = 'streams.vendor.autoload.php';

        if (is_file($vendorPath . $vendorFile)) {
            $autoload = require $vendorPath . $vendorFile;

            if (!empty($autoload['psr-0'])) {
                foreach ($autoload['psr-0'] as $namespace => $path) {
                    $this->loader->add($namespace, $this->getVendorPsrPath($vendorPath, $path));
                }
            }

            if (!empty($autoload['psr-4'])) {
                foreach ($autoload['psr-4'] as $namespace => $path) {
                    $this->loader->addPsr4($namespace, $this->getVendorPsrPath($vendorPath, $path));
                }
            }
        }
    }

    /**
     * Get external PSR path
     *
     * @param $vendorPath
     * @param $path
     * @return string
     */
    public function getVendorPsrPath($vendorPath, $path)
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
     * @param $path
     * @param $abstract
     */
    public function addNamespaceHints($path, $abstract)
    {
        app('view')->addNamespace($abstract, $path . '/resources/views');
        app('config')->addNamespace($abstract, $path . '/resources/config');

        app('streams.asset')->addNamespace($abstract, $path . '/resources');
        app('streams.image')->addNamespace($abstract, $path . '/resources');
    }

    /**
     * Register addon
     *
     * @param array  $info
     * @param string $abstract
     * @return void
     */
    public function registerToContainer($slug, $type, $namespace, $path, $abstract)
    {
        $this->app->{$this->method}(
            'streams.' . $abstract,
            function () use ($slug, $type, $namespace, $path, $abstract) {
                $class = $namespace . '\\' . studly_case($slug) . studly_case($type);

                $addon = new $class;

                app('translator')->addNamespace($abstract, $path . '/resources/lang');

                $addon->setType($type);
                $addon->setPath($path);
                $addon->setSlug($slug);
                $addon->setAbstract($abstract);

                $addon->register();

                $addon->setInstalled(true);
                $addon->setEnabled(true);

                app('events')->fire($slug . '.' . $slug . 'make', [$addon]);

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
     * Get the classes of registered addons.
     *
     * @return array
     */
    public function getClasses()
    {
        return array_map(
            function ($addon) {
                return get_class($addon->getResource());
            },
            $this->all()->all()
        );
    }

    /**
     * Get all addon paths.
     *
     * @return array
     */
    public function getAllAddonPaths()
    {
        $corePaths              = $this->getCoreAddonPaths();
        $sharedPaths            = $this->getSharedAddonPaths();
        $this->applicationPaths = $this->getApplicationAddonPaths();

        return array_merge($corePaths, $sharedPaths, $this->applicationPaths);
    }

    /**
     * Get all core addon paths.
     *
     * @return array
     */
    public function getCoreAddonPaths()
    {
        $path = base_path('app/addons/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Get all shared addon paths.
     *
     * @return array
     */
    public function getSharedAddonPaths()
    {
        $path = base_path('addons/shared/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Get all application addon paths.
     *
     * @return array
     */
    public function getApplicationAddonPaths()
    {
        $reference = app('streams.application')->getReference();
        $path      = base_path('addons/' . $reference . '/' . $this->folder);

        if (is_dir($path)) {
            return $this->files->directories($path);
        }

        return [];
    }

    /**
     * Install a module.
     *
     * @param $slug
     * @return bool
     */
    public function install($slug)
    {
        return $this->make($slug)->install();
    }

    /**
     * Uninstall a module.
     *
     * @param $slug
     * @return bool
     */
    public function uninstall($slug)
    {
        return $this->make($slug)->uninstall();
    }

    /**
     * Return if an addon is installed or not.
     *
     * @param $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        return $this->make($slug)->isInstalled();
    }

    /**
     * Return if an addon is enabled or not.
     *
     * @param $slug
     * @return bool
     */
    public function isEnabled($slug)
    {
        return $this->make($slug)->isEnabled();
    }

    /**
     * Return a new collection instance.
     *
     * @param array $items
     * @return null
     */
    protected function newCollection(array $items = [])
    {
        return null;
    }
}