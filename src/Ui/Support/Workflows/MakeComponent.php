<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Support\Facades\Hydrator;

/**
 * Class MakeComponent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeComponent
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        $component = app($this->builder->{$builder->component});

        Hydrator::hydrate($component);

        $this->builder->{$builder->component} = $component;
    }
}
