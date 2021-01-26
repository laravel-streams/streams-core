<?php

namespace Streams\Core\Addon;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class AddonManager
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonManager
{
    /**
     * The addon collection.
     *
     * @var Collection
     */
    protected $collection;

    /**
     * The disabled addons.
     *
     * @var array
     */
    protected $disabled;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->collection = new AddonCollection;
        $this->disabled = Config::get('streams.addons.disabled', []);;
    }

    /**
     * Load an addon by path.
     *
     * @param string $path
     */
    public function load($path)
    {
        $path = rtrim($path, '/\\');

        $composer = json_decode(file_get_contents($path . '/composer.json'), true);

        $addon = [
            'name' => $composer['name'],
            'path' => $path,
            'composer' => $composer,
        ];

        return $this->register($addon);
    }

    /**
     * Register an addon.
     */
    public function register($addon)
    {
        $addon['enabled'] = Arr::get($addon, 'enabled', !in_array($addon['name'], $this->disabled));

        $addon = $this->build($addon);

        App::instance('streams.addons.' . str_replace('/', '.', $addon->name), $addon);

        $this->collection->put($addon->name, $addon);

        return $addon;
    }

    public function make($name)
    {
        return App::make('streams.addons.' . str_replace('/', '.', $name));
    }

    /**
     * Build an addon instance.
     *
     * @param $addon
     * @return Addon
     */
    public function build($addon)
    {
        return new Addon($addon);
    }

    /**
     * Return the addon collection.
     */
    public function collection()
    {
        return $this->collection;
    }
}
