<?php namespace Streams\Platform\Addon;

use Illuminate\Support\ServiceProvider;
use Streams\Platform\Traits\CallableTrait;

class AddonServiceProvider extends ServiceProvider
{
    use CallableTrait;

    protected $type = null;

    protected $binding = 'singleton';

    protected $locations = [];

    public function register()
    {
        $loaded = [];

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

        $addon = (new $class($this->app))->setPath($path);

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
        $plural = str_plural($this->getType());

        app("streams.{$plural}")->push($addon);
    }

    protected function getAddonPaths()
    {
        $corePaths        = $this->getCoreAddonPaths();
        $sharedPaths      = $this->getSharedAddonPaths();
        $applicationPaths = $this->getApplicationAddonPaths();
        $otherPaths       = $this->getOtherPaths();

        return array_merge($corePaths, $sharedPaths, $applicationPaths, $otherPaths);
    }

    protected function getCoreAddonPaths()
    {
        $paths = [];

        $path = base_path('core/addons/' . $this->getFolder());

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    protected function getSharedAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/shared/' . $this->getFolder());

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    protected function getApplicationAddonPaths()
    {
        $paths = [];

        $path = base_path('addons/' . APP_REF . '/' . $this->getFolder());

        if (is_dir($path)) {
            $paths = app('files')->directories($path);
        }

        return $paths;
    }

    protected function getOtherPaths()
    {
        $paths = [];

        foreach ($this->locations as $location) {

            $path = base_path($location . '/' . $this->getFolder());

            if (is_dir($path)) {

                $paths = array_merge($paths, app('files')->directories($path));

            }

        }

        return $paths;
    }

    protected function getType()
    {
        return $this->type;
    }

    protected function getFolder()
    {
        return str_plural($this->getType());
    }

    protected function getNamespace($slug)
    {
        return 'Streams\Addon\\' . studly_case($this->getType()) . '\\' . studly_case($slug);
    }

    protected function getClass($slug)
    {
        return $this->getNamespace($slug) . '\\' . studly_case($slug) . studly_case($this->getType());
    }

    public function addLocation($location)
    {
        $this->locations[] = $location;

        return $this;
    }
}
