<?php

namespace Anomaly\Streams\Platform\Provider\Concerns;

use Illuminate\Support\Facades\Gate;

/**
 * Trait RegistersPolicies
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
trait RegistersPolicies
{

    /**
     * The gate policies.
     *
     * @var array
     */
    public $policies = [];

    /**
     * Register policies
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
