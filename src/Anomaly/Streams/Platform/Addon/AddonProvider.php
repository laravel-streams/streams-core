<?php namespace Anomaly\Streams\Platform\Addon;

class AddonProvider
{
    public function register($type)
    {
        foreach (app('streams.' . str_plural($type)) as $addon) {

            $provider = get_class($addon) . 'ServiceProvider';

            if (!class_exists($provider)) {

                continue;
            }

            app()->register($provider);
        }
    }
}
