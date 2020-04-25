<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Facades\App;

/**
 * Trait ProvidesProviders
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait ProvidesProviders
{

    /**
     * Extra providers to register.
     *
     * @var array
     */
    public $providers = [];

    /**
     * Register the additional providers.
     */
    protected function registerProviders()
    {
        foreach ($this->providers as $provider) {
            App::register($provider);
        }
    }
}
