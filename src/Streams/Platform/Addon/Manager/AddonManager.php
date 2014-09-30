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
     * The folder within addons locations to load modules from.
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
    protected $registeredAddons = [];

    /**
     * The name of the generated file
     *
     * @var string
     */
    protected $vendorAutoloadFilename = 'streams.vendor.autoload.php';

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
     * Create a new AddonManager instance.
     *
     * @param ClassLoader $loader
     */
    public function __construct(ClassLoader $loader, Filesystem $files)
    {
        $this->loader = $loader;
        $this->files  = $files;
    }

    /**
     * Register an addon's path and structure.
     */
    public function register(Container $app)
    {
        $this->fire('before_register', [$app]);

        $this->loadData();

        foreach ($this->getAllAddonPaths() as $path) {

            $slug = basename($path);

            $type = strtolower(str_singular(basename(dirname($path))));

            // All we are going to do here is add namespaces,
            // include dependent files and register PSR-4 paths.
            $this->registerInfo($type, $slug, $path);

            // Register src directory
            $this->registerPsr($type, $slug, $path);
        }

        foreach ($this->registeredAddons as $info) {

            $binding = $info['type'] . '.' . $info['slug'];

            // The vendor autoload files must be registered in this second
            // iteration, if done in the first, it brakes routes
            $this->registerVendorAutoload($info['path']);

            $this->registerComponents($info['path'], $binding);

            $this->requireFiles($info['path']);

            // Register a singleton addon
            $this->registerToContainer($app, $info, $binding);
        }

        $this->loader->register();

        $this->fire('after_register', [$app]);
    }

    /**
     * Load data from the database.
     */
    protected function loadData()
    {
        $application = app()->make('streams.application');

        if ($this->storage and $application->locate()) {
            $table = $application->getReference() . '_addons_' . $this->folder;

            $data = \DB::table($table)->get();

            foreach ($data as $addon) {
                $this->data[$addon->slug] = $addon;
            }
        }
    }

    /**
     * Register addon info
     *
     * @param $type
     * @param $slug
     * @param $path
     */
    public function registerInfo($type, $slug, $path)
    {
        $this->registeredAddons[$slug] = [
            'type' => $type,
            'slug' => $slug,
            'path' => $path,
        ];
    }

    /**
     * Register PSR
     *
     * @param $type
     * @param $slug
     * @param $path
     */
    public function registerPsr($type, $slug, $path)
    {
        if ($this->enablePsr) {

            $namespace = $this->getNamespace($type, $slug);

            /** @var $app ClassLoader */
            $this->loader->addPsr4(
                $namespace . '\\',
                $path . '/src'
            );

            $this->registeredAddons[$slug]['namespace'] = $namespace;
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

        if (is_file($vendorPath . $this->vendorAutoloadFilename)) {

            $autoload = require $vendorPath . $this->vendorAutoloadFilename;

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
     * Register components
     *
     * @param $path
     * @param $binding
     */
    public function registerComponents($path, $binding)
    {
        // Add config namespace
        \Config::addNamespace($binding, $path . '/resources/config');

        // Add asset and view paths
        \View::addNamespace($binding, $path . '/resources/views');
        \Asset::addNamespace($binding, $path . '/resources');
        \Image::addNamespace($binding, $path . '/resources');
    }

    /**
     * Require files
     *
     * @param $path
     */
    public function requireFiles($path)
    {
        $slug = basename($path);

        if ($this->storage and (isset($this->data[$slug]) and $this->data[$slug]->is_installed)) {
            $load = [
                'helpers.php',
                'routes.php',
            ];

            // Load the files.
            foreach ($load as $file) {
                if (is_file($path . '/' . $file)) {
                    require $path . '/' . $file;
                }
            }
        }
    }

    /**
     * Register addon
     *
     * @param array  $info
     * @param string $binding
     * @return void
     */
    public function registerToContainer(Container $app, array $info, $binding)
    {
        $app->bind(
            'streams.' . $info['type'] . '.' . $info['slug'],
            function () use ($info, $binding) {
                $addonClass = $this->getClass($info['slug']);

                /** @var $addon AddonAbstract */
                $addon = new $addonClass;

                // Add lang namespace
                \Lang::addNamespace($binding, $info['path'] . '/resources/lang');

                $addon->setType($info['type']);
                $addon->setPath($info['path']);
                $addon->setSlug($info['slug']);
                $addon->binding = $binding;

                if ($this->storage) {
                    $addon->setInstalled(
                        isset($this->data[$info['slug']]) and $this->data[$info['slug']]->is_installed
                    );
                    $addon->setEnabled(isset($this->data[$info['slug']]) and $this->data[$info['slug']]->is_enabled);
                } else {
                    $addon->setInstalled(true);
                    $addon->setEnabled(true);
                }

                if ($serviceProvider = $addon->newServiceProvider()) {
                    \App::register($serviceProvider);
                }

                \Event::fire($addon->getType() . '.' . $addon->getSlug() . 'make', [$addon]);

                return \Decorator::decorate($addon);
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
    public function find($slug, $parameters = [])
    {
        return \App::make('streams.' . str_singular($this->folder) . '.' . $slug, $parameters);
    }

    /**
     * Get all instantiated addons.
     *
     * @return array
     */
    public function all()
    {
        $addons = [];

        foreach ($this->registeredAddons as $info) {
            $addons[$info['slug']] = $this->find($info['slug']);
        }

        return $this->newCollection($addons);
    }

    /**
     * Check if an addon exists.
     *
     * @param $slug
     */
    public function exists($slug)
    {
        return (isset($this->registeredAddons[$slug]));
    }

    public function getClasses()
    {
        $classes = [];

        foreach ($this->registeredAddons as $info) {
            $classes[$info['slug']] = $this->getClass($info['slug']);
        }

        return $classes;
    }

    /**
     * Get the addon class suffix.
     *
     * @param $type
     * @param $slug
     * @return string
     */
    public function getNamespace($type, $slug)
    {
        return 'Streams\Addon\\' . studly_case(basename($type)) . '\\' . studly_case($slug);
    }

    /**
     * Return the addon class.
     *
     * @param $slug
     * @return string
     */
    public function getClass($slug)
    {
        $info = $this->registeredAddons[$slug];

        return $info['namespace'] . '\\' . studly_case($info['slug']) . studly_case($info['type']);
    }

    /**
     * Get all addon paths.
     *
     * @return array
     */
    public function getAllAddonPaths()
    {
        $corePaths        = $this->getCoreAddonPaths();
        $sharedPaths      = $this->getSharedAddonPaths();
        $applicationPaths = $this->getApplicationAddonPaths();

        return array_merge($corePaths, $sharedPaths, $applicationPaths);
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