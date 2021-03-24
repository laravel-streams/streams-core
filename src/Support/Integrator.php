<?php

namespace Streams\Core\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Streams\Core\Support\Traits\FiresCallbacks;

class Integrator
{

    use FiresCallbacks;

    public function integrate($details)
    {
        foreach ($details as $type => $payload) {
            $this->{$type}($payload);
        }
    }

    public function locale($locale)
    {
        App::setLocale($locale);
    }

    public function config($config)
    {
        Config::set(Arr::dot(Arr::parse($config)));
    }

    public function bindings($bindings)
    {
        array_walk($bindings, function ($value, $key) {
            App::bind($key, $value);
        });
    }

    public function aliases($aliases)
    {
        array_walk($aliases, function ($value, $key) {
            App::alias($key, $value);
        });
    }

    public function singletons($singletons)
    {
        array_walk($singletons, function ($value, $key) {
            App::singleton($key, $value);
        });
    }
}
