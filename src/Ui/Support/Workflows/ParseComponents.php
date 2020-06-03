<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Illuminate\Support\Arr;
use Anomaly\Streams\Platform\Ui\Support\Builder;

/**
 * Class ParseComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ParseComponents
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     * @param string $component
     */
    public function handle(Builder $builder, $component)
    {
        $builder->{$component} = Arr::parse($builder->{$component});
    }
}
