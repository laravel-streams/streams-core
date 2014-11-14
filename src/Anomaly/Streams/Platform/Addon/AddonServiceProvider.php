<?php namespace Anomaly\Streams\Platform\Addon;


use Anomaly\Streams\Platform\Traits\CallableTrait;
use Anomaly\Streams\Platform\Traits\TransformableTrait;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

/**
 * Class AddonServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Addon
 */
class AddonServiceProvider extends ServiceProvider
{

    use CallableTrait;
    use TransformableTrait;

    /**
     * The IoC binding method to use.
     *
     * @var string
     */
    protected $binding = 'singleton';

    /**
     * The addon type.
     * This is set automatically.
     *
     * @var string
     */
    protected $type;

    /**
     * The addon type.
     * This is set automatically.
     * Follows plural of the type.
     *
     * @var string
     */
    protected $folder;

    /**
     * Create a new AddonServiceProvider instance.
     *
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        parent::__construct($app);

        $class = get_class($this);

        $type = snake_case(str_replace('ServiceProvider', '', substr($class, strrpos($class, "\\") + 1)));

        $this->type   = $type;
        $this->folder = str_plural($type);
    }

    /**
     * Register addons.
     */
    public function register()
    {
        foreach ($this->getAddonPaths() as $path) {

            $slug = basename($path);

            // We have to register the PSR src folder
            // before we can continue.
            $this->registerSrcFolder($slug, $path);

            // Register the addon class to the container.
            $addon = $this->registerAddonClass($slug, $path);

            // Register the addon service provider.
            //$this->registerServiceProvider($addon);

            $this->pushToCollection($addon);
        }

        $this->fire('after_register');
    }

    /**
     * Register the /src folder of each addon
     * for PSR-4 autoloading.
     *
     * @param $slug
     * @param $path
     */
    protected function registerSrcFolder($slug, $path)
    {
        app('streams.loader')->addPsr4(
            $this->getNamespace($slug) . '\\',
            $path . '/src'
        );
    }

    /**
     * Register the actual addon class.
     *
     * @param $slug
     * @param $path
     * @return mixed
     */
    protected function registerAddonClass($slug, $path)
    {
        $class = $this->getClass($slug);

        $addon = $this->app->make($class);

        $this->app->{$this->binding}(
            $addon->getAbstract(),
            function () use ($addon) {
                return $addon;
            }
        );

        return $addon;
    }

    /**
     * Register the addon's service provider and
     * run it's register method.
     *
     * @param $addon
     */
    protected function registerServiceProvider($addon)
    {
        if ($provider = $addon->toServiceProvider()) {

            $app      = $this->app;
            $provider = $this->app->make($provider, [$app]);

            $this->app->register($provider);

            $provider->register();
        }
    }

    /**
     * Push the addon class to it's respective collection class.
     *
     * @param $addon
     */
    protected function pushToCollection($addon)
    {
        $plural = str_plural($this->type);

        app("streams.{$plural}")->push($addon);
    }

    /**
     * Get the paths to look for addons in.
     *
     * @return array
     */
    protected function getAddonPaths()
    {
        $corePaths        = $this->getCoreAddonPaths();
        $sharedPaths      = $this->getSharedAddonPaths();
        $applicationPaths = $this->getApplicationAddonPaths();

        return array_filter(array_merge($corePaths, $sharedPaths, $applicationPaths));
    }

    /**
     * Get core addon paths.
     *
     * @return array
     */
    protected function getCoreAddonPaths()
    {
        $paths = [];

        $path = base_path('core/' . $this->folder);

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    /**
     * Get shared addon paths.
     *
     * @return array
     */
    protected function getSharedAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/shared/' . $this->folder);

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    /**
     * Get application specific paths.
     *
     * @return array
     */
    protected function getApplicationAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/' . APP_REF . '/' . $this->folder);

        if (is_dir($path)) {

            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    /**
     * Get the namespace prefix for an addon by slug.
     *
     * @param $slug
     * @return string
     */
    protected function getNamespace($slug)
    {
        return 'Anomaly\Streams\Addon\\' . studly_case($this->type) . '\\' . studly_case($slug);
    }

    /**
     * Get the class path for an addon by slug.
     *
     * @param $slug
     * @return string
     */
    protected function getClass($slug)
    {
        return $this->getNamespace($slug) . '\\' . studly_case($slug) . studly_case($this->type);
    }
}
