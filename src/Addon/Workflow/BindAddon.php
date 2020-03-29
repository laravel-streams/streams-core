<?php

namespace Anomaly\Streams\Platform\Addon\Workflow;

use Anomaly\Streams\Platform\Addon\Addon;
use Illuminate\Contracts\Container\Container;

/**
 * Class BindAddon
 *
 * @link    http://pyrocms.com/
 * @author  PyroCMS, Inc. <support@pyrocms.com>
 * @author  Ryan Thompson <ryan@pyrocms.com>
 */
class BindAddon
{

    /**
     * Undocumented function
     *
     * @param string $addon
     */
    public function handle(Container $app, $addon, $namespace, $type, $slug, $vendor, $path)
    {
        $app->singleton($namespace, function ($app) use ($addon, $namespace, $type, $slug, $vendor, $path) {

            // @var Addon $addon
            $addon = $app->make($addon)
                ->setType($type)
                ->setSlug($slug)
                ->setVendor($vendor)
                ->setPath($path);

            if (!config('streams.installed')) {
                return $addon;
            }

            if ($data = app('addon.collection')->get($namespace)) {
                $addon->setEnabled(array_get($data, 'enabled'));
                $addon->setInstalled(array_get($data, 'installed'));
            }

            return $addon;
        });
    }
}
