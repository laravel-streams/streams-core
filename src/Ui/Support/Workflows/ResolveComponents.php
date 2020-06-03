<?php

namespace Anomaly\Streams\Platform\Ui\Support\Workflows;

use Anomaly\Streams\Platform\Ui\Support\Builder;

/**
 * Class ResolveComponents
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ResolveComponents
{

    /**
     * Hand the step.
     *
     * @param Builder $builder
     * @param string $component
     */
    public function handle(Builder $builder, $component)
    {
        $resolved = resolver(
            $builder->{$component},
            ['builder' => $builder]
        );

        $builder->{$component} = evaluate(
            $resolved ?: $builder->{$component},
            ['builder' => $builder]
        );
    }
}
