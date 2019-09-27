<?php

namespace Anomaly\Streams\Platform\Addon;

use Anomaly\Streams\Platform\Addon\Extension\Extension;
use Anomaly\Streams\Platform\Addon\Module\Module;

/**
 * Class AddonOptimizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AddonOptimizer
{

    /**
     * Properties to optimize.
     *
     * @var array
     */
    protected $optimize = [
        'api',
        'routes',
        'aliases',
        'plugins',
        'plugins',
        'bindings',
        'commands',
        'listeners',
        'schedules',
        //'factories',
        'providers',
        'overrides',
        'middleware',
        'singletons',
        'group_middleware',
        'route_middleware',
    ];

    /**
     * The addon collection.
     *
     * @var AddonCollection
     */
    protected $addons;

    /**
     * Create a new AddonOptimizer instance.
     *
     * @param AddonCollection $addons
     */
    public function __construct(AddonCollection $addons)
    {
        $this->addons = $addons;
    }

    /**
     * Optimize addons.
     */
    public function optimize()
    {
        $manifest = [
            'config'     => [],
            'loaded'     => [],
            'mapped'     => [],
            'booted'     => [],
            'registered' => [],
        ];

        $config = array_dot(config()->all());

        /* @var Addon|Module|Extension $addon */
        foreach ($this->addons->loaded() as $addon) {

            $manifest['loaded'][$addon->getNamespace()] = $addon->toArray();

            $manifest['config'] = array_merge($manifest['config'], array_filter(
                $config,
                function ($key) use ($addon) {
                    return strpos($key, $addon->getNamespace() . '::') !== false;
                },
                ARRAY_FILTER_USE_KEY
            ));

            /* @var AddonServiceProvider $provider */
            $provider = class_exists($addon->getServiceProvider()) ? $addon->newServiceProvider() : null;

            if (!$provider) {
                continue;
            }

            if (method_exists($provider, 'register')) {
                $manifest['registered'][$addon->getNamespace()] = get_class($provider);
            }

            if (method_exists($provider, 'boot')) {
                $manifest['booted'][$addon->getNamespace()] = get_class($provider);
            }

            if (method_exists($provider, 'map')) {
                $manifest['mapped'][$addon->getNamespace()] = get_class($provider);
            }

            foreach ($this->optimize as $attribute) {

                if (method_exists($provider, $method = camel_case('get_' . $attribute))) {

                    $value = $provider->$method();

                    /**
                     * Pre-process routes and add
                     * the addon namespace action.
                     */
                    if (in_array($attribute, ['routes', 'api'])) {

                        foreach ($value as $uri => $route) {

                            if (!is_array($route)) {
                                $route = [
                                    'uses' => $route,
                                ];
                            }

                            array_set($route, 'streams::addon', $addon);
                        }
                    }

                    /**
                     * Stash the value in
                     * the addons manifest.
                     */
                    $manifest[$attribute] = array_merge(array_get($manifest, $attribute, []), $value);
                }
            }
        }

        file_put_contents(base_path('bootstrap/cache/addons.php'), '<?php return ' . var_export($manifest, true) . ';');
    }
}
