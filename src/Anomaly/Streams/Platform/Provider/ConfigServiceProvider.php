<?php namespace Anomaly\Streams\Platform\Provider;

use Illuminate\Config\Repository;

/**
 * Class ConfigServiceProvider
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\Streams\Platform\Provider
 */
class ConfigServiceProvider extends \Illuminate\Support\ServiceProvider
{

    /**
     * Defer loading this service provider.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach (app('streams.addon_types') as $type) {

            $type = str_plural($type);

            foreach (app("streams.{$type}") as $addon) {

                $abstract = str_replace('streams.', null, $addon->getAbstract());

                app('config')->afterLoading(
                    $abstract,
                    function (Repository $namespace, $group, $items) use ($abstract) {

                        list($type, $addon) = explode('.', $abstract);

                        $group = "streams/{$type}/{$addon}/" . $group;

                        $defaults  = app('config')->getLoader()->load(app()->environment(), $group);
                        $overrides = app('config')->getLoader()->load(app()->environment(), $group, 'theme');

                        return array_replace_recursive($items, array_replace_recursive($defaults, $overrides));
                    }
                );
            }
        }
    }
}
 