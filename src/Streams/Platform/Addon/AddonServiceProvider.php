<?php namespace Streams\Platform\Addon;

use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Streams\Platform\Traits\CallableTrait;

class AddonServiceProvider extends ServiceProvider
{
    use CallableTrait;

    protected $binding = 'singleton';

    protected $locations = [];

    protected $type;

    protected $folder;

    public function __construct(Application $app)
    {
        parent::__construct($app);

        $class = get_class($this);

        $type = snake_case(str_replace('ServiceProvider', '', substr($class, strrpos($class, "\\") + 1)));

        $this->type   = $type;
        $this->folder = str_plural($type);
    }

    public function register()
    {
        foreach ($this->getAddonPaths() as $path) {

            $slug = basename($path);

            // We have to register the PSR src folder
            // before we can continue.
            $this->registerSrcFolder($slug, $path);

            // Register the addon class to the container.
            $addon = $this->registerAddonClass($slug, $path);

            $this->pushToCollection($addon);
        }

        $this->fire('after_register');
    }

    protected function registerSrcFolder($slug, $path)
    {
        app('streams.loader')->addPsr4(
            $this->getNamespace($slug) . '\\',
            $path . '/src'
        );
    }

    protected function registerAddonClass($slug, $path)
    {
        $class = $this->getClass($slug);

        $addon = app('streams.decorator')->decorate(new $class($this->app));

        $this->app->{$this->binding}(
            $addon->getAbstract(),
            function () use ($addon) {
                return $addon;
            }
        );

        return $addon;
    }

    protected function pushToCollection($addon)
    {
        $plural = str_plural($this->type);

        app("streams.{$plural}")->push($addon);
    }

    protected function getAddonPaths()
    {
        $corePaths        = $this->getCoreAddonPaths();
        $sharedPaths      = $this->getSharedAddonPaths();
        $applicationPaths = $this->getApplicationAddonPaths();
        $otherPaths       = $this->getOtherPaths();

        return array_filter(array_merge($corePaths, $sharedPaths, $applicationPaths, $otherPaths));
    }

    protected function getCoreAddonPaths()
    {
        $paths = [];

        $path = base_path('core/addons/' . $this->folder);

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    protected function getSharedAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/shared/' . $this->folder);

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    protected function getApplicationAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/' . APP_REF . '/' . $this->folder);

        if (is_dir($path)) {

            $paths = app('files')->directories($path);

        }

        return $paths;
    }

    protected function getOtherPaths()
    {
        $paths = [];

        if (getenv('TEST')) {

            $this->locations[] = __DIR__ . '/../../../../tests/addons';

        }

        foreach ($this->locations as $location) {

            $path = $location . '/' . $this->folder;

            if (is_dir($path)) {

                $paths = array_merge($paths, app('files')->directories($path));

            }

        }

        return $paths;
    }

    public function addLocation($location)
    {
        $this->locations[] = $location;

        return $this;
    }

    protected function getNamespace($slug)
    {
        return 'Streams\Addon\\' . studly_case($this->type) . '\\' . studly_case($slug);
    }

    protected function getClass($slug)
    {
        return $this->getNamespace($slug) . '\\' . studly_case($slug) . studly_case($this->type);
    }
}
