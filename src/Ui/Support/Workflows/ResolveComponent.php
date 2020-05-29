<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Ui\Support\Builder;
use Anomaly\Streams\Platform\Ui\Support\Processor;

/**
 * Class ResolveComponent
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ResolveComponent
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     */
    public function handle(Builder $builder)
    {
        (new Processor($builder))->resolve($builder->component);
    }
}
