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

            $binding = $type . '.' . $slug;

            $namespace = 'Streams\Addon\\' . studly_case(basename($type)) . '\\' . studly_case($slug);

            $this->registered[$slug] = compact('slug', 'type', 'binding', 'namespace');

            // Register src directory
            $this->registerPsr($slug, $namespace, $path);
            $this->registerVendorAutoload($path);
            $this->registerToContainer($slug, $type, $namespace, $path, $binding);

            $this->addNamespaceHints($path, $binding);
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
     * @param $binding
     */
    public function addNamespaceHints($path, $binding)
    {
        app('view')->addNamespace($binding, $path . '/resources/views');
        app('config')->addNamespace($binding, $path . '/resources/config');

        app('streams.asset')->addNamespace($binding, $path . '/resources');
        app('streams.image')->addNamespace($binding, $path . '/resources');
    }

    /**
     * Register addon
     *
     * @param array  $info
     * @param string $binding
     * @return void
     */
    public function registerToContainer($slug, $type, $namespace, $path, $binding)
    {
        $this->app->bind(
            'streams.' . $binding,
            function () use ($slug, $type, $namespace, $path, $binding) {
                $addonClass = $namespace . '\\' . studly_case($slug) . studly_case($type);

                /** @var $addon AddonAbstract */
                $addon = new $addonClass;

                // Add lang namespace
                \Lang::addNamespace($binding, $path . '/resources/lang');

                $addon->setType($type);
                $addon->setPath($path);
                $addon->setSlug($slug);

                $addon->binding = $binding;

                $addon->setInstalled(true);
                $addon->setEnabled(true);

                if ($serviceProvider = $addon->newServiceProvider()) {
                    \App::register($serviceProvider);
                }

                \Event::fire($addon->getType() . '.' . $addon->getSlug() . 'make', [$addon]);

                return app('streams.decorator')->decorate($addon);
            }
        );
    }

    /**
     * Get a single addon.
     *
     * @param string $slug
     * @param array  $parameters
     * @return AddonAbstract
     */
    public
    function find(
        $slug,
        $parameters = []
    ) {
        return \App::make('streams.' . str_singular($this->folder) . '.' . $slug, $parameters);
    }

    /**
     * Get all instantiated addons.
     *
     * @return array
     */
    public
    function all()
    {
        $addons = [];

        foreach ($this->registered as $info) {
            $addons[$info['slug']] = $this->find($info['slug']);
        }

        return $this->newCollection($addons);
    }

    /**
     * Check if an addon exists.
     *
     * @param $slug
     */
    public
    function exists(
        $slug
    ) {
        return (isset($this->registered[$slug]));
    }

    public function getClasses()
    {
        $classes = [];

        foreach ($this->registered as $info) {
            $classes[$info['slug']] = $info['namespace'] . '\\' . studly_case($info['slug']) . studly_case($info['type']);
        }

        return $classes;
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
        // @todo - this needs to be dynamic
        $path = base_path('addons/develop/' . $this->folder);

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
        return $this->find($slug)->newInstaller()->install();
    }

    /**
     * Uninstall a module.
     *
     * @param $slug
     * @return bool
     */
    public function uninstall($slug)
    {
        return $this->find($slug)->newInstaller()->uninstall();
    }

    /**
     * Return if an addon is installed or not.
     *
     * @param $slug
     * @return bool
     */
    public function isInstalled($slug)
    {
        return $this->find($slug)->isInstalled();
    }

    /**
     * Return if an addon is enabled or not.
     *
     * @param $slug
     * @return bool
     */
    public function isEnabled($slug)
    {
        return $this->find($slug)->isEnabled();
    }

    /**
     * Return a new model instance.
     *
     * @return mixed
     */
    protected function newModel()
    {
        return null;
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