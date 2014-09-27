<?php namespace Streams\Platform\Provider;

use Composer\Autoload\ClassLoader;
use Illuminate\Support\ServiceProvider;
use Streams\Platform\Foundation\AddonTypes;

class AddonServiceProvider extends ServiceProvider
{
    /**
     * Available addon types.
     *
     * @var array
     */
    protected $addonTypes = [
        //'distributions',
        'field_types',
        'extensions',
        'modules',
        'blocks',
        'themes',
        'tags',
    ];

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerClassLoader();
        $this->registerAddonTypes();
    }

    /**
     * Register class loader.
     */
    public function registerClassLoader()
    {
        $this->app->instance('streams.classloader', new ClassLoader);
    }

    /**
     * Register addon types.
     */
    public function registerAddonTypes()
    {
        $addonTypes = new AddonTypes($this->addonTypes);

        $addonTypes->register($this->app);

        $this->app->instance('streams.addon_types', $addonTypes);
    }
}
